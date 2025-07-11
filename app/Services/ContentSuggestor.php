<?php
// app/Service/ContentSuggestor.php
namespace App\Services;

use OpenAI\Laravel\Facades\OpenAI;

class ContentSuggestor
{
    /**
     * Toa mapendekezo kutoka kwa OpenAI.
     *
     * @param  array{region:string,crop:string,season:string,weather:string,constraints?:string}  $context
     * @return string
     */
    public function suggest(array $context): string
    {
        $messages = [
            ['role' => 'system', 'content' => 'Wewe ni mtaalamu wa kilimo anayejibu kwa Kiswahili.'],
            ['role' => 'user',   'content' =>
                "Mkoa: {$context['region']}; Mazao: {$context['crop']}; "
              . "Msimu: {$context['season']}; Hali ya hewa: {$context['weather']}. "
              . ($context['constraints'] ?? '') . "\nTafadhali toa ushauri mfupi."
            ],
        ];

        $response = OpenAI::chat()->create([
            'model'    => 'gpt-3.5-turbo',   // badilisha ikiwa unataka gpt‑4o n.k.
            'messages' => $messages,
            'max_tokens' => 300,             // punguza gharama
            'temperature' => 0.7,
        ]);

        return trim($response->choices[0]->message->content);
    }
}
