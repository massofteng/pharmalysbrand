<?php

namespace App\Filament\Resources\ContinentResource\Pages;

use App\Filament\Resources\ContinentResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Grid;

class CreateContinent extends CreateRecord
{
    protected static string $resource = ContinentResource::class;


    protected function getRedirectUrl(): string {
        return $this->getResource()::getUrl('index');
    }

}
