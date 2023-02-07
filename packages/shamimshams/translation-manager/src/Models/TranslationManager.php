<?php
namespace ShamimShams\TranslationManager\Models;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;

class TranslationManager extends Model
{
    protected $table = "translation_manager";

    protected $guarded = ["id"];

    /**
     * @var array
     */
    public $translatable = ['text'];

    /**
     * @var array
     */
    protected $casts = ['text' => 'array'];

    public static function boot()
    {
        parent::boot();

        $flushGroupCache = function ( self $languageManager ) {
            $languageManager->flushGroupCache();
        };

        static::saved( $flushGroupCache );
        static::deleted( $flushGroupCache );
    }

    public static function getTranslationsForGroup( string $locale, string $group ): array
    {
        return Cache::rememberForever( static::getCacheKey( $group, $locale ), function () use ( $group, $locale ) {
            return static::query()
                ->where( 'group', $group )
                ->get()
                ->reduce( function ( $lines, self $languageManager ) use ( $locale ) {
                    $translation = $languageManager->getTranslation( $locale );

                    if ( null !== $translation ) {
                        Arr::set( $lines, $languageManager->key, $translation );
                    }

                    return $lines;
                } ) ?? [];
        } );
    }

    public static function getCacheKey( $group, $locale ): string
    {
        if ( empty( $group ) || $group == '*') {
            $group = "trans_string";
        }

        return "ltm.{$group}.{$locale}";
    }

    /**
     * @param  string   $locale
     * @return string
     */
    public function getTranslation( string $locale ): ?string
    {

        if ( !isset( $this->text[$locale] ) ) {
            $fallback = config( 'app.fallback_locale' );

            return $this->text[$fallback] ?? null;
        }

        return $this->text[$locale];
    }

    /**
     * @param  string  $locale
     * @param  string  $value
     * @return $this
     */
    public function setTranslation( string $locale, string $value )
    {
        $this->text = array_merge( $this->text ?? [], [$locale => $value] );

        return $this;
    }

    public function flushGroupCache()
    {

        foreach ( $this->getTranslatedLocales() as $locale ) {
            Cache::forget( static::getCacheKey( $this->group, $locale ) );
        }

    }

    protected function getTranslatedLocales(): array
    {
        return array_keys( $this->text );
    }

}
