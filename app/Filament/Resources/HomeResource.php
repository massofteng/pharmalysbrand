<?php

namespace App\Filament\Resources;

use App\Models\Home;
use Filament\Tables;
use App\Models\Country;
use App\Models\Category;
use App\Models\Language;
use App\Models\Continent;
use App\Pharmalys\Pharmalys;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Fieldset;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\HomeResource\Pages;

class HomeResource extends Resource
{
    protected static ?string $model = Home::class;

    protected static ?string $navigationLabel = 'Home';

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Hidden::make(Pharmalys::getFieldName('lang')),
                Hidden::make(Pharmalys::getFieldName('page_id'))->default(request()->query('page')),
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
                            Select::make('block_type')->label(__('Block Type'))
                                ->required()
                                ->options(Pharmalys::getBlockTypes())
                                ->columnSpan(2)
                                ->reactive(),
                            static::BlockContentField(),
                        ])->columnSpan(2),

                        Card::make()->schema([
                            Toggle::make('is_published')->label(__('Publish'))->default(false),
                            Select::make('category_id')
                                ->label('Category')
                                ->options(Category::all()->pluck('name', 'id')->toArray()),
                            TextInput::make('link')->placeholder('Block link')
                                ->required()
                                ->columnSpan(1),
                            DatePicker::make('published_at')
                                ->label(__('Published At'))
                                ->placeholder(__('Published At'))
                                ->default(now())->columns(1),
                        ])->columnSpan(1),
                    ])->columns(3)
                ])
            ])->columns(1);
    }

    public static function BlockContentField(): Fieldset
    {
        return Fieldset::make('block_content')
            ->label(__('Block Content'))
            ->schema(function (callable $get) {
                $selected_block_type = $get('block_type');
                if (!$selected_block_type) {
                    return [];
                }
                return Pharmalys::getBlcokForm($selected_block_type);
            })
            ->hidden(fn (callable $get) => !$get('block_type'))->columns(1);
    }

    public static function getEloquentQuery(): Builder
    {
        $page = request()->query('page');
        return static::getModel()::query()->withoutGlobalScopes()->with(['block_content'])->where('parent_id', 0)->orderBy('id', 'DESC');
    }

    public static function table(Table $table): Table
    {
        //dd($table);
        return $table
            ->columns([
                TextColumn::make('title')->sortable()->searchable(),
                TextColumn::make('block_type')->sortable()->searchable(),
                TextColumn::make('is_published'),
                TextColumn::make('block_content')->label(__('Block Content'))->getStateUsing(function (Model $record) {
                    return $record?->block_content?->content[0]['title'];
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
            'index' => Pages\ListHomes::route('/'),
            'create' => Pages\CreateHome::route('/create'),
            'edit' => Pages\EditHome::route('/{record}/edit'),
        ];
    }
}
