<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';

    protected static ?string $navigationGroup = 'Master Data';

    public static function getNavigationSort(): ?int
    {
        return 2;
    }
    public static function form(Form $form): Form
    {
        return $form
        ->schema([

            //card
            Section::make()
            ->schema([

                //image
                Forms\Components\FileUpload::make('image')
                    ->label('Product Image')
                    ->placeholder('Product Image')
                    ->required(),

                //title
                Forms\Components\TextInput::make('title')
                    ->label('Product Title')
                    ->placeholder('Product Title')
                    ->required(),

                Forms\Components\Grid::make(3)->schema([

                    //category
                    Forms\Components\Select::make('category_id')
                        ->label('Category')
                        ->relationship('category', 'name')
                        ->required(),

                    //price
                    Forms\Components\TextInput::make('price')
                        ->label('Price')
                        ->placeholder('Price')
                        ->required(),

                    //weight
                    Forms\Components\TextInput::make('weight')
                        ->label('Weight')
                        ->placeholder('Weight')
                        ->required(),
                ]),

                //description
                Forms\Components\RichEditor::make('description')
                    ->label('Product Description')
                    ->placeholder('Product Description')
                    ->required(),

            ])

        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image')->circular(),
                TextColumn::make('title')->searchable(),
                TextColumn::make('category.name')->searchable(),
                TextColumn::make('price')->numeric(decimalPlaces: 0)->money('IDR', locale: 'id'),
                TextColumn::make('description')->html()->limit(50),
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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
