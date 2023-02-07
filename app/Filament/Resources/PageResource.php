<?php

namespace App\Filament\Resources;

use Filament\Tables;
use App\Models\Country;
use App\Models\Language;
use App\Models\Continent;
use App\Models\PageBlock;
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
use Filament\Forms\Components\Tabs\Tab;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\PageResource\Pages;

class PageResource extends Resource
{
    protected static ?string $model = PageBlock::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    protected static bool $shouldRegisterNavigation = false;

    public static function form(Form $form): Form
    {
        $lang = 'en';
        return $form
            ->schema([
                //Tabs::make('Page Block')->schema(static::langWiseTabContent()),
                Hidden::make(Pharmalys::getFieldName('lang', $lang))->default($lang),
                Hidden::make(Pharmalys::getFieldName('page_id', $lang))->default(request()->query('page')),
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
                            TextInput::make(Pharmalys::getFieldName('title', $lang))->label('Block Title')->placeholder('Block Title')
                                ->required(fn () => config('pharmalys.default_language') == $lang)
                                ->columnSpan(2),
                            Select::make(Pharmalys::getFieldName('block_type', $lang))->label(__('Block Type'))
                                ->required(fn () => config('pharmalys.default_language') == $lang)
                                ->options(Pharmalys::getBlockTypes())
                                ->columnSpan(2)
                                ->reactive(),
                            static::BlockContentField($lang),
                        ])->columnSpan(2),

                        Card::make()->schema([
                            Toggle::make(Pharmalys::getFieldName('is_published', $lang))->label(__('Publish'))->default(false),
                            DatePicker::make(Pharmalys::getFieldName('published_at', $lang))
                                ->label(__('Published At'))
                                ->placeholder(__('Published At'))
                                ->default(now())->columns(1),
                        ])->columnSpan(1),

                    ])->columns(3)

                ])

            ])->columns(1);
    }

    /**
     * generate language wise tabs
     *
     * @return array
     */
    public static function langWiseTabContent(): array
    {
        $tabs = [];

        foreach (config('pharmalys.language') as $lang => $title) {
            $tabs[] = Tab::make($title)->schema([

                Hidden::make(Pharmalys::getFieldName('lang', $lang))->default($lang),
                Hidden::make(Pharmalys::getFieldName('page_id', $lang))->default(request()->query('page')),

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
                        TextInput::make(Pharmalys::getFieldName('title', $lang))->label('Block Title')->placeholder('Block Title')
                            ->required(fn () => config('pharmalys.default_language') == $lang)
                            ->columnSpan(2),
                        Select::make(Pharmalys::getFieldName('block_type', $lang))->label(__('Block Type'))
                            ->required(fn () => config('pharmalys.default_language') == $lang)
                            ->options(Pharmalys::getBlockTypes())
                            ->columnSpan(2)
                            ->reactive(),

                        static::BlockContentField($lang),

                    ])->columnSpan(2),

                    Card::make()->schema([
                        Toggle::make(Pharmalys::getFieldName('is_published', $lang))->label(__('Publish'))->default(false),
                        DatePicker::make(Pharmalys::getFieldName('published_at', $lang))
                            ->label(__('Published At'))
                            ->placeholder(__('Published At'))
                            ->default(now())->columns(1),
                    ])->columnSpan(1),

                ])->columns(3),
            ]);
        }
        return $tabs;
    }

    /**
     * generate block content by block type
     *
     * @param  string  $lang
     * @return Fieldset
     */
    public static function BlockContentField($lang): Fieldset
    {
        return Fieldset::make(Pharmalys::getFieldName('block_content', $lang))
            ->label(__('Block Content'))
            ->schema(function (callable $get) use ($lang) {
                $selected_block_type = $get(Pharmalys::getFieldName('block_type', $lang));

                if (!$selected_block_type) {
                    return [];
                }

                return Pharmalys::getBlcokForm($selected_block_type, $lang);
            })
            ->hidden(fn (callable $get) => !$get(Pharmalys::getFieldName('block_type', $lang)))->columns(1);
    }

    public static function getEloquentQuery(): Builder
    {
        $page = request()->query('page');
        return static::getModel()::query()->where('parent_id', 0)->where('page_id', $page);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')->sortable()->searchable(),
            ])
            ->filters([])
            ->actions([
                Tables\Actions\EditAction::make()->url(function (Model $record): string {
                    $url = route('filament.resources.page-blocks.edit', $record);
                    $page = request()->query('page');

                    return "{$url}?page={$page}";
                }),

                Tables\Actions\DeleteAction::make()->requiresConfirmation(),
                // Tables\Actions\Action::make('test')
                //     ->action(fn(Model $record) => info($record->id))
                //     ->form([
                //         TextInput::make('test')
                //     ])->modalHeading('Are you sure to delete?')

            ])
            ->bulkActions([
                // Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public function deleteBlock(PageBlock $record)
    {
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
            'index' => Pages\ListPages::route('/'),
            'create' => Pages\CreatePage::route('/create'),
            'edit' => Pages\EditPage::route('/{record}/edit'),
        ];
    }
}
