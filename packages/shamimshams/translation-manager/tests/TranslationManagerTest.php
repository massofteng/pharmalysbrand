<?php

namespace Shamimshams\TranslationManager\Tests;

use Shamimshams\TranslationManager\Facades\TranslationManager;
use Shamimshams\TranslationManager\ServiceProvider;
use Orchestra\Testbench\TestCase;

class TranslationManagerTest extends TestCase
{
    protected function getPackageProviders($app)
    {
        return [ServiceProvider::class];
    }

    protected function getPackageAliases($app)
    {
        return [
            'translation-manager' => TranslationManager::class,
        ];
    }

    public function testExample()
    {
        $this->assertEquals(1, 1);
    }
}
