<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Crop;
use App\Models\CropDisease;

class CropDiseaseSeeder extends Seeder
{
    public function run(): void
    {
        $diseases = [
            // Cereal crops
            'mahindi' => [
                ['name' => 'Mnyauko wa mahindi', 'description' => 'Husababishwa na fangasi, hupelekea mimea kunyauka ghafla.'],
                ['name' => 'Funza wa jeshi (Armyworm)', 'description' => 'Huwaangamiza mashina na majani ya mahindi.'],
            ],
            'mchele' => [
                ['name' => 'Ukungu wa mchele (Rice blast)', 'description' => 'Husababisha madoa kwenye majani na upotevu wa mavuno.'],
                ['name' => 'Bacterial leaf blight', 'description' => 'Huathiri majani na kuua mmea.'],
            ],
            'mtama' => [
                ['name' => 'Ergot', 'description' => 'Husababisha ukuaji wa uyoga kwenye malundo ya nafaka.'],
                ['name' => 'Anthracnose', 'description' => 'Huathiri majani, mashina na panicles za mtama.'],
            ],
            'uwele' => [
                ['name' => 'Head smut', 'description' => 'Huathiri vichwa vya uwele na kuzuia mazao.'],
            ],
            'ulezi' => [
                ['name' => 'Downy mildew', 'description' => 'Huathiri sana ulezi kwenye mazingira yenye unyevunyevu.'],
            ],
            'mihogo' => [
                ['name' => 'Cassava Mosaic Virus', 'description' => 'Husababisha madoa meupe kwenye majani na upungufu wa mazao.'],
                ['name' => 'Cassava Brown Streak', 'description' => 'Huathiri mizizi ya mihogo na kuifanya kuoza.'],
            ],
            'viazi vitamu' => [
                ['name' => 'Sweet Potato Weevil', 'description' => 'Huvamia mizizi na kuharibu viazi vitamu.'],
            ],
            'viazi mviringo' => [
                ['name' => 'Late Blight', 'description' => 'Husababisha kuoza kwa majani na viazi ardhini.'],
            ],

            // Legumes
            'maharage' => [
                ['name' => 'Bean Rust', 'description' => 'Huonekana kama madoa ya kutu kwenye majani.'],
                ['name' => 'Angular leaf spot', 'description' => 'Husababisha matangazo ya kona kona kwenye majani ya maharage.'],
            ],
            'kunde' => [
                ['name' => 'Powdery mildew', 'description' => 'Husababisha unga mweupe kwenye majani.'],
            ],
            'mbaazi' => [
                ['name' => 'Wilt disease', 'description' => 'Husababisha mmea kunyauka na kufa.'],
            ],
            'soya' => [
                ['name' => 'Soybean rust', 'description' => 'Huathiri majani na kupunguza mavuno.'],
            ],

            // Cash crops
            'kahawa' => [
                ['name' => 'Coffee Leaf Rust', 'description' => 'Husababisha madoa ya waridi na kuharibu mavuno.'],
            ],
            'chai' => [
                ['name' => 'Blister blight', 'description' => 'Huathiri majani ya chai.'],
            ],
            'pamba' => [
                ['name' => 'Bacterial blight', 'description' => 'Huathiri miche changa ya pamba.'],
            ],
            'tumbaku' => [
                ['name' => 'Tobacco mosaic virus', 'description' => 'Huathiri ukuaji wa majani ya tumbaku.'],
            ],
            'korosho' => [
                ['name' => 'Powdery Mildew', 'description' => 'Huathiri maua ya korosho na kusababisha upotevu wa mazao.'],
            ],
            'mkonge' => [
                ['name' => 'Sigatoka leaf spot', 'description' => 'Huathiri majani ya mkonge.'],
            ],
            'miwa' => [
                ['name' => 'Red rot', 'description' => 'Husababisha kuoza kwa sehemu ya ndani ya miwa.'],
            ],
            'alizeti' => [
                ['name' => 'Downy mildew', 'description' => 'Huathiri majani na maua ya alizeti.'],
            ],
            'ufuta' => [
                ['name' => 'Leaf blight', 'description' => 'Husababisha kuoza kwa majani na kupunguza mavuno.'],
            ],

            // Vegetables
            'nyanya' => [
                ['name' => 'Early blight', 'description' => 'Huathiri majani na matunda ya nyanya.'],
            ],
            'kitunguu' => [
                ['name' => 'Purple blotch', 'description' => 'Huathiri majani na shingo ya vitunguu.'],
            ],
            'kabichi' => [
                ['name' => 'Black rot', 'description' => 'Husababisha majani kuoza na kuwa meusi.'],
            ],
            'karoti' => [
                ['name' => 'Alternaria leaf blight', 'description' => 'Huathiri majani na kupunguza ukuaji wa karoti.'],
            ],
            'spinachi' => [
                ['name' => 'Downy mildew', 'description' => 'Huonekana kama madoa ya njano kwenye majani ya spinachi.'],
            ],
            'bamia' => [
                ['name' => 'Powdery mildew', 'description' => 'Huathiri majani na maua ya bamia.'],
            ],
            'pilipili' => [
                ['name' => 'Bacterial spot', 'description' => 'Husababisha madoa kwenye majani na matunda.'],
            ],
            'matango' => [
                ['name' => 'Cucumber mosaic virus', 'description' => 'Husababisha madoa ya kijani na ulemavu wa matunda.'],
            ],
            'tikiti maji' => [
                ['name' => 'Anthracnose', 'description' => 'Huathiri majani na matunda ya tikiti maji.'],
            ],

            // Fruits
            'ndizi' => [
                ['name' => 'Panama disease', 'description' => 'Husababisha ndizi kunyauka.'],
            ],
            'ndizi za kupika' => [
                ['name' => 'Black Sigatoka', 'description' => 'Huathiri sana majani ya ndizi.'],
            ],
            'embe' => [
                ['name' => 'Anthracnose', 'description' => 'Huathiri maua na matunda ya embe.'],
            ],
            'nanasi' => [
                ['name' => 'Heart rot', 'description' => 'Husababisha kuoza kwa sehemu ya kati ya mmea.'],
            ],
            'machungwa' => [
                ['name' => 'Citrus canker', 'description' => 'Huathiri majani, shina na matunda ya machungwa.'],
            ],
            'parachichi' => [
                ['name' => 'Root rot (Phytophthora)', 'description' => 'Husababisha mizizi kuoza.'],
            ],
            'papai' => [
                ['name' => 'Papaya ringspot virus', 'description' => 'Husababisha pete za njano kwenye majani.'],
            ],
            'passion' => [
                ['name' => 'Woodiness virus', 'description' => 'Hufanya matunda kuwa magumu na yasiyofaa.'],
            ],
            'fenesi' => [
                ['name' => 'Fruit rot', 'description' => 'Huathiri matunda ya fenesi yaliyokomaa.'],
            ],
            'pera' => [
                ['name' => 'Guava wilt', 'description' => 'Huathiri mizizi na huua mmea polepole.'],
            ],

            // Oil & spice crops
            'karanga' => [
                ['name' => 'Aflatoxin', 'description' => 'Sumu inayotokana na fangasi inayozalishwa kwenye karanga.'],
            ],
            'nazi' => [
                ['name' => 'Lethal yellowing', 'description' => 'Huathiri nazi na kuua mmea.'],
            ],
            'karafuu' => [
                ['name' => 'Clove dieback', 'description' => 'Husababisha matawi ya karafuu kunyauka.'],
            ],
            'iliki' => [
                ['name' => 'Capsule rot', 'description' => 'Huathiri makasha ya iliki na kuzuia uzalishaji.'],
            ],
        ];

        foreach ($diseases as $cropName => $cropDiseases) {
            $crop = Crop::where('name', $cropName)->first();
            if ($crop) {
                foreach ($cropDiseases as $disease) {
                    CropDisease::create([
                        'crop_id' => $crop->id,
                        'name' => $disease['name'],
                        'description' => $disease['description'],
                    ]);
                }
            }
        }
    }
}
