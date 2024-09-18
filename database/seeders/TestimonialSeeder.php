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
                'name' => 'Michel',
                'role' => 'Développeur',
                'comment' => "J'ai travaillé avec David sur de nombreux projets web, et c'est un plaisir car le travail se fait toujours de façon professionnelle et structurée 💻. Je le recommande pour vos futurs projets web ! Merci David, ce fut un plaisir de travailler avec toi, à refaire ! 😊",
                'image_url' => 'anJxjUygkykmo090ARWMzN1EAhLpadHoSbBCmCF9.png',
                // 'image_url' => Str::uuid() . '.png',
                'rating' => 5.0,
                'source' => 'mon site',
            ],
            [
                'name' => 'Fabrice Magnan de Bellevue',
                'role' => 'Développeur',
                'comment' => "David est un développeur web exceptionnel avec qui j'ai eu le plaisir de travailler. Son expertise, sa créativité et son engagement assurent des résultats de qualité. En plus, sa communication est fluide et agréable. Je le recommande sans hésiter pour vos projets web ! 👌",
                'image_url' => 'IndOoQPZ6FfvsFO1DTHvgAa1BXV8SA6tMNpd3prw.jpg',
                // 'image_url' => Str::uuid() . '.png',
                'rating' => 5.0,
                'source' => 'mon site',
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
