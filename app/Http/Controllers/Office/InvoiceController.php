<?php

namespace App\Http\Controllers\Office;

use App\Http\Controllers\Controller;
use App\Models\FieldOps\Customer;
use App\Models\FieldOps\Estimate;
use App\Models\FieldOps\Invoice;
use App\Models\FieldOps\ServiceLocation;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class InvoiceController extends Controller
{
    public function index(): View
    {
        return view('office.invoices.index', [
            'invoices' => Invoice::with('customer')->latest()->paginate(25),
        ]);
    }

    public function create(): View
    {
        return view('office.invoices.create', [
            'customers' => Customer::orderBy('display_name')->get(),
            'locations' => ServiceLocation::with('customer')->orderBy('address')->get(),
            'estimates' => Estimate::with('customer')->latest()->limit(100)->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'customer_id' => ['required', 'exists:fieldops_customers,id'],
            'service_location_id' => ['nullable', 'exists:fieldops_service_locations,id'],
            'estimate_id' => ['nullable', 'exists:fieldops_estimates,id'],
            'title' => ['required', 'string', 'max:255'],
            'status' => ['required', 'string', 'max:40'],
            'service_date' => ['nullable', 'date'],
            'due_date' => ['nullable', 'date'],
            'notes' => ['nullable', 'string'],
            'line_description' => ['required', 'string'],
            'quantity' => ['nullable', 'numeric', 'min:0'],
            'unit_price' => ['nullable', 'numeric', 'min:0'],
            'tax' => ['nullable', 'numeric', 'min:0'],
            'amount_paid' => ['nullable', 'numeric', 'min:0'],
        ]);

        $quantity = (float) ($data['quantity'] ?? 1);
        $unitPrice = (float) ($data['unit_price'] ?? 0);
        $lineTotal = round($quantity * $unitPrice, 2);
        $tax = round((float) ($data['tax'] ?? 0), 2);
        $amountPaid = round((float) ($data['amount_paid'] ?? 0), 2);
        $total = $lineTotal + $tax;

        $invoice = Invoice::create([
            'invoice_number' => $this->nextNumber(),
            'customer_id' => $data['customer_id'],
            'service_location_id' => $data['service_location_id'] ?? null,
            'estimate_id' => $data['estimate_id'] ?? null,
            'title' => $data['title'],
            'status' => $data['status'],
            'service_date' => $data['service_date'] ?? null,
            'due_date' => $data['due_date'] ?? null,
            'subtotal' => $lineTotal,
            'tax' => $tax,
            'total' => $total,
            'amount_paid' => $amountPaid,
            'balance' => $total - $amountPaid,
            'notes' => $data['notes'] ?? null,
        ]);

        $invoice->items()->create([
            'description' => $data['line_description'],
            'quantity' => $quantity,
            'unit_price' => $unitPrice,
            'total' => $lineTotal,
        ]);

        return redirect()->route('office.invoices.show', $invoice)->with('success', 'Invoice created.');
    }

    public function show(Invoice $invoice): View
    {
        $invoice->load(['customer', 'serviceLocation', 'estimate', 'items']);

        return view('office.invoices.show', compact('invoice'));
    }

    private function nextNumber(): string
    {
        return 'INV-' . now()->format('Y') . '-' . str_pad((string) ((Invoice::max('id') ?? 0) + 1), 5, '0', STR_PAD_LEFT);
    }
}
