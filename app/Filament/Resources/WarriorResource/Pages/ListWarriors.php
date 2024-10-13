<?php

namespace App\Filament\Resources\WarriorResource\Pages;

use App\Filament\Resources\WarriorResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListWarriors extends ListRecords
{
    protected static string $resource = WarriorResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
