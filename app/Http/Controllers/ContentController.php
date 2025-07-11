<?php

namespace App\Http\Controllers;

use App\Models\ContentTemplate;
use App\Models\Crop;
use App\Models\Region;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ContentController extends Controller
{
    /*--------------------------------------------------
    | GET /content  — Orodha ya templates
    *-------------------------------------------------*/
    public function index()
    {
        $templates = ContentTemplate::latest()->paginate(10);
        return view('content.index', compact('templates'));
    }

    /*--------------------------------------------------
    | GET /content/create  — Fomu ya kuunda template
    *-------------------------------------------------*/
    public function create()
    {
        // 1️⃣ Mikoa – chukua majina kutoka jedwali `regions`
        $regions = Region::orderBy('name')->pluck('name');   // Collection ya strings

        // 2️⃣ Mazao – majina kutoka jedwali `crops`
        $crops   = Crop::orderBy('name')->pluck('name');

        return view('content.create', compact('regions', 'crops'));
    }

    /*--------------------------------------------------
    | POST /content  — Hifadhi template mpya
    *-------------------------------------------------*/
    public function store(Request $request)
    {
        $data = $request->validate([
            'title'       => 'required|string|max:255',
            'category'    => 'required|string|max:50',
            'language'    => 'required|in:sw,en',
            'content'     => 'required|string|max:160',
            'regions'     => 'array|nullable',
            'regions.*'   => 'string',
            'crops'       => 'array|nullable',
            'crops.*'     => 'string',
            'translate'   => 'sometimes|boolean',
            'status'      => 'in:draft,published',
        ]);

        /* 1️⃣ Hifadhi template ya lugha ya asili */
        $template = ContentTemplate::create([
            'title'    => $data['title'],
            'category' => $data['category'],
            'language' => $data['language'],
            'content'  => $data['content'],
            'regions'  => $data['regions'] ?? [],
            'crops'    => $data['crops']   ?? [],
            'status'   => $data['status']  ?? 'draft',
        ]);

        /* 2️⃣ Ikiwa “translate” imechaguliwa – tengeneza nakala ya lugha nyingine */
        if ($request->filled('translate')) {
            $otherLang   = $data['language'] === 'sw' ? 'en' : 'sw';
            $translated  = $this->translateText($data['content'], $data['language'], $otherLang);

            ContentTemplate::create([
                'title'     => $data['title'],
                'category'  => $data['category'],
                'language'  => $otherLang,
                'content'   => $translated,
                'regions'   => $data['regions'] ?? [],
                'crops'     => $data['crops']   ?? [],
                'status'    => $data['status']  ?? 'draft',
                'parent_id' => $template->id,    // optional: kufuatilia pair
            ]);
        }

        return redirect()
            ->route('content.index')
            ->with('success', 'Template saved successfully.');
    }

    /*--------------------------------------------------
    | Helper – LibreTranslate wrapper rahisi
    *-------------------------------------------------*/
    private function translateText(string $text, string $from, string $to): string
    {
        $res = Http::asForm()->post('https://libretranslate.de/translate', [
            'q'      => $text,
            'source' => $from,
            'target' => $to,
            'format' => 'text',
        ])->json();

        return $res['translatedText'] ?? $text;
    }
}
