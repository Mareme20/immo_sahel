<?php

namespace Database\Seeders;

use App\Models\Contact;
use App\Models\Property;
use App\Models\RentPayment;
use Illuminate\Database\Seeder;

class RentPaymentSeeder extends Seeder
{
    public function run(): void
    {
        $properties = Property::query()->get()->keyBy('slug');
        $contacts = Contact::query()->get()->keyBy('email');

        $payments = [
            [
                'reference' => 'LOYER-PLATEAU-2026-03',
                'property_slug' => 'appartement-f4-avec-vue-mer',
                'tenant_email' => 'aminata.kane@agence-sahel.sn',
                'amount' => 800000,
                'due_date' => '2026-03-05',
                'paid_date' => '2026-03-04',
                'status' => 'paid',
                'period_label' => 'Mars 2026',
                'notes' => 'Paiement recu avant echeance.',
            ],
            [
                'reference' => 'LOYER-PLATEAU-2026-04',
                'property_slug' => 'appartement-f4-avec-vue-mer',
                'tenant_email' => 'aminata.kane@agence-sahel.sn',
                'amount' => 800000,
                'due_date' => '2026-04-05',
                'paid_date' => null,
                'status' => 'pending',
                'period_label' => 'Avril 2026',
                'notes' => 'Relance a prevoir cette semaine.',
            ],
            [
                'reference' => 'LOYER-LIBERTE-2026-03',
                'property_slug' => 'appartement-f2-a-liberte',
                'tenant_email' => 'ousmane.ndao@agence-sahel.sn',
                'amount' => 400000,
                'due_date' => '2026-03-10',
                'paid_date' => '2026-03-18',
                'status' => 'late',
                'period_label' => 'Mars 2026',
                'notes' => 'Paiement recu avec retard de huit jours.',
            ],
            [
                'reference' => 'LOYER-LIBERTE-2026-04',
                'property_slug' => 'appartement-f2-a-liberte',
                'tenant_email' => 'ousmane.ndao@agence-sahel.sn',
                'amount' => 400000,
                'due_date' => '2026-04-10',
                'paid_date' => '2026-04-12',
                'status' => 'partial',
                'period_label' => 'Avril 2026',
                'notes' => 'Versement partiel recu, solde attendu.',
            ],
            [
                'reference' => 'LOYER-SACRECOEUR-2026-05',
                'property_slug' => 'appartement-f4-a-sacre-coeur',
                'tenant_email' => 'mariama.cisse@agence-sahel.sn',
                'amount' => 700000,
                'due_date' => '2026-05-05',
                'paid_date' => null,
                'status' => 'pending',
                'period_label' => 'Mai 2026',
                'notes' => 'Paiement a suivre si le bail se confirme.',
            ],
        ];

        foreach ($payments as $paymentData) {
            $property = $properties->get($paymentData['property_slug']);
            $tenant = $contacts->get($paymentData['tenant_email']);

            if (! $property) {
                continue;
            }

            RentPayment::query()->updateOrCreate(
                ['reference' => $paymentData['reference']],
                [
                    'property_id' => $property->id,
                    'tenant_contact_id' => $tenant?->id,
                    'amount' => $paymentData['amount'],
                    'due_date' => $paymentData['due_date'],
                    'paid_date' => $paymentData['paid_date'],
                    'status' => $paymentData['status'],
                    'period_label' => $paymentData['period_label'],
                    'notes' => $paymentData['notes'],
                ],
            );
        }
    }
}
