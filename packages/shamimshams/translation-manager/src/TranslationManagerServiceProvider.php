<?php

namespace ShamimShams\TranslationManager;

use Livewire\Livewire;
use Illuminate\Translation\TranslationServiceProvider;
use ShamimShams\TranslationManager\Components\ManageTranslationComponent;

class TranslationManagerServiceProvider extends TranslationServiceProvider
{
    const CONFIG_PATH = __DIR__ . '/../config/ltm.php';

    public function boot()
    {
        $this->publishes( [
            self::CONFIG_PATH => config_path( 'ltm.php' ),
        ], 'config' );

        $this->loadViewsFrom( __DIR__ . '/../resources/views', 'ltm' );
        $this->loadHelpers();
        $this->registerLivewireComponents();
    }

    public function register()
    {
        parent::register();

        $this->app->singleton( 'translator', function ( $app ) {
            $loader = $app['translation.loader'];

            $locale = $app['config']['app.locale'];

            $trans = new Translator( $loader, $locale );

            $trans->setFallback( $app['config']['app.fallback_locale'] );

            return $trans;
        } );

    
        $this->loadRoutesFrom( __DIR__ . '/routes.php' );
        $this->mergeConfigFrom( self::CONFIG_PATH, 'ltm' );

    }

    public function loadHelpers()
    {

        foreach ( glob( __DIR__ . '/Helpers/*.php' ) as $filename ) {
            require_once $filename;
        }

    }

    protected function registerLivewireComponents()
    {
        Livewire::component( 'ltm-translation-manager', ManageTranslationComponent::class );
    }

    protected function registerLoader()
    {
        $this->app->singleton( 'translation.loader', function ( $app ) {
            $class = config( 'ltm.translation_manager' );

            return new $class( $app['files'], $app['path.lang'] );
        } );
    }

    public function isDeferred()
    {
        return false;
    }

}
