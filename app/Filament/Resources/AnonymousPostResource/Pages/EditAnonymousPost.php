<?php

namespace App\Filament\Resources\AnonymousPostResource\Pages;

use App\Filament\Resources\AnonymousPostResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAnonymousPost extends EditRecord
{
    protected static string $resource = AnonymousPostResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
