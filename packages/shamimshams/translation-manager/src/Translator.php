<?php
namespace Shamimshams\TranslationManager;

use Illuminate\Support\Arr;
use Illuminate\Contracts\Translation\Loader;
use Illuminate\Translation\Translator as BaseTranslator;

class Translator extends BaseTranslator
{

    public function __construct( Loader $loader, $locale )
    {
        parent::__construct( $loader, $locale );
    }

}
