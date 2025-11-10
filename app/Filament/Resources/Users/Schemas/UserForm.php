<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role; // <-- Impor Role Spatie
use Spatie\Permission\Models\Permission; // <-- Impor Permission Spatie

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(2)
            ->schema([
                // --------------------------------------------------------
                // 1. INFORMASI DASAR USER
                // --------------------------------------------------------
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                
                TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(255),

                // --------------------------------------------------------
                // 2. PASSWORD FIELD (Penting untuk Keamanan)
                // --------------------------------------------------------
                TextInput::make('password')
                    ->password()
                    ->maxLength(255)
                    ->dehydrateStateUsing(fn (string $state): string => Hash::make($state)) // Otomatis hash
                    ->dehydrated(fn (?string $state): bool => filled($state)) // Hanya simpan jika diisi
                    ->required(fn (string $operation): bool => $operation === 'create') // Wajib saat create
                    ->columnSpanFull(), // Ambil lebar penuh

                // --------------------------------------------------------
                // 3. FIELD ROLE AND PERMISSION (INTEGRASI SPATIE)
                // --------------------------------------------------------
                
                // FIELD ROLES
                Select::make('roles')
                    ->relationship('roles', 'name') // Ambil relasi roles() dari User Model
                    ->multiple()
                    ->preload()
                    ->searchable()
                    ->required()
                    ->columnSpan(1), // Ambil setengah lebar

                // FIELD PERMISSIONS (Untuk Permission Langsung)
                Select::make('permissions')
                    ->relationship('permissions', 'name') // Ambil relasi permissions() dari User Model
                    ->multiple()
                    ->preload()
                    ->searchable()
                    ->columnSpan(1), // Ambil setengah lebar
        ]);
    }
}
