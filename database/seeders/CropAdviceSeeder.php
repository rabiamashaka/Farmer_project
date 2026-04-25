<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Crop;
use App\Models\CropAdvice;

class CropAdviceSeeder extends Seeder
{
    public function run(): void
    {
        $allAdvice = [
            // Mazao ya biashara Tanzania
            'mchele' => [
                'kupanda' => [
                    'title' => 'Kupanda Mchele',
                    'description' => 'Panda mchele kwenye udongo wenye rutuba na maji ya kutosha.',
                ],
                'umwagiliaji' => [
                    'title' => 'Umwagiliaji wa Mchele',
                    'description' => 'Mchele unahitaji umwagiliaji wa mara kwa mara hasa kipindi cha ukuaji.',
                ],
                'uvunaji' => [
                    'title' => 'Uvunaji wa Mchele',
                    'description' => 'Vuna mchele wakati punje zimekomaa na kuwa na rangi ya dhahabu.',
                ],
                'uhifadhi' => [
                    'title' => 'Uhifadhi wa Mchele',
                    'description' => 'Hifadhi mchele kwenye maghala safi na kavu ili kuepuka wadudu.',
                ],
            ],
            'mahindi' => [
                'kupanda' => [
                    'title' => 'Kupanda Mahindi',
                    'description' => 'Panda mahindi kwenye udongo wenye rutuba na maji ya kutosha.',
                ],
                'umwagiliaji' => [
                    'title' => 'Umwagiliaji wa Mahindi',
                    'description' => 'Mahindi yanahitaji maji mengi hasa kipindi cha maua.',
                ],
                'uvunaji' => [
                    'title' => 'Uvunaji wa Mahindi',
                    'description' => 'Vuna mahindi wakati maganda yanapogeuka rangi ya kahawia.',
                ],
                'uhifadhi' => [
                    'title' => 'Uhifadhi wa Mahindi',
                    'description' => 'Hifadhi mahindi kwenye maghala safi na kavu ili kuepuka kuota.',
                ],
            ],
            'kahawa' => [
                'kupanda' => [
                    'title' => 'Kupanda Kahawa',
                    'description' => 'Panda kahawa kwenye maeneo yenye kivuli na udongo wenye rutuba.',
                ],
                'umwagiliaji' => [
                    'title' => 'Umwagiliaji wa Kahawa',
                    'description' => 'Kahawa inahitaji maji ya kutosha hasa wakati wa kukua kwa haraka.',
                ],
                'uvunaji' => [
                    'title' => 'Uvunaji wa Kahawa',
                    'description' => 'Vuna matunda ya kahawa wakati yanapogeuka rangi ya kahawia nyepesi.',
                ],
                'uhifadhi' => [
                    'title' => 'Uhifadhi wa Kahawa',
                    'description' => 'Hifadhi kahawa kwenye sehemu kavu na yenye hewa nzuri.',
                ],
            ],
            'chai' => [
                'kupanda' => [
                    'title' => 'Kupanda Chai',
                    'description' => 'Panda chai kwenye maeneo yenye mvua za kutosha na joto la wastani.',
                ],
                'umwagiliaji' => [
                    'title' => 'Umwagiliaji wa Chai',
                    'description' => 'Kumwagilia chai wakati wa ukame ili kuzuia mmea kukauka.',
                ],
                'uvunaji' => [
                    'title' => 'Uvunaji wa Chai',
                    'description' => 'Vuna majani ya chai wakati yanapokomaa kwa kutumia mkasi maalum.',
                ],
                'uhifadhi' => [
                    'title' => 'Uhifadhi wa Chai',
                    'description' => 'Kausha majani ya chai kwa usafi kabla ya kuhifadhi.',
                ],
            ],
            'korosho' => [
                'kupanda' => [
                    'title' => 'Kupanda Korosho',
                    'description' => 'Panda korosho kwenye udongo wenye mchanga na rutuba.',
                ],
                'umwagiliaji' => [
                    'title' => 'Umwagiliaji wa Korosho',
                    'description' => 'Korosho inahitaji maji ya wastani, epuka maji mengi.',
                ],
                'uvunaji' => [
                    'title' => 'Uvunaji wa Korosho',
                    'description' => 'Vuna korosho wakati maganda yanapogeuka rangi ya kahawia.',
                ],
                'uhifadhi' => [
                    'title' => 'Uhifadhi wa Korosho',
                    'description' => 'Hifadhi korosho kwenye maghala safi na kavu.',
                ],
            ],
            'pamba' => [
                'kupanda' => [
                    'title' => 'Kupanda Pamba',
                    'description' => 'Panda pamba kwenye udongo wenye rutuba na maji ya kutosha.',
                ],
                'umwagiliaji' => [
                    'title' => 'Umwagiliaji wa Pamba',
                    'description' => 'Pamba inahitaji maji ya wastani, epuka maji mengi.',
                ],
                'uvunaji' => [
                    'title' => 'Uvunaji wa Pamba',
                    'description' => 'Vuna pamba wakati makotoni yanapofunguka.',
                ],
                'uhifadhi' => [
                    'title' => 'Uhifadhi wa Pamba',
                    'description' => 'Hifadhi pamba kwenye maghala safi na kavu.',
                ],
            ],
            'tumbaku' => [
                'kupanda' => [
                    'title' => 'Kupanda Tumbaku',
                    'description' => 'Panda tumbaku kwenye udongo wenye rutuba na maji ya kutosha.',
                ],
                'umwagiliaji' => [
                    'title' => 'Umwagiliaji wa Tumbaku',
                    'description' => 'Tumbaku inahitaji maji ya wastani.',
                ],
                'uvunaji' => [
                    'title' => 'Uvunaji wa Tumbaku',
                    'description' => 'Vuna majani ya tumbaku wakati yanapokomaa.',
                ],
                'uhifadhi' => [
                    'title' => 'Uhifadhi wa Tumbaku',
                    'description' => 'Hifadhi tumbaku kwenye maghala safi na kavu.',
                ],
            ],
            'miwa' => [
                'kupanda' => [
                    'title' => 'Kupanda Miwa',
                    'description' => 'Panda miwa kwenye udongo wenye rutuba na maji ya kutosha.',
                ],
                'umwagiliaji' => [
                    'title' => 'Umwagiliaji wa Miwa',
                    'description' => 'Miwa inahitaji maji mengi hasa kipindi cha ukuaji.',
                ],
                'uvunaji' => [
                    'title' => 'Uvunaji wa Miwa',
                    'description' => 'Vuna miwa wakati imekomaa na kuwa na sukari nyingi.',
                ],
                'uhifadhi' => [
                    'title' => 'Uhifadhi wa Miwa',
                    'description' => 'Hifadhi miwa kwenye maghala safi na kavu.',
                ],
            ],
            'mkonge' => [
                'kupanda' => [
                    'title' => 'Kupanda Mkonge',
                    'description' => 'Panda mkonge kwenye udongo wenye rutuba na maji ya wastani.',
                ],
                'umwagiliaji' => [
                    'title' => 'Umwagiliaji wa Mkonge',
                    'description' => 'Mkonge hustahimili ukame, umwagiliaji wa mara chache unatosha.',
                ],
                'uvunaji' => [
                    'title' => 'Uvunaji wa Mkonge',
                    'description' => 'Vuna mkonge wakati majani yanapokomaa.',
                ],
                'uhifadhi' => [
                    'title' => 'Uhifadhi wa Mkonge',
                    'description' => 'Hifadhi mkonge kwenye maghala safi na kavu.',
                ],
            ],
            'alizeti' => [
                'kupanda' => [
                    'title' => 'Kupanda Alizeti',
                    'description' => 'Panda alizeti kwenye udongo wenye rutuba na jua la kutosha.',
                ],
                'umwagiliaji' => [
                    'title' => 'Umwagiliaji wa Alizeti',
                    'description' => 'Alizeti inahitaji maji ya wastani.',
                ],
                'uvunaji' => [
                    'title' => 'Uvunaji wa Alizeti',
                    'description' => 'Vuna alizeti wakati maua yanapogeuka rangi ya kahawia.',
                ],
                'uhifadhi' => [
                    'title' => 'Uhifadhi wa Alizeti',
                    'description' => 'Hifadhi alizeti kwenye maghala safi na kavu.',
                ],
            ],
            'karafuu' => [
                'kupanda' => [
                    'title' => 'Kupanda Karafuu',
                    'description' => 'Panda karafuu kwenye ardhi yenye rutuba na kivuli kidogo.',
                ],
                'umwagiliaji' => [
                    'title' => 'Umwagiliaji wa Karafuu',
                    'description' => 'Karafuu inahitaji maji kidogo, epuka kunyunyizia maji mengi.',
                ],
                'uvunaji' => [
                    'title' => 'Uvunaji wa Karafuu',
                    'description' => 'Vuna karafuu wakati mashina yanapokuwa ya rangi nyekundu na kuanza kufungua.',
                ],
                'uhifadhi' => [
                    'title' => 'Uhifadhi wa Karafuu',
                    'description' => 'Hifadhi karafuu kavu na mahali penye hewa safi.',
                ],
            ],
            'pareto' => [
                'kupanda' => [
                    'title' => 'Kupanda Pareto',
                    'description' => 'Panda pareto kwenye udongo wenye rutuba na maji ya kutosha.',
                ],
                'umwagiliaji' => [
                    'title' => 'Umwagiliaji wa Pareto',
                    'description' => 'Pareto inahitaji maji ya wastani.',
                ],
                'uvunaji' => [
                    'title' => 'Uvunaji wa Pareto',
                    'description' => 'Vuna pareto wakati maua yanapogeuka rangi ya njano.',
                ],
                'uhifadhi' => [
                    'title' => 'Uhifadhi wa Pareto',
                    'description' => 'Hifadhi pareto kwenye maghala safi na kavu.',
                ],
            ],
            // Mazao ya mboga mboga
            'nyanya' => [
                'kupanda' => [
                    'title' => 'Kupanda Nyanya',
                    'description' => 'Panda miche ya nyanya kwenye ardhi yenye rutuba na kuangaziwa vyema.',
                ],
                'umwagiliaji' => [
                    'title' => 'Umwagiliaji wa Nyanya',
                    'description' => 'Nyanya zinahitaji kumwagiliwa mara kwa mara lakini usizidi maji ili zisikauke.',
                ],
                'uvunaji' => [
                    'title' => 'Uvunaji wa Nyanya',
                    'description' => 'Vuna nyanya zinapoiva kwa rangi nyekundu au kijani kwa aina fulani.',
                ],
                'uhifadhi' => [
                    'title' => 'Uhifadhi wa Nyanya',
                    'description' => 'Hifadhi nyanya katika sehemu kavu na yenye hewa nzuri ili zisizidi kukaushwa.',
                ],
            ],
            'kabichi' => [
                'kupanda' => [
                    'title' => 'Kupanda Kabichi',
                    'description' => 'Panda kabichi kwenye udongo wenye rutuba na joto la wastani.',
                ],
                'umwagiliaji' => [
                    'title' => 'Umwagiliaji wa Kabichi',
                    'description' => 'Kabichi inahitaji maji ya kutosha ili iwe na majani makubwa na mazuri.',
                ],
                'uvunaji' => [
                    'title' => 'Uvunaji wa Kabichi',
                    'description' => 'Vuna kabichi wakati kichwa cha kabichi kinakuwa kigumu na kimejaa.',
                ],
                'uhifadhi' => [
                    'title' => 'Uhifadhi wa Kabichi',
                    'description' => 'Hifadhi kabichi mahali pakavu na penye baridi kidogo ili ziweze kuhifadhiwa muda mrefu.',
                ],
            ],
            // Mazao ya matunda
            'ndizi' => [
                'kupanda' => [
                    'title' => 'Kupanda Ndizi',
                    'description' => 'Panda ndizi kwenye udongo wenye rutuba na unyevu wa kutosha.',
                ],
                'umwagiliaji' => [
                    'title' => 'Umwagiliaji wa Ndizi',
                    'description' => 'Ndizi zinahitaji umwagiliaji mzuri hasa kipindi cha ukomavu.',
                ],
                'uvunaji' => [
                    'title' => 'Uvunaji wa Ndizi',
                    'description' => 'Vuna ndizi wakati mabwawa yanapopata rangi ya njano au kijani kibichi.',
                ],
                'uhifadhi' => [
                    'title' => 'Uhifadhi wa Ndizi',
                    'description' => 'Hifadhi ndizi mahali pakavu na penye hewa safi ili zisizoharibika haraka.',
                ],
            ],
            'parachichi' => [
                'kupanda' => [
                    'title' => 'Kupanda Parachichi',
                    'description' => 'Panda parachichi kwenye ardhi yenye udongo mzuri na maji ya kutosha.',
                ],
                'umwagiliaji' => [
                    'title' => 'Umwagiliaji wa Parachichi',
                    'description' => 'Parachichi linahitaji umwagiliaji wa wastani, usizidi maji ili majani yasizame.',
                ],
                'uvunaji' => [
                    'title' => 'Uvunaji wa Parachichi',
                    'description' => 'Vuna parachichi wakati limetoa rangi na limepata uzito mzuri.',
                ],
                'uhifadhi' => [
                    'title' => 'Uhifadhi wa Parachichi',
                    'description' => 'Hifadhi parachichi katika maeneo yenye hewa nzuri na usiyoyeyuka.',
                ],
            ],
            // Mazao ya mafuta na viungo
            'karanga' => [
                'kupanda' => [
                    'title' => 'Kupanda Karanga',
                    'description' => 'Panda karanga kwenye udongo wenye mchanga na joto la wastani.',
                ],
                'umwagiliaji' => [
                    'title' => 'Umwagiliaji wa Karanga',
                    'description' => 'Karanga inahitaji umwagiliaji wa wastani kwa kukua vizuri.',
                ],
                'uvunaji' => [
                    'title' => 'Uvunaji wa Karanga',
                    'description' => 'Vuna karanga wakati majani yanapokuwa yamekauka na maganda yameanza kupasuka.',
                ],
                'uhifadhi' => [
                    'title' => 'Uhifadhi wa Karanga',
                    'description' => 'Hifadhi karanga mahali pakavu na penye hewa ili zisiharibike.',
                ],
            ],
            'karafuu' => [
                'kupanda' => [
                    'title' => 'Kupanda Karafuu',
                    'description' => 'Panda karafuu kwenye ardhi yenye rutuba na kivuli kidogo.',
                ],
                'umwagiliaji' => [
                    'title' => 'Umwagiliaji wa Karafuu',
                    'description' => 'Karafuu inahitaji maji kidogo, epuka kunyunyizia maji mengi.',
                ],
                'uvunaji' => [
                    'title' => 'Uvunaji wa Karafuu',
                    'description' => 'Vuna karafuu wakati mashina yanapokuwa ya rangi nyekundu na kuanza kufungua.',
                ],
                'uhifadhi' => [
                    'title' => 'Uhifadhi wa Karafuu',
                    'description' => 'Hifadhi karafuu kavu na mahali penye hewa safi.',
                ],
            ],
            // Endelea na mazao mengine kama unavyo hitaji...
        ];

        foreach ($allAdvice as $cropName => $advices) {
            $crop = Crop::where('name', $cropName)->first();
            if ($crop) {
                foreach ($advices as $type => $advice) {
                    CropAdvice::updateOrCreate(
                        [
                            'crop_id' => $crop->id,
                            'type' => $type,
                        ],
                        [
                            'title' => $advice['title'],
                            'description' => $advice['description'],
                        ]
                    );
                }
            }
        }
    }
}
