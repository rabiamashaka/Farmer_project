<?php

namespace Database\Seeders;

use App\Models\ContentTemplate;
use Illuminate\Database\Seeder;

class ContentTemplateSeeder extends Seeder
{
    public function run(): void
    {
        $templates = [
            // Arifa za hali ya hewa
            [
                'title'    => 'Mvua Kubwa Inatarajiwa',
                'category' => 'weather',
                'language' => 'sw',
                'content'  => 'Tahadhari: mvua kubwa inatarajiwa wiki hii katika maeneo yako.',
                'regions'  => ['Mbeya', 'Iringa'],
                'crops'    => ['mahindi', 'maharage'],
                'status'   => 'published',
            ],
            [
                'title'    => 'Mvua Kubwa Inatarajiwa (EN)',
                'category' => 'weather',
                'language' => 'en',
                'content'  => 'Alert: heavy rainfall expected this week in your area.',
                'regions'  => ['Mbeya', 'Iringa'],
                'crops'    => ['maize', 'beans'],
                'status'   => 'published',
            ],

            // Udhibiti wa wadudu
            [
                'title'    => 'Dhibiti Wadudu',
                'category' => 'pest',
                'language' => 'sw',
                'content'  => 'Tumia dawa ya viwandani kudhibiti funza kwenye mahindi.',
                'regions'  => ['Dodoma'],
                'crops'    => ['mahindi'],
                'status'   => 'published',
            ],
            [
                'title'    => 'Control Insects',
                'category' => 'pest',
                'language' => 'en',
                'content'  => 'Use industrial pesticide to control caterpillars in maize.',
                'regions'  => ['Dodoma'],
                'crops'    => ['maize'],
                'status'   => 'published',
            ],

            // Ushauri wa kilimo
            [
                'title'    => 'Mbinu za Kilimo Bora',
                'category' => 'advice',
                'language' => 'sw',
                'content'  => 'Pandikiza mazao mapya mapema kabla ya mvua kuanza.',
                'regions'  => ['Mwanza', 'Shinyanga'],
                'crops'    => ['mchele'],
                'status'   => 'published',
            ],
            [
                'title'    => 'Smart Farming Tips',
                'category' => 'advice',
                'language' => 'en',
                'content'  => 'Plant early before the rains begin for best yields.',
                'regions'  => ['Mwanza', 'Shinyanga'],
                'crops'    => ['rice'],
                'status'   => 'published',
            ],
        ];

        foreach ($templates as $template) {
            ContentTemplate::create($template);
        }
    }
}
