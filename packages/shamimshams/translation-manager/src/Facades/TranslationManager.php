<?php

namespace Shamimshams\TranslationManager\Facades;

use Illuminate\Support\Facades\Facade;

class TranslationManager extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'translation-manager';
    }
}
