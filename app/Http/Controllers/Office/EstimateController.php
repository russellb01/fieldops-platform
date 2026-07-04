<?php

namespace App\Http\Controllers\Office;

use App\Http\Controllers\Controller;
use App\Models\FieldOps\Customer;
use App\Models\FieldOps\Estimate;
use App\Models\FieldOps\EstimateItem;
use App\Models\FieldOps\Invoice;
use App\Models\FieldOps\ServiceLocation;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EstimateController extends Controller
{
    public function index(): View
    {
        return view('office.estimates.index', [
            'estimates' => Estimate::with('customer')->latest()->paginate(25),
        ]);
    }

    public function create(): View
    {
        return view('office.estimates.create', [
            'customers' => Customer::orderBy('display_name')->get(),
            'locations' => ServiceLocation::with('customer')->orderBy('address')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validatedEstimateData($request);

        $quantity = (float) ($request->input('quantity') ?? 1);
        $unitPrice = (float) ($request->input('unit_price') ?? 0);
        $lineTotal = round($quantity * $unitPrice, 2);
        $tax = round((float) ($request->input('tax') ?? 0), 2);

        $estimate = Estimate::create([
            ...$data,
            'estimate_number' => $this->nextNumber(),
            'subtotal' => $lineTotal,
            'tax' => $tax,
            'total' => $lineTotal + $tax,
        ]);

        $estimate->items()->create([
            'description' => (string) $request->input('line_description', 'Service'),
            'quantity' => $quantity,
            'unit_price' => $unitPrice,
            'total' => $lineTotal,
        ]);

        return redirect()->route('office.estimates.show', $estimate)->with('success', 'Estimate created.');
    }

    public function show(Estimate $estimate): View
    {
        $estimate->load(['customer', 'serviceLocation', 'items']);

        return view('office.estimates.show', compact('estimate'));
    }

    public function edit(Estimate $estimate): View
    {
        $estimate->load(['customer', 'serviceLocation', 'items']);

        return view('office.estimates.edit', [
            'estimate' => $estimate,
            'customers' => Customer::orderBy('display_name')->get(),
            'locations' => ServiceLocation::with('customer')->orderBy('address')->get(),
        ]);
    }

    public function update(Request $request, Estimate $estimate): RedirectResponse
    {
        $data = $this->validatedEstimateData($request);

        $estimate->update([
            ...$data,
            'tax' => round((float) $request->input('tax', 0), 2),
        ]);

        $this->recalculate($estimate);

        return redirect()->route('office.estimates.show', $estimate)->with('success', 'Estimate updated.');
    }

    public function addItem(Request $request, Estimate $estimate): RedirectResponse
    {
        $data = $request->validate([
            'line_type' => ['nullable', 'string', 'max:80'],
            'description' => ['required', 'string'],
            'quantity' => ['required', 'numeric', 'min:0'],
            'unit_price' => ['required', 'numeric', 'min:0'],
        ]);

        $quantity = (float) $data['quantity'];
        $unitPrice = (float) $data['unit_price'];

        $estimate->items()->create([
            'line_type' => $data['line_type'] ?? 'service',
            'description' => $data['description'],
            'quantity' => $quantity,
            'unit_price' => $unitPrice,
            'total' => round($quantity * $unitPrice, 2),
        ]);

        $this->recalculate($estimate);

        return back()->with('success', 'Estimate line item added.');
    }

    public function deleteItem(Estimate $estimate, EstimateItem $item): RedirectResponse
    {
        if ($item->estimate_id !== $estimate->id) {
            abort(404);
        }

        $item->delete();
        $this->recalculate($estimate);

        return back()->with('success', 'Estimate line item removed.');
    }

    public function print(Estimate $estimate): View
    {
        $estimate->load(['customer', 'serviceLocation', 'items']);

        return view('office.print.estimate', compact('estimate'));
    }

    public function convertToInvoice(Estimate $estimate): RedirectResponse
    {
        $estimate->load(['items', 'customer', 'serviceLocation']);

        $invoice = Invoice::create([
            'invoice_number' => $this->nextInvoiceNumber(),
            'customer_id' => $estimate->customer_id,
            'service_location_id' => $estimate->service_location_id,
            'estimate_id' => $estimate->id,
            'title' => $estimate->title,
            'status' => 'draft',
            'service_date' => now()->toDateString(),
            'due_date' => now()->addDays(14)->toDateString(),
            'subtotal' => $estimate->subtotal,
            'tax' => $estimate->tax,
            'total' => $estimate->total,
            'amount_paid' => 0,
            'balance' => $estimate->total,
            'notes' => $estimate->scope_of_work,
        ]);

        foreach ($estimate->items as $item) {
            $invoice->items()->create([
                'line_type' => $item->line_type,
                'description' => $item->description,
                'quantity' => $item->quantity,
                'unit_price' => $item->unit_price,
                'total' => $item->total,
            ]);
        }

        $estimate->update([
            'status' => 'approved',
            'approved_at' => $estimate->approved_at ?: now(),
        ]);

        return redirect()->route('office.invoices.show', $invoice)->with('success', 'Estimate converted to invoice.');
    }

    private function validatedEstimateData(Request $request): array
    {
        return $request->validate([
            'customer_id' => ['required', 'exists:fieldops_customers,id'],
            'service_location_id' => ['nullable', 'exists:fieldops_service_locations,id'],
            'title' => ['required', 'string', 'max:255'],
            'status' => ['required', 'string', 'max:40'],
            'issue_summary' => ['nullable', 'string'],
            'scope_of_work' => ['nullable', 'string'],
            'valid_until' => ['nullable', 'date'],
        ]);
    }

    private function recalculate(Estimate $estimate): void
    {
        $estimate->load('items');

        $subtotal = round((float) $estimate->items->sum('total'), 2);
        $tax = round((float) $estimate->tax, 2);

        $estimate->update([
            'subtotal' => $subtotal,
            'tax' => $tax,
            'total' => $subtotal + $tax,
        ]);
    }

    private function nextNumber(): string
    {
        return 'EST-' . now()->format('Y') . '-' . str_pad((string) ((Estimate::max('id') ?? 0) + 1), 5, '0', STR_PAD_LEFT);
    }

    private function nextInvoiceNumber(): string
    {
        return 'INV-' . now()->format('Y') . '-' . str_pad((string) ((Invoice::max('id') ?? 0) + 1), 5, '0', STR_PAD_LEFT);
    }
}
