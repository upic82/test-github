<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Section;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\UserResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\UserResource\RelationManagers;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationGroup = 'Users Management';

    public static function getNavigationSort(): ?int
    {
        return 8;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

            //card
            Section::make()
                ->schema([

                //name
                Forms\Components\TextInput::make('name')
                    ->label('Name')
                    ->placeholder('Name')
                    ->required(),

                //email
                Forms\Components\TextInput::make('email')
                    ->label('Email')
                    ->placeholder('Email')
                    ->unique(ignorable: fn ($record) => $record)
                    ->required(),

                //password
                Forms\Components\TextInput::make('password')
                    ->label('Password')
                    ->placeholder('Password')
                    ->dehydrateStateUsing(fn ($state) => $state ? bcrypt($state) : null)
                    ->dehydrated(fn ($state) => filled($state)) // hanya mengubah password jika field diisi
                    ->password(),

                ])

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->searchable(),
                Tables\Columns\TextColumn::make('email')->searchable(),
                Tables\Columns\TextColumn::make('created_at')->dateTime(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
