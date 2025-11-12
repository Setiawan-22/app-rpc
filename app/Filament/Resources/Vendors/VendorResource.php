<?php

namespace App\Filament\Resources\Vendors;

use App\Filament\Resources\Vendors\Pages\CreateVendor;
use App\Filament\Resources\Vendors\Pages\EditVendor;
use App\Filament\Resources\Vendors\Pages\ListVendors;
use App\Filament\Resources\Vendors\Pages\ViewVendor;
use App\Filament\Resources\Vendors\Schemas\VendorForm;
use App\Filament\Resources\Vendors\Schemas\VendorInfolist;
use App\Filament\Resources\Vendors\Tables\VendorsTable;
use App\Models\Vendor;
use BackedEnum;
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
use Illuminate\Database\Eloquent\Model;


class VendorResource extends Resource
{
    protected static ?string $model = Vendor::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    //protected static ?string $navigationGroup = 'Master Data';

    protected static ?string $recordTitleAttribute = 'Supplier';

    public static function getNavigationLabel(): string
    {
        return 'Suppliers';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                TextInput::make('vendor_code')
                    ->label('Kode Vendor')
                    ->unique(ignoreRecord: true)
                    ->required()
                    ->maxLength(20)
                    ->columnSpan(1),

                TextInput::make('vendor_name')
                    ->label('Nama Vendor')
                    ->required()
                    ->maxLength(255)
                    ->columnSpan(2),
                
                // INFORMASI KONTAK & ALAMAT
                Components\Section::make('Kontak & Alamat')
                    ->columns(3)
                    ->schema([
                        TextInput::make('contact_person')
                            ->label('Kontak Person')
                            ->maxLength(100)
                            ->columnSpan(1),
                        
                        TextInput::make('phone')
                            ->label('Telepon')
                            ->tel()
                            ->maxLength(30)
                            ->columnSpan(1),
                        
                        TextInput::make('email')
                            ->label('Email')
                            ->email()
                            ->maxLength(100)
                            ->columnSpan(1),
                        
                        Textarea::make('address') // Gunakan Textarea (diimpor di atas)
                            ->label('Alamat')
                            ->nullable()
                            ->columnSpanFull(),
                    ])
                    ->columnSpanFull(), // Section ini mengambil lebar penuh
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Columns\TextColumn::make('vendor_code')
                    ->label('Kode')
                    ->searchable()
                    ->sortable(),

                Columns\TextColumn::make('vendor_name')
                    ->label('Nama Vendor')
                    ->searchable()
                    ->sortable(),

                Columns\TextColumn::make('contact_person')
                    ->label('Kontak')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Columns\TextColumn::make('phone')
                    ->label('Telepon')
                    ->searchable(),

                Columns\TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                
                Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('vendor_name', 'asc');
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListVendors::route('/'),
            'create' => CreateVendor::route('/create'),
            'view' => ViewVendor::route('/{record}'),
            'edit' => EditVendor::route('/{record}/edit'),
        ];
    }
}
