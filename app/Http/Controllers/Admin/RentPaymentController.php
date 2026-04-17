<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\Property;
use App\Models\RentPayment;
use Illuminate\Http\Request;
use Inertia\Inertia;

class RentPaymentController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/RentPayments/Index', [
            'payments' => RentPayment::query()
                ->with(['property:id,title,location', 'tenantContact:id,name,phone'])
                ->latest('due_date')
                ->paginate(12),
            'stats' => [
                'total' => RentPayment::count(),
                'paid' => RentPayment::where('status', 'paid')->count(),
                'pending' => RentPayment::where('status', 'pending')->count(),
                'late' => RentPayment::where('status', 'late')->count(),
                'expected_amount' => (float) RentPayment::whereIn('status', ['pending', 'late', 'partial'])->sum('amount'),
            ],
        ]);
    }

    public function create()
    {
        return Inertia::render('Admin/RentPayments/Create', $this->formOptions());
    }

    public function store(Request $request)
    {
        RentPayment::create($this->validatedData($request));

        return redirect()->route('admin.rent-payments.index')->with('message', 'Paiement enregistre avec succes.');
    }

    public function edit(RentPayment $rentPayment)
    {
        return Inertia::render('Admin/RentPayments/Edit', [
            'payment' => $rentPayment,
            ...$this->formOptions(),
        ]);
    }

    public function update(Request $request, RentPayment $rentPayment)
    {
        $rentPayment->update($this->validatedData($request));

        return redirect()->route('admin.rent-payments.index')->with('message', 'Paiement mis a jour.');
    }

    public function destroy(RentPayment $rentPayment)
    {
        $rentPayment->delete();

        return redirect()->route('admin.rent-payments.index')->with('message', 'Paiement supprime.');
    }

    private function formOptions(): array
    {
        return [
            'properties' => Property::query()
                ->orderBy('title')
                ->get(['id', 'title', 'location', 'tenant_contact_id']),
            'tenants' => Contact::query()
                ->whereIn('type', ['tenant', 'prospect', 'buyer', 'other'])
                ->where('is_active', true)
                ->orderBy('name')
                ->get(['id', 'name', 'phone']),
        ];
    }

    private function validatedData(Request $request): array
    {
        return $request->validate([
            'property_id' => ['required', 'exists:properties,id'],
            'tenant_contact_id' => ['nullable', 'exists:contacts,id'],
            'amount' => ['required', 'numeric', 'min:0'],
            'due_date' => ['required', 'date'],
            'paid_date' => ['nullable', 'date'],
            'status' => ['required', 'in:pending,paid,late,partial,cancelled'],
            'period_label' => ['nullable', 'string', 'max:255'],
            'reference' => ['nullable', 'string', 'max:255'],
            'notes' => ['nullable', 'string'],
        ]);
    }
}
