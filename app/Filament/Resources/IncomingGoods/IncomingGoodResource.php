<?php

namespace App\Filament\Resources\IncomingGoods;

use App\Filament\Resources\IncomingGoods\Pages\CreateIncomingGood;
use App\Filament\Resources\IncomingGoods\Pages\EditIncomingGood;
use App\Filament\Resources\IncomingGoods\Pages\ListIncomingGoods;
use App\Filament\Resources\IncomingGoods\Schemas\IncomingGoodForm;
use App\Filament\Resources\IncomingGoods\Tables\IncomingGoodsTable;
use App\Models\IncomingGood;
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
use App\Filament\Resources\IncomingGoods\RelationManagers\ItemsRelationManager;


class IncomingGoodResource extends Resource
{
    protected static ?string $model = IncomingGood::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'payment';

    public static function getNavigationLabel(): string
    {
        return 'Goods Receipt (GR)';
    }

    public static function form(Schema $schema): Schema
    {
       return $schema
            ->schema([
                // --- INFORMASI HEADER ---
                Components\Section::make('Detail Transaksi')
                    ->columns(3)
                    ->schema([
                        /*TextInput::make('reference_no')
                            ->label('Nomor Referensi/GRN')
                            ->unique(ignoreRecord: true)
                            ->disabled()
                            ->dehydrated(true),*/
                            
                        DateTimePicker::make('receipt_date')
                            ->label('Tanggal Penerimaan')
                            ->default(now())
                            ->required(),
                            
                        Select::make('vendor_id')
                            ->relationship('vendor', 'vendor_name') 
                            ->label('Supplier (Vendor)')
                            ->required()
                            ->searchable()
                            ->preload(),
                    ]),

                // --- TERMIN PEMBAYARAN DENGAN KONDISIONAL LOGIC ---
                Components\Section::make('Pembayaran')
                    ->columns(3)
                    ->schema([
                        Select::make('payment_type')
                            ->label('Tipe Pembayaran')
                            ->options([
                                'CASH' => 'Tunai (CASH)',
                                'TEMPO' => 'Jatuh Tempo (TEMPO)',
                                'COD' => 'Bayar di Tempat (COD)',
                            ])
                            ->required()
                            ->default('CASH')
                            ->live(), // Penting: Agar field di bawahnya bisa bereaksi

                        DatePicker::make('due_date')
                            ->label('Tanggal Jatuh Tempo (Due Date)')
                            ->required()
                            // Logika Kondisional: Field hanya muncul jika payment_type adalah 'TEMPO'
                            ->visible(fn (Get $get): bool => $get('payment_type') === 'TEMPO')
                            ->columnSpan(2),
                    ]),
                // -----------------------------------------------------
                
                Textarea::make('notes')
                    ->label('Catatan Transaksi')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Columns\TextColumn::make('reference_no')
                    ->label('No. Ref')
                    ->searchable()
                    ->sortable(),

                Columns\TextColumn::make('vendor.vendor_name')
                    ->label('Vendor')
                    ->searchable(),

                Columns\TextColumn::make('payment_type')
                    ->label('Tipe Bayar')
                    ->badge()
                    ->sortable(),

                Columns\TextColumn::make('due_date')
                    ->label('Jatuh Tempo')
                    ->date(),
                
                Columns\TextColumn::make('receipt_date')
                    ->label('Tgl. Terima')
                    ->dateTime()
                    ->sortable(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            ItemsRelationManager::class, // <-- Daftarkan Relation Manager di sini
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListIncomingGoods::route('/'),
            'create' => CreateIncomingGood::route('/create'),
            'edit' => EditIncomingGood::route('/{record}/edit'),
        ];
    }
}
