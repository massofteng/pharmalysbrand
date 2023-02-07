<?php

namespace App\Filament\Resources\ContinentResource\Pages;

use App\Filament\Resources\ContinentResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditContinent extends EditRecord
{
    protected static string $resource = ContinentResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string {
        return $this->getResource()::getUrl('index');
    }

}
