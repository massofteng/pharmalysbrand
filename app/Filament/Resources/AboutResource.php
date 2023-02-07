<?php

namespace App\Filament\Resources;

use Filament\Tables;
use App\Models\About;
use App\Models\Country;
use App\Models\Language;
use App\Models\Continent;
use App\Pharmalys\Pharmalys;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Fieldset;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\DatePicker;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\AboutResource\Pages;


class AboutResource extends Resource
{
    protected static ?string $model = About::class;

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
                            Select::make('block_type')->label(__('Section Type'))
                                ->required()
                                ->options(Pharmalys::getAboutBlockTypes())
                                ->columnSpan(2)
                                ->reactive(),
                            static::AboutBlockContentField(),
                        ])->columnSpan(2),

                        Card::make()->schema([
                            Toggle::make('is_published')->label(__('Publish'))->default(false),
                            DatePicker::make('published_at')
                                ->label(__('Published At'))
                                ->placeholder(__('Published At'))
                                ->default(now())->columns(1),
                        ])->columnSpan(1),
                    ])->columns(3)
                ])
            ])->columns(1);
    }

    public static function AboutBlockContentField(): Fieldset
    {
        return Fieldset::make('block_content')
            ->label(__('Block Content'))
            ->schema(function (callable $get) {
                $selected_block_type = $get('block_type');
                if (!$selected_block_type) {
                    return [];
                }
                return Pharmalys::getAboutBlcokForm($selected_block_type);
            })
            ->hidden(fn (callable $get) => !$get('block_type'))->columns(1);
    }

    public static function getEloquentQuery(): Builder
    {
        $page = request()->query('page');
        return static::getModel()::query()->with(['block_content'])->withoutGlobalScopes()->where('parent_id', 0)->orderBy('id', 'DESC');
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // TextColumn::make('title')->sortable()->searchable(),
                TextColumn::make('block_type')->sortable()->searchable(),
                TextColumn::make('is_published'),
                TextColumn::make('block_content')->label(__('Block Content'))->getStateUsing(function (Model $record) {
                    return $record?->block_content?->content[0]['description'];
                }),
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
            'index' => Pages\ListAbouts::route('/'),
            'create' => Pages\CreateAbout::route('/create'),
            'edit' => Pages\EditAbout::route('/{record}/edit'),
        ];
    }
}
