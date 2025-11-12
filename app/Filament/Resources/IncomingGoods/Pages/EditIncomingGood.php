<?php

namespace App\Filament\Resources\IncomingGoods\Pages;

use App\Filament\Resources\IncomingGoods\IncomingGoodResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditIncomingGood extends EditRecord
{
    protected static string $resource = IncomingGoodResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
