<?php

namespace App\Filament\Resources\IncomingGoods\Pages;

use App\Filament\Resources\IncomingGoods\IncomingGoodResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListIncomingGoods extends ListRecords
{
    protected static string $resource = IncomingGoodResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
