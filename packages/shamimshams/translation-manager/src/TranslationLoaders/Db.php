<?php

namespace ShamimShams\TranslationManager\TranslationLoaders;

use ShamimShams\TranslationManager\Models\TranslationManager;

class Db implements TranslationLoader
{
    public function loadTranslations( string $locale, string $group ): array
    {
        return TranslationManager::getTranslationsForGroup( $locale, $group );
    }

}
