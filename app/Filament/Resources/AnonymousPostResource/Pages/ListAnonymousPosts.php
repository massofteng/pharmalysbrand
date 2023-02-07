<?php

namespace App\Filament\Resources\AnonymousPostResource\Pages;

use App\Filament\Resources\AnonymousPostResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAnonymousPosts extends ListRecords
{
    protected static string $resource = AnonymousPostResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
