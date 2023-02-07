<?php

namespace ShamimShams\TranslationManager\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Validators\Failure;
use ShamimShams\TranslationManager\Models\TranslationManager;

class TranslationImport implements ToCollection,WithChunkReading
{
    use Importable;
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection(Collection $rows)
    {
        foreach($rows as $row) {

            // $text = [
            //     'en' => $row[3] ? $row[3] : '',
            //     'de' => $row[4] ? $row[4] : '',
            //     'fr' => $row[5] ? $row[5] : '',
            //     'it' => $row[6] ? $row[6] : '',
            // ];

            $text = json_decode($row[3]);

            $data['group']      = $row[1];
            $data['key']        = $row[2];
            $data['text']       = is_null($text) ? [] : $text;
            $data['created_at'] = date('Y-m-d H:i:s');
            $data['updated_at'] = date('Y-m-d H:i:s');

            if (is_null($data['text'])) {
                logger($data);
            }

            $where['group'] = $data['group'];
            $where['key']   = $data['key'];

            return TranslationManager::updateOrCreate($where, $data);
        }
    }

    public function chunkSize(): int
    {
        return 100;
    }

}
