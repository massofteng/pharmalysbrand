<?php
namespace ShamimShams\LWDatatable;

use Illuminate\Support\ServiceProvider;
use ShamimShams\LWDatatable\Components\Th;
use Illuminate\View\Compilers\BladeCompiler;
use ShamimShams\LWDatatable\Components\Table;

class LWDataTableServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->packagePublish();

        $this->loadViewsFrom( __DIR__ . '/../resources/views', 'lwdtbl' );

        $this->registerBladeComponents();
    }

    public function register()
    {
    }

    public function packagePublish()
    {
        $this->publishes([
            __DIR__ . '/../resources/assets' => public_path('assets/vendor/lw-datatable/'),
        ], 'assets');
    }

    public function registerBladeComponents()
    {
        $prefix = 'lwdtbl';

        $this->callAfterResolving( BladeCompiler::class, function ( BladeCompiler $blade ) use ( $prefix ) {
            $blade->component( Table::class, 'table', $prefix );
            $blade->component( Th::class, 'th', $prefix );
        } );
    }

}
