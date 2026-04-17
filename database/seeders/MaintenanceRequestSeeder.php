<?php

namespace Database\Seeders;

use App\Models\Contact;
use App\Models\MaintenanceRequest;
use App\Models\Property;
use Illuminate\Database\Seeder;

class MaintenanceRequestSeeder extends Seeder
{
    public function run(): void
    {
        $properties = Property::query()->get()->keyBy('slug');
        $contacts = Contact::query()->get()->keyBy('email');

        $requests = [
            [
                'property_slug' => 'appartement-f3-a-mermoz',
                'contact_email' => 'fatou.diop@agence-sahel.sn',
                'title' => 'Remise en etat avant relocation',
                'description' => 'Reprise peinture, plomberie et verification des climatiseurs avant remise sur le marche.',
                'priority' => 'high',
                'status' => 'in_progress',
                'estimated_cost' => 1250000,
                'reported_at' => '2026-04-06 10:00:00',
                'resolved_at' => null,
            ],
            [
                'property_slug' => 'maison-de-vacances-a-somone',
                'contact_email' => 'seydou.fall@agence-sahel.sn',
                'title' => 'Inspection toiture et terrasse',
                'description' => 'Suite aux dernieres pluies, une verification complete de la toiture et des evacuations est demandee.',
                'priority' => 'urgent',
                'status' => 'open',
                'estimated_cost' => 2100000,
                'reported_at' => '2026-04-12 09:30:00',
                'resolved_at' => null,
            ],
            [
                'property_slug' => 'appartement-f2-a-liberte',
                'contact_email' => 'ousmane.ndao@agence-sahel.sn',
                'title' => 'Interphone et serrure entree',
                'description' => 'Le locataire a signale des coupures intermittentes sur l\'interphone et une serrure qui accroche.',
                'priority' => 'medium',
                'status' => 'resolved',
                'estimated_cost' => 180000,
                'reported_at' => '2026-03-21 15:00:00',
                'resolved_at' => '2026-03-25 11:00:00',
            ],
            [
                'property_slug' => 'villa-de-luxe-a-fann',
                'contact_email' => 'khadim.diallo@agence-sahel.sn',
                'title' => 'Entretien piscine et espaces verts',
                'description' => 'Planifier une intervention preventive avant les visites du mois.',
                'priority' => 'low',
                'status' => 'closed',
                'estimated_cost' => 350000,
                'reported_at' => '2026-03-10 08:00:00',
                'resolved_at' => '2026-03-12 17:00:00',
            ],
        ];

        foreach ($requests as $requestData) {
            $property = $properties->get($requestData['property_slug']);
            $contact = $contacts->get($requestData['contact_email']);

            if (! $property) {
                continue;
            }

            MaintenanceRequest::query()->updateOrCreate(
                [
                    'property_id' => $property->id,
                    'title' => $requestData['title'],
                ],
                [
                    'contact_id' => $contact?->id,
                    'description' => $requestData['description'],
                    'priority' => $requestData['priority'],
                    'status' => $requestData['status'],
                    'estimated_cost' => $requestData['estimated_cost'],
                    'reported_at' => $requestData['reported_at'],
                    'resolved_at' => $requestData['resolved_at'],
                ],
            );
        }
    }
}
