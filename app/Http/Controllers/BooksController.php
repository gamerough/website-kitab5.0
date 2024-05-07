<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Books;

class BooksController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $books = Books::all();
        if (request()->is('api/*')) {
            return response()->json($books);
        }
        return view('scripture',compact('books'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public  function detail_scripture(Request $request, $book){
        $chapter = $request->query('chapter');
        $books = Books::where('books', $book)->get();
        if (empty($books->first()->API_Gateaway)){
            return response()->json(['error' => 'API Gateaway tidak ditemukan.'], 404);
        }
        $list_books = NULL;
        $list_chapters = NULL;
        $data_chapter = NULL;

        // GET LIST CHAPTER
            // Islam
            if ($books->first()->agama == 'Islam') {
                if (empty($chapter)){
                    $chapter = 1;
                }
                $list_chapters = $this->format_list_chapter_AlQuran($book);
                $data_chapter = $this->format_DetailChapter_AlQuran($chapter);
                if ($request->is('api/*')) {
                    return response()->json([
                        'religion' => $books->first()->agama,
                        'books' => $books,
                        'list_chapters' => $list_chapters,
                        'data_chapter' => $data_chapter,
                    ]);
                }
            }
            // End Islam

            // KRISTEN
            if ($books->first()->agama == 'Kristen') {
                $book_chapters = $request->query('book');
                if (empty($chapter) || empty($book_chapters)){
                    $book_chapters = 'GEN';
                    $chapter = $book_chapters . '.1';
                }

                $list_books = $this->format_list_books_bible($book);
                $list_chapters = $this->format_list_chapters_bible($book,$book_chapters, $book_chapters);
                $data_chapter = $this->format_DetailChapter_bible($book, $chapter);
                if ($request->is('api/*')) {
                    return response()->json([
                        'religion' => $books->first()->agama,
                        'books' => $books,
                        'list_chapters' => $list_chapters,
                        'data_chapter' => $data_chapter,
                    ]);
                }
            }
            // END KRISTEN
        // END GET LIST CHAPTER
    
        $data = [
            'religion' => $books->first()->agama,
            'books' => $books,
            'list_books' => $list_books,
            'list_chapters' => $list_chapters,
            'data_chapter' => $data_chapter,
        ];
        if (isset($data['data_chapter']['error'])) {
            return response()->json($data['data_chapter'], 404);
        }
        dd($data);
        return view('kitab', compact('data'));
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }


    /**
     * Format the al-quran data.
     */
    public function format_list_chapter_AlQuran()
    {
        $API = Books::where('agama', 'Islam')->first()->API_Gateaway;
        if (empty($API)){
            return response()->json(['error' => 'API Gateaway tidak ditemukan.'], 404);
        }

        $response = Http::get($API . '/surat');
        if ($response->successful()) {
            $data = $response->json();
            
            $format_data = [];
            foreach ($data['data'] as $key => $value) {
                $format_data[] = [
                    'id' => $value['nomor'],
                    'name' => $value['namaLatin'],
                    'total_verses' => $value['jumlahAyat'],
                    'place' => $value['tempatTurun'],
                    'translation' => $value['arti'],
                ];
            }
            return $format_data;
        }
        return [
            'error' => 'Gagal mengambil data chapter.'
        ];
    }

    public function format_DetailChapter_AlQuran($chapter){
        $API = Books::where('agama', 'Islam')->first()->API_Gateaway;
        if (empty($API)){
            return response()->json(['error' => 'API Gateaway tidak ditemukan.'], 404);
        }
        $response = Http::get($API . '/surat/' . $chapter);
        $format_chapter = [];
        if($response->successful()){
            $chapter = $response->json();
            $format_chapter = [
                'chapter_id' => $chapter['data']['nomor'],
                'chapter_name' => $chapter['data']['namaLatin'],
                'translation' => $chapter['data']['arti'],
                'verses' => $chapter['data']['ayat'],
                'description' => $chapter['data']['deskripsi'],
            ];
            return $format_chapter;
        }
        return $format_chapter;
    }

    /**
     * Format the bibles data
     */
    public function format_list_books_bible($book){
        $API = Books::where('books', $book)->first()->API_Gateaway;
        if (empty($API)){
            return response()->json(['error' => 'API Gateaway tidak ditemukan.'], 404);
        }

        $api_key = Books::where('books', $book)->first()->api_key;
        if(empty($api_key)){
            return response()->json(['error' => 'API Key tidak ditemukan.'], 404);
        }
        $response = Http::withHeaders([
            'api-key' => $api_key,
        ])->get($API . '/books');
        if ($response->successful()) {
            $data = $response->json();
            $format_data = [];
            $i = 1;
            foreach ($data['data'] as $key => $value) {
                $format_data[] = [
                    'id' => $i,
                    'code' => $value['id'],
                    'name' => $value['name'],
                ];
                $i++;
            }
            return $format_data;
        }
        return [
            'error' => 'Gagal mengambil data chapter.'
        ];
    }

    public function format_list_chapters_bible($book, $book_id){ // https://api.scripture.api.bible/v1/bibles/2dd568eeff29fb3c-02/books/GEN/chapters
        $API = Books::where('books', $book)->first()->API_Gateaway;
        if (empty($API)){
            return response()->json(['error' => 'API Gateaway tidak ditemukan.'], 404);
        }

        $api_key = Books::where('books', $book)->first()->api_key;
        if(empty($api_key)){
            return response()->json(['error' => 'API Key tidak ditemukan.'], 404);
        }
        $response = Http::withHeaders([
            'api-key' => $api_key,
        ])->get($API . '/books/' . $book_id . '/chapters');
        
        if ($response->successful()) {
            $data = $response->json();
            $format_data = [];
            $i = 1;
            foreach ($data['data'] as $key => $value) {
                $format_data[] = [
                    'id' => $value['id'],
                    'name' => $value['reference'],
                ];
                $i++;
            }
            return $format_data;
        }
        return [
            'error' => 'Gagal mengambil data books.'
        ];
    }

    public function format_DetailChapter_bible($book, $chapter_id){
        $API = Books::where('books', $book)->first()->API_Gateaway;
        if (empty($API)){
            return response()->json(['error' => 'API Gateaway tidak ditemukan.'], 404);
        }

        $api_key = Books::where('books', $book)->first()->api_key;
        if(empty($api_key)){
            return response()->json(['error' => 'API Key tidak ditemukan.'], 404);
        }
        $response = Http::withHeaders([
            'api-key' => $api_key,
        ])->get($API . '/chapters/' . $chapter_id. '?content-type=json&include-notes=false&include-titles=false&include-chapter-numbers=false&include-verse-numbers=false&include-verse-spans=false');
        if ($response->successful()) {
            $data = $response->json();
            $format_data = [
                'id' => $data['data']['id'],
                'book_id' => $data['data']['bookId'],
                'chapter_name' => $data['data']['reference'],
                'verses' => $data['data']['content'],
                'total_verses' => $data['data']['verseCount'],
                // 'verses' => (function($data){
                //     $verses = [];
                //     foreach ($data['data']['content'] as $key => $value) {
                //         $verses = array_merge($verses, $this->combineVerses($value['items']));
                //     }
                //     return $verses;
                // })( $data ),
            ];
            return $format_data;
        }
        return [
            'error' => 'Gagal mengambil data chapter.'
        ];
    }
    
    function combineVerses($verses) {
        $combinedVerses = [];
        foreach ($verses as $verse) {
            $verseId = $verse['attrs']['verseId'];
            $text = $verse['text'];
            if (!isset($combinedVerses[$verseId])) {
                $combinedVerses[$verseId] = [
                    'text' => $text,
                    'type' => $verse['type'],
                    'attrs' => $verse['attrs'],
                ];
            } else {
                if (strlen($text) <= 13) {
                    continue;
                }
                $combinedVerses[$verseId]['text'] .= ' ' . $text;
            }
        }

        return array_values($combinedVerses);
    }
}
