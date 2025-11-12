<?php

namespace App\Filament\Resources\IncomingGoods\RelationManagers;

use App\Filament\Resources\IncomingGoods\IncomingGoodResource;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Filament\Tables\Columns;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TimePicker;
use Filament\Schemas\Components\Utilities\Get;



class ItemsRelationManager extends RelationManager
{
    protected static string $relationship = 'items';

    protected static ?string $relatedResource = IncomingGoodResource::class;

    protected static ?string $title = 'Daftar Barang Diterima';

    protected static ?string $label = 'Item Penerimaan';


    public function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Select::make('product_id')
                    ->relationship('product', 'nama_barang') 
                    ->searchable()
                    ->preload()
                    ->required()
                    ->columnSpan(2)
                    ->label('Nama Barang / Kode Barang'), // Mencari berdasarkan nama atau kode

                TextInput::make('received_qty')
                    ->label('Jumlah Diterima')
                    ->numeric()
                    ->required()
                    ->columnSpan(1),
                
                TextInput::make('price_per_unit')
                    ->label('Harga Beli Satuan')
                    ->numeric()
                    ->required()
                    ->columnSpan(1),
            ])
            ->columns(4); // Form 4 kolom untuk item detail
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Columns\TextColumn::make('product.kode_barang')
                    ->label('Kode'),
                    
                Columns\TextColumn::make('product.nama_barang')
                    ->label('Nama Barang'),

                Columns\TextColumn::make('received_qty')
                    ->label('Qty Diterima')
                    ->numeric(decimalPlaces: 2),

                Columns\TextColumn::make('product.uom.uom_name') // Asumsi relasi UOM ada di model Product
                    ->label('Satuan'),
                    
                Columns\TextColumn::make('price_per_unit')
                    ->label('Harga Satuan')
                    ->money('IDR', locale: 'id')
                    ->alignEnd(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                CreateAction::make(),
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ]);
    }
}
