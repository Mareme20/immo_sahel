<?php

namespace Database\Seeders;

use App\Models\Contact;
use Illuminate\Database\Seeder;

class ContactSeeder extends Seeder
{
    public function run(): void
    {
        $contacts = [
            [
                'name' => 'Mamadou Ndiaye',
                'email' => 'mamadou.ndiaye@agence-sahel.sn',
                'phone' => '+221770010101',
                'company' => 'Ndiaye Patrimoine',
                'type' => 'owner',
                'preferred_channel' => 'phone',
                'notes' => 'Proprietaire historique de plusieurs actifs premium aux Almadies.',
            ],
            [
                'name' => 'Aissatou Ba',
                'email' => 'aissatou.ba@agence-sahel.sn',
                'phone' => '+221770010102',
                'company' => 'AB Invest',
                'type' => 'owner',
                'preferred_channel' => 'whatsapp',
                'notes' => 'Souhaite un reporting rapide sur l\'occupation et les loyers.',
            ],
            [
                'name' => 'Seydou Fall',
                'email' => 'seydou.fall@agence-sahel.sn',
                'phone' => '+221770010103',
                'company' => 'SF Immobilier',
                'type' => 'owner',
                'preferred_channel' => 'phone',
                'notes' => 'Disponible en journee pour arbitrer les travaux.',
            ],
            [
                'name' => 'Fatou Diop',
                'email' => 'fatou.diop@agence-sahel.sn',
                'phone' => '+221770010104',
                'company' => null,
                'type' => 'owner',
                'preferred_channel' => 'email',
                'notes' => 'Prefere valider les operations par email.',
            ],
            [
                'name' => 'Khadim Diallo',
                'email' => 'khadim.diallo@agence-sahel.sn',
                'phone' => '+221770010105',
                'company' => 'KD Capital',
                'type' => 'owner',
                'preferred_channel' => 'whatsapp',
                'notes' => 'Investisseur actif sur Fann et Point E.',
            ],
            [
                'name' => 'Lamine Mbaye',
                'email' => 'lamine.mbaye@agence-sahel.sn',
                'phone' => '+221770010106',
                'company' => null,
                'type' => 'owner',
                'preferred_channel' => 'phone',
                'notes' => 'Supervise les sujets juridiques sur les terrains.',
            ],
            [
                'name' => 'Bocar Sy',
                'email' => 'bocar.sy@agence-sahel.sn',
                'phone' => '+221770010107',
                'company' => 'Sy Group',
                'type' => 'owner',
                'preferred_channel' => 'phone',
                'notes' => 'Interesse par l\'optimisation du rendement locatif.',
            ],
            [
                'name' => 'Aminata Kane',
                'email' => 'aminata.kane@agence-sahel.sn',
                'phone' => '+221770020201',
                'company' => null,
                'type' => 'tenant',
                'preferred_channel' => 'whatsapp',
                'notes' => 'Locataire fiable, prefere les relances WhatsApp.',
            ],
            [
                'name' => 'Ousmane Ndao',
                'email' => 'ousmane.ndao@agence-sahel.sn',
                'phone' => '+221770020202',
                'company' => null,
                'type' => 'tenant',
                'preferred_channel' => 'phone',
                'notes' => 'Locataire sur Liberte, demande des justificatifs mensuels.',
            ],
            [
                'name' => 'Mariama Cisse',
                'email' => 'mariama.cisse@agence-sahel.sn',
                'phone' => '+221770020203',
                'company' => null,
                'type' => 'tenant',
                'preferred_channel' => 'email',
                'notes' => 'Candidate locataire pour Sacre-Coeur.',
            ],
            [
                'name' => 'Coumba Sow',
                'email' => 'coumba.sow@agence-sahel.sn',
                'phone' => '+221770030301',
                'company' => 'Sow Trading',
                'type' => 'prospect',
                'preferred_channel' => 'whatsapp',
                'notes' => 'Recherche une villa familiale a Dakar.',
            ],
            [
                'name' => 'Cheikh Ba',
                'email' => 'cheikh.ba@agence-sahel.sn',
                'phone' => '+221770030302',
                'company' => null,
                'type' => 'buyer',
                'preferred_channel' => 'phone',
                'notes' => 'Projet d\'achat dans le residentiel premium.',
            ],
            [
                'name' => 'Astou Ndour',
                'email' => 'astou.ndour@agence-sahel.sn',
                'phone' => '+221770030303',
                'company' => null,
                'type' => 'prospect',
                'preferred_channel' => 'email',
                'notes' => 'Souhaite une location a moyen terme avec 3 chambres minimum.',
            ],
            [
                'name' => 'Ibrahima Faye',
                'email' => 'ibrahima.faye@agence-sahel.sn',
                'phone' => '+221770030304',
                'company' => 'Faye Logistics',
                'type' => 'buyer',
                'preferred_channel' => 'whatsapp',
                'notes' => 'Cherche un immeuble de rapport a fort potentiel.',
            ],
        ];

        foreach ($contacts as $contactData) {
            Contact::query()->updateOrCreate(
                ['email' => $contactData['email']],
                [
                    ...$contactData,
                    'is_active' => true,
                ],
            );
        }
    }
}
