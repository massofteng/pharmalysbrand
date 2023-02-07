<?php

namespace App\Filament\Resources;

use Filament\Tables;
use App\Models\Brand;
use App\Models\Country;
use App\Models\Language;
use App\Models\Continent;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\BrandResource\Pages;

class BrandResource extends Resource
{
    protected static ?string $model = Brand::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()->schema([
                    Grid::make()->schema([
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
                                })
                                ->reactive(),
                            Select::make('language_id')
                                ->required()
                                ->label('Language Name')
                                ->options(function (callable $get) {
                                    $country = Country::find($get('country_id'));
                                    if (!$country) {
                                        return Language::all()->pluck('language_name', 'id');
                                    }
                                    return $country->languages->pluck('language_name', 'id');
                                }),
                            TextInput::make('title')->label('Block Title')->placeholder('Block Title')
                                ->required()
                                ->columnSpan(2),
                            Textarea::make('description')->required()->rows(2)->columnSpan(2),
                        ])->columnSpan(2),

                        Card::make()->schema([
                            Toggle::make('is_published')->label(__('Publish'))->default(false),
                            DatePicker::make('published_at')
                                ->label(__('Published At'))
                                ->placeholder(__('Published At'))
                                ->default(now())->columns(1),
                            TextInput::make('link')->placeholder('Block link')
                                ->required()
                                ->columnSpan(1),
                            FileUpload::make('logo')->image()->maxSize(500)->required(),
                        ])->columnSpan(1),

                    ])->columns(3)
                ])
            ])->columns(1);
    }

    public static function getEloquentQuery(): Builder
    {
        $page = request()->query('page');
        return static::getModel()::query()->withoutGlobalScopes()->where('author_id', '!=', '')->orderBy('id', 'DESC');
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')->sortable()->searchable(),
                TextColumn::make('description'),
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
            'index' => Pages\ListBrands::route('/'),
            'create' => Pages\CreateBrand::route('/create'),
            'edit' => Pages\EditBrand::route('/{record}/edit'),
        ];
    }
}
