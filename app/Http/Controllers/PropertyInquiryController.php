<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Property;
use Illuminate\Http\Request;

class PropertyInquiryController extends Controller
{
    public function store(Request $request, Property $property)
    {
        abort_unless($property->is_published, 404);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['required', 'string', 'max:255'],
            'preferred_contact' => ['required', 'in:phone,whatsapp,email'],
            'preferred_visit_date' => ['nullable', 'date'],
            'budget' => ['nullable', 'numeric', 'min:0'],
            'message' => ['nullable', 'string', 'max:2000'],
        ]);

        $contact = Contact::query()
            ->when(
                filled($validated['phone'] ?? null),
                fn ($query) => $query->where('phone', $validated['phone'])
            )
            ->when(
                blank($validated['phone'] ?? null) && filled($validated['email'] ?? null),
                fn ($query) => $query->where('email', $validated['email'])
            )
            ->first();

        if (! $contact) {
            $contact = Contact::create([
                'name' => $validated['name'],
                'email' => $validated['email'] ?? null,
                'phone' => $validated['phone'],
                'type' => 'prospect',
                'preferred_channel' => $validated['preferred_contact'],
            ]);
        } else {
            $contact->fill([
                'name' => $contact->name ?: $validated['name'],
                'email' => $contact->email ?: ($validated['email'] ?? null),
                'phone' => $contact->phone ?: $validated['phone'],
                'preferred_channel' => $validated['preferred_contact'],
            ])->save();
        }

        $property->inquiries()->create([
            ...$validated,
            'contact_id' => $contact->id,
            'source' => 'website',
        ]);

        return back()->with('message', 'Votre demande a bien ete envoyee. Nous revenons vers vous rapidement.');
    }
}
