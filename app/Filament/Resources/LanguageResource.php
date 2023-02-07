<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Country;
use App\Models\Language;
use App\Models\Continent;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Columns\BooleanColumn;
use App\Filament\Resources\LanguageResource\Pages;


class LanguageResource extends Resource
{
    protected static ?string $model = Language::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()->schema([
                    Select::make('continent_id')
                        ->required()
                        ->label('Continent')
                        ->options(Continent::all()->pluck('name', 'id')->toArray())
                        ->reactive(),
                    Select::make('country_id')
                        ->required()
                        ->label('Country')
                        ->options(function (callable $get) {
                            $continent = Continent::find($get('continent_id'));
                            if (!$continent) {
                                return Country::all()->pluck('name', 'id');
                            }
                            return $continent->countries->pluck('name', 'id');
                        }),
                    TextInput::make('language_key')->required()->placeholder('Please enter language Key'),
                    TextInput::make('language_name')->required()->placeholder('Please enter language name'),
                    Toggle::make('status'),
                    Toggle::make('default')

                ])->columnSpan(1)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('language_name')->sortable()->searchable(),
                TextColumn::make('language_key')->sortable()->searchable(),
                TextColumn::make('country.name')->sortable()->searchable(),
                BooleanColumn::make('status'),
                BooleanColumn::make('default'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListLanguages::route('/'),
            'create' => Pages\CreateLanguage::route('/create'),
            'edit' => Pages\EditLanguage::route('/{record}/edit'),
        ];
    }
}
