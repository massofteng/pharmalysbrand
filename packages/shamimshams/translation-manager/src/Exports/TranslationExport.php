<?php

namespace ShamimShams\TranslationManager\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use ShamimShams\TranslationManager\Models\TranslationManager;

class TranslationExport implements FromCollection
{
    use Exportable;

    private $fileName = "";

    private $headers = [
        'Content-Type' => 'text/csv',
    ];

    public function __construct()
    {
        $this->items = TranslationManager::all();
        $this->fileName = "translation-" . date( "Ymdhis" ) . ".csv";
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return $this->items;
    }

    /**
    * @var TranslationManager $item
    */
    // public function map($item): array
    // {
    //     $translation = $item->text;
    //     $en = isset($translation['en']) ? $translation['en'] : '';
    //     $de = isset($translation['de']) ? $translation['de'] : '';
    //     $fr = isset($translation['fr']) ? $translation['fr'] : '';
    //     $it = isset($translation['it']) ? $translation['it'] : '';

    //     $data = [
    //         $item->id,
    //         $item->group,
    //         $item->key,
    //         $en,
    //         $de,
    //         $fr,
    //         $it,
    //     ];

    //     return $data;
    // }
}
