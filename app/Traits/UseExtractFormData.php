<?php

namespace App\Traits;

use App\Pharmalys;

trait UseExtractFormData
{
    /**
     * recursively stripe language suffix from array key
     *
     * @param  array  $data
     * @param  string  $lang
     * @param  bool  $exclude_lang
     * @return array
     */
    private function sanitizeFieldNames(array $data, string $lang = 'en', bool $exclude_lang = false): array
    {
        $updated_data_array = [];

        $lang = $lang;

        $index = 0;

        foreach ($data as $key => $value) {
            $key_name = \App\Pharmalys\Pharmalys::extractFieldName($key);

            if (! $key_name) {
                $key_name = $index;

                $index++;
            }

            if ($key_name == 'lang') {
                $lang = substr($key, -2);

                continue;
            }

            if ($exclude_lang) {
                if (is_array($value)) {
                    $updated_data_array[$key_name] = $this->sanitizeFieldNames($value, $lang, true);
                } else {
                    $updated_data_array[$key_name] = $value;
                }

                continue;
            }

            if (is_array($value)) {
                $updated_data_array[$lang][$key_name] = $this->sanitizeFieldNames($value, $lang, true);
            } else {
                $updated_data_array[$lang][$key_name] = $value;
            }
        }

        return $updated_data_array;
    }
}
