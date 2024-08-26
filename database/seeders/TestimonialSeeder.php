<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Testimonial;
use Illuminate\Support\Str;

class TestimonialSeeder extends Seeder
{
    public function run()
    {
        // Données des témoignages
        $testimonials = [
            [
                'name' => 'Yves THIERRY',
                'role' => 'Développeur',
                'comment' => 'Passionné et rigoureux, David sait être à l\'écoute et être force de proposition. De la synthèse du besoin à la réalisation, il est présent à chaque étape. Le challenge ne lui fait pas peur.',
                'image_url' => '48dac211-3831-4b23-af09-bc62945d2482.jpg',
                // 'image_url' => Str::uuid() . '.jpg',
                'rating' => 5.0,
                'source' => 'Linkedin',
            ],
            [
                'name' => 'Laurent COCQ',
                'role' => 'CEO Software / Digital / SaaS',
                'comment' => 'David est quelqu’un de sympathique et d’engagé. Apte à s’adapter et à trouver des solutions. David n’a pas peur du changement et a la volonté de progresser y compris en trouvant des solutions de formation par lui même.',
                'image_url' => '2e23a66e-1958-4558-8250-04ae2b07b53c.jpg',
                // 'image_url' => Str::uuid() . '.jpg',
                'rating' => 5.0,
                'source' => 'Linkedin',
            ],
            [
                'name' => 'Sébastien HEUDE',
                'role' => 'Développeur',
                'comment' => 'David est un professionnel très consciencieux. Il est attentif aux besoins et utilise son expertise pour améliorer le projet autant que possible. Je le recommande sans hésitation !',
                'image_url' => 'fbe4057b-0ca2-4ba9-9a6f-2d7482937ff3.jpg',
                // 'image_url' => Str::uuid() . '.png',
                'rating' => 5.0,
                'source' => 'Malt',
            ],
        ];

        // Ajouter ou mettre à jour les témoignages
        foreach ($testimonials as $testimonial) {
            Testimonial::updateOrCreate(
                ['name' => $testimonial['name'], 'role' => $testimonial['role']], // Critères pour éviter les doublons
                $testimonial
            );
        }
    }
}
