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
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;
use Throwable;

class InvoiceController extends Controller
{
    public function index(): View
    {
        return view('office.invoices.index', [
            'invoices' => Invoice::with('customer')->latest()->paginate(25),
        ]);
    }

    public function create(Request $request): View
    {
        return view('office.invoices.create', [
            'customers' => Customer::orderBy('display_name')->get(),
            'locations' => ServiceLocation::with('customer')->orderBy('address')->get(),
            'estimates' => Estimate::with('customer')->latest()->limit(100)->get(),
            'selectedCustomerId' => $request->integer('customer_id') ?: null,
            'selectedLocationId' => $request->integer('service_location_id') ?: null,
            'selectedEstimateId' => $request->integer('estimate_id') ?: null,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validatedInvoiceData($request);
        $items = $this->lineItemsFromRequest($request);
        $tax = round((float) ($request->input('tax') ?? 0), 2);
        $amountPaid = round((float) ($request->input('amount_paid') ?? 0), 2);
        $subtotal = round(collect($items)->sum('total'), 2);
        $total = $subtotal + $tax;

        if (count($items) === 0) {
            return back()->withInput()->withErrors(['line_items' => 'Add at least one invoice line item.']);
        }

        $invoice = Invoice::create([
            ...$data,
            'invoice_number' => $this->nextNumber(),
            'subtotal' => $subtotal,
            'tax' => $tax,
            'total' => $total,
            'amount_paid' => $amountPaid,
            'balance' => max(0, $total - $amountPaid),
        ]);

        foreach ($items as $item) {
            $invoice->items()->create($item);
        }

        $this->recalculate($invoice);

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
            'unit_price' => ['required', 'numeric'],
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

    public function email(Invoice $invoice): View
    {
        $invoice->load(['customer', 'serviceLocation', 'estimate', 'items']);

        $defaultTo = $invoice->customer?->billing_email ?: $invoice->customer?->email;

        return view('office.invoices.email', [
            'invoice' => $invoice,
            'defaultTo' => $defaultTo,
            'defaultSubject' => 'Invoice ' . $invoice->invoice_number . ' from Loudon Mechanical Services',
            'defaultMessage' => "Hello,\n\nAttached below is your invoice from Loudon Mechanical Services. Please call us at 865-964-6348 with any questions.\n\nThank you,\nLoudon Mechanical Services",
        ]);
    }

    public function sendEmail(Request $request, Invoice $invoice): RedirectResponse
    {
        $invoice->load(['customer', 'serviceLocation', 'estimate', 'items']);

        $data = $request->validate([
            'to' => ['required', 'email'],
            'subject' => ['required', 'string', 'max:255'],
            'message' => ['nullable', 'string'],
        ]);

        try {
            Mail::send('office.emails.invoice', [
                'invoice' => $invoice,
                'bodyMessage' => $data['message'] ?? '',
            ], function ($message) use ($data) {
                $message->to($data['to'])
                    ->subject($data['subject']);
            });
        } catch (Throwable $e) {
            return back()->withInput()->withErrors(['email' => 'Email could not be sent: ' . $e->getMessage()]);
        }

        $invoice->update([
            'status' => $invoice->status === 'draft' ? 'sent' : $invoice->status,
        ]);

        return redirect()->route('office.invoices.show', $invoice)->with('success', 'Invoice emailed to ' . $data['to'] . '.');
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

    private function lineItemsFromRequest(Request $request): array
    {
        $descriptions = $request->input('line_description', []);
        $types = $request->input('line_type', []);
        $quantities = $request->input('quantity', []);
        $unitPrices = $request->input('unit_price', []);

        if (! is_array($descriptions)) {
            $descriptions = [$descriptions];
            $types = [$request->input('line_type', 'service')];
            $quantities = [$request->input('quantity', 1)];
            $unitPrices = [$request->input('unit_price', 0)];
        }

        $items = [];

        foreach ($descriptions as $index => $description) {
            $description = trim((string) $description);

            if ($description === '') {
                continue;
            }

            $quantity = (float) ($quantities[$index] ?? 1);
            $unitPrice = (float) ($unitPrices[$index] ?? 0);

            $items[] = [
                'line_type' => $types[$index] ?? 'service',
                'description' => $description,
                'quantity' => $quantity,
                'unit_price' => $unitPrice,
                'total' => round($quantity * $unitPrice, 2),
            ];
        }

        return $items;
    }

    private function recalculate(Invoice $invoice): void
    {
        $invoice->load('items');

        $subtotal = round((float) $invoice->items->sum('total'), 2);
        $tax = round((float) $invoice->tax, 2);
        $amountPaid = round((float) $invoice->amount_paid, 2);
        $total = $subtotal + $tax;
        $balance = max(0, $total - $amountPaid);

        $status = $invoice->status;
        if ($balance <= 0 && $total > 0) {
            $status = 'paid';
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
