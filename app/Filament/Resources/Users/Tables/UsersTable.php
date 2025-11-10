<?php

namespace App\Filament\Resources\Users\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;

class UsersTable
{
    public static function configure(Table $table): Table
    {
return $table
            ->columns([
                // Kolom yang sudah ada
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('email')
                    ->searchable(),

                // KOLOM ROLE BARU
                TextColumn::make('roles.name') // Akses nama role melalui relasi
                    ->badge() // Tampilkan sebagai badge/label
                    ->separator(',') // Jika user punya banyak role
                    ->searchable()
                    ->sortable(),
                
                // Kolom lainnya (timestamps, dll.)
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                // ...
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
