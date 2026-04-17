<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Inertia\Inertia;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/Contacts/Index', [
            'contacts' => Contact::query()
                ->withCount(['ownedProperties', 'tenancyProperties', 'inquiries'])
                ->latest()
                ->paginate(10),
            'stats' => [
                'total' => Contact::count(),
                'owners' => Contact::where('type', 'owner')->count(),
                'tenants' => Contact::where('type', 'tenant')->count(),
                'prospects' => Contact::where('type', 'prospect')->count(),
                'inactive' => Contact::where('is_active', false)->count(),
            ],
        ]);
    }

    public function create()
    {
        return Inertia::render('Admin/Contacts/Create');
    }

    public function store(Request $request)
    {
        Contact::create($this->validatedData($request));

        return redirect()->route('admin.contacts.index')->with('message', 'Contact ajoute avec succes.');
    }

    public function edit(Contact $contact)
    {
        return Inertia::render('Admin/Contacts/Edit', [
            'contact' => $contact,
        ]);
    }

    public function update(Request $request, Contact $contact)
    {
        $contact->update($this->validatedData($request));

        return redirect()->route('admin.contacts.index')->with('message', 'Contact mis a jour.');
    }

    public function destroy(Contact $contact)
    {
        $contact->delete();

        return redirect()->route('admin.contacts.index')->with('message', 'Contact supprime.');
    }

    private function validatedData(Request $request): array
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:255'],
            'company' => ['nullable', 'string', 'max:255'],
            'type' => ['required', 'in:owner,tenant,prospect,buyer,vendor,other'],
            'preferred_channel' => ['required', 'in:phone,whatsapp,email'],
            'notes' => ['nullable', 'string'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);

        return $validated;
    }
}
