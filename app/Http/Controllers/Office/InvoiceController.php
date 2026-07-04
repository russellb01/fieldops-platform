<?php

namespace App\Http\Controllers\Office;

use App\Http\Controllers\Controller;
use App\Models\FieldOps\Customer;
use App\Models\FieldOps\Estimate;
use App\Models\FieldOps\Invoice;
use App\Models\FieldOps\InvoiceItem;
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
        $data = $this->validatedInvoiceData($request);

        $quantity = (float) ($request->input('quantity') ?? 1);
        $unitPrice = (float) ($request->input('unit_price') ?? 0);
        $lineTotal = round($quantity * $unitPrice, 2);
        $tax = round((float) ($request->input('tax') ?? 0), 2);
        $amountPaid = round((float) ($request->input('amount_paid') ?? 0), 2);
        $total = $lineTotal + $tax;

        $invoice = Invoice::create([
            ...$data,
            'invoice_number' => $this->nextNumber(),
            'tax' => $tax,
            'subtotal' => $lineTotal,
            'total' => $total,
            'amount_paid' => $amountPaid,
            'balance' => $total - $amountPaid,
        ]);

        $invoice->items()->create([
            'description' => (string) $request->input('line_description', 'Service'),
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

    public function edit(Invoice $invoice): View
    {
        $invoice->load(['customer', 'serviceLocation', 'estimate', 'items']);

        return view('office.invoices.edit', [
            'invoice' => $invoice,
            'customers' => Customer::orderBy('display_name')->get(),
            'locations' => ServiceLocation::with('customer')->orderBy('address')->get(),
            'estimates' => Estimate::with('customer')->latest()->limit(100)->get(),
        ]);
    }

    public function update(Request $request, Invoice $invoice): RedirectResponse
    {
        $data = $this->validatedInvoiceData($request);

        $invoice->update([
            ...$data,
            'tax' => round((float) $request->input('tax', 0), 2),
            'amount_paid' => round((float) $request->input('amount_paid', 0), 2),
        ]);

        $this->recalculate($invoice);

        return redirect()->route('office.invoices.show', $invoice)->with('success', 'Invoice updated.');
    }

    public function addItem(Request $request, Invoice $invoice): RedirectResponse
    {
        $data = $request->validate([
            'line_type' => ['nullable', 'string', 'max:80'],
            'description' => ['required', 'string'],
            'quantity' => ['required', 'numeric', 'min:0'],
            'unit_price' => ['required', 'numeric', 'min:0'],
        ]);

        $quantity = (float) $data['quantity'];
        $unitPrice = (float) $data['unit_price'];

        $invoice->items()->create([
            'line_type' => $data['line_type'] ?? 'service',
            'description' => $data['description'],
            'quantity' => $quantity,
            'unit_price' => $unitPrice,
            'total' => round($quantity * $unitPrice, 2),
        ]);

        $this->recalculate($invoice);

        return back()->with('success', 'Invoice line item added.');
    }

    public function deleteItem(Invoice $invoice, InvoiceItem $item): RedirectResponse
    {
        if ($item->invoice_id !== $invoice->id) {
            abort(404);
        }

        $item->delete();
        $this->recalculate($invoice);

        return back()->with('success', 'Invoice line item removed.');
    }

    public function print(Invoice $invoice): View
    {
        $invoice->load(['customer', 'serviceLocation', 'estimate', 'items']);

        return view('office.print.invoice', compact('invoice'));
    }

    private function validatedInvoiceData(Request $request): array
    {
        return $request->validate([
            'customer_id' => ['required', 'exists:fieldops_customers,id'],
            'service_location_id' => ['nullable', 'exists:fieldops_service_locations,id'],
            'estimate_id' => ['nullable', 'exists:fieldops_estimates,id'],
            'title' => ['required', 'string', 'max:255'],
            'status' => ['required', 'string', 'max:40'],
            'service_date' => ['nullable', 'date'],
            'due_date' => ['nullable', 'date'],
            'notes' => ['nullable', 'string'],
        ]);
    }

    private function recalculate(Invoice $invoice): void
    {
        $invoice->load('items');

        $subtotal = round((float) $invoice->items->sum('total'), 2);
        $tax = round((float) $invoice->tax, 2);
        $amountPaid = round((float) $invoice->amount_paid, 2);
        $total = $subtotal + $tax;
        $balance = $total - $amountPaid;

        $status = $invoice->status;
        if ($balance <= 0 && $total > 0) {
            $status = 'paid';
            $balance = 0;
        } elseif ($amountPaid > 0 && $balance > 0) {
            $status = 'partial';
        }

        $invoice->update([
            'subtotal' => $subtotal,
            'tax' => $tax,
            'total' => $total,
            'amount_paid' => $amountPaid,
            'balance' => $balance,
            'status' => $status,
        ]);
    }

    private function nextNumber(): string
    {
        return 'INV-' . now()->format('Y') . '-' . str_pad((string) ((Invoice::max('id') ?? 0) + 1), 5, '0', STR_PAD_LEFT);
    }
}
