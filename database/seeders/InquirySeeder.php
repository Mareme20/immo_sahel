<?php

namespace Database\Seeders;

use App\Models\Contact;
use App\Models\Property;
use App\Models\PropertyInquiry;
use Illuminate\Database\Seeder;

class InquirySeeder extends Seeder
{
    public function run(): void
    {
        $properties = Property::query()->get()->keyBy('slug');
        $contacts = Contact::query()->get()->keyBy('email');

        $inquiries = [
            [
                'property_slug' => 'magnifique-villa-aux-almadies',
                'contact_email' => 'coumba.sow@agence-sahel.sn',
                'preferred_contact' => 'whatsapp',
                'preferred_visit_date' => '2026-04-20',
                'budget' => 260000000,
                'status' => 'qualified',
                'source' => 'website',
                'message' => 'Nous cherchons une villa familiale avec jardin et une bonne proximite avec les ecoles.',
            ],
            [
                'property_slug' => 'appartement-f4-a-sacre-coeur',
                'contact_email' => 'astou.ndour@agence-sahel.sn',
                'preferred_contact' => 'email',
                'preferred_visit_date' => '2026-04-22',
                'budget' => 750000,
                'status' => 'new',
                'source' => 'website',
                'message' => 'Besoin rapide d\'une location 3 chambres minimum, proche des axes principaux.',
            ],
            [
                'property_slug' => 'villa-de-luxe-a-fann',
                'contact_email' => 'cheikh.ba@agence-sahel.sn',
                'preferred_contact' => 'phone',
                'preferred_visit_date' => '2026-04-24',
                'budget' => 310000000,
                'status' => 'visit_planned',
                'source' => 'website',
                'message' => 'Disponible pour une visite en fin de semaine. Interet fort si le dossier est clair.',
            ],
            [
                'property_slug' => 'immeuble-de-rapport-a-rufisque',
                'contact_email' => 'ibrahima.faye@agence-sahel.sn',
                'preferred_contact' => 'whatsapp',
                'preferred_visit_date' => '2026-04-26',
                'budget' => 470000000,
                'status' => 'converted',
                'source' => 'website',
                'message' => 'Je veux etudier le rendement locatif et les documents techniques.',
            ],
            [
                'property_slug' => 'terrain-titre-a-saly',
                'contact_email' => 'cheikh.ba@agence-sahel.sn',
                'preferred_contact' => 'phone',
                'preferred_visit_date' => '2026-04-28',
                'budget' => 90000000,
                'status' => 'archived',
                'source' => 'website',
                'message' => 'Le projet a finalement ete reporte mais le terrain reste interessant.',
            ],
        ];

        foreach ($inquiries as $inquiryData) {
            $property = $properties->get($inquiryData['property_slug']);
            $contact = $contacts->get($inquiryData['contact_email']);

            if (! $property || ! $contact) {
                continue;
            }

            PropertyInquiry::query()->updateOrCreate(
                [
                    'property_id' => $property->id,
                    'contact_id' => $contact->id,
                    'source' => $inquiryData['source'],
                ],
                [
                    'name' => $contact->name,
                    'email' => $contact->email,
                    'phone' => $contact->phone,
                    'preferred_contact' => $inquiryData['preferred_contact'],
                    'preferred_visit_date' => $inquiryData['preferred_visit_date'],
                    'budget' => $inquiryData['budget'],
                    'status' => $inquiryData['status'],
                    'message' => $inquiryData['message'],
                ],
            );
        }
    }
}
