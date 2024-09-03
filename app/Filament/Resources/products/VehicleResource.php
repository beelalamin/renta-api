<?php

namespace App\Filament\Resources\Products;

use App\Filament\Resources\Products\VehicleResource\Pages;
use App\Models\Products\Vehicle;
use Awcodes\Curator\Components\Forms\CuratorPicker;
use Awcodes\Curator\Components\Tables\CuratorColumn;
use Filament\Forms;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Split;
use Filament\Forms\Form;
use Filament\Resources\Concerns\Translatable;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class VehicleResource extends Resource
{
    use Translatable;



    protected static ?string $model = Vehicle::class;
    protected static ?string $navigationIcon = 'heroicon-o-rocket-launch';
    protected static ?string $navigationGroup = 'Fleet Management';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\MarkdownEditor::make('description')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\Section::make([
                    Forms\Components\TextInput::make('price')
                        ->required()
                        ->numeric()
                        ->suffix('per day')
                        ->prefix('QAR'),

                    Forms\Components\Select::make('categories')
                        ->relationship('categories', 'title')
                        ->native(false)
                        ->searchable()
                        ->preload()
                        ->multiple()
                        ->required(),
                    Forms\Components\Select::make('brand_id')
                        ->relationship('brand', 'name')
                        ->native(false)
                        ->preload()
                        ->searchable()
                        ->label('Brand'),

                    Forms\Components\TextInput::make('vehicle_number')
                        ->default('VHN-' . random_int(100000, 999999))
                        ->disabled()
                        ->dehydrated()
                        ->required()
                        ->maxLength(32)
                        ->unique(Vehicle::class, 'vehicle_number', ignoreRecord: true),
                ])->columns(2),

                Forms\Components\Section::make('Media')
                    ->description('JPG,JPEG,PNG and Webp only')
                    ->schema([
                        CuratorPicker::make('thumbnail_id')
                            ->label('Thumbnail')
                            ->relationship('thumbnail', 'id')
                            ->preserveFilenames()
                            ->size('sm'),
                        CuratorPicker::make('vehicle_media_ids')
                            ->relationship('images', 'id')
                            ->label('Images Gallary')
                            ->multiple(),
                    ])
                    ->collapsible(),
                Split::make([

                    Forms\Components\Section::make([
                        Forms\Components\Select::make('transmission')
                            ->options([
                                'manual' => 'Manual',
                                'automatic' => 'Automatic',
                            ])
                            ->native(false)
                            ->label('Transmission')
                            ->required(),

                        Forms\Components\Select::make('fuel_type')
                            ->options([
                                'gasoline' => 'Gasoline',
                                'hybrid' => 'Hybrid',
                                'electric' => 'Electric',
                            ])
                            ->native(false)
                            ->label('Type')
                            ->required(),

                        Forms\Components\TextInput::make('model')
                            ->numeric()
                            ->maxLength(4)
                            ->minValue(2000)
                            ->rule('max:' . now()->year),
                        Forms\Components\Select::make('seating_capicity')
                            ->options([
                                2 => 2,
                                4 => 4,
                                5 => 5,
                                6 => 6,
                                8 => 8,
                            ])
                            ->default(2)
                            ->native(false),
                        Forms\Components\TextInput::make('mileage')
                            ->maxValue(60.0)
                            ->default(5.6)
                            ->numeric()
                            ->reactive()
                            ->suffix('km/ltr')

                    ])->columns(2),
                    Forms\Components\Section::make([
                        Forms\Components\Toggle::make('isPublished')
                            ->reactive()
                            ->afterStateUpdated(function (callable $get, callable $set) {
                                if (!$get('isPublished')) {
                                    $set('isFeatured', false);
                                }
                            }),

                        Forms\Components\Toggle::make('isFeatured')
                            ->reactive()
                            ->disabled(fn(callable $get) => !$get('isPublished')),
                    ])->grow(false),
                ])->from('md')->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                CuratorColumn::make('thumbnail')
                    ->size(65)
                    ->square(),
                Tables\Columns\TextColumn::make('vehicle_number')
                    ->badge()
                    ->color('gray'),
                Tables\Columns\TextColumn::make('title')
                    ->searchable(),
                Tables\Columns\TextColumn::make('price')
                    ->money('QAR')
                    ->sortable(),
                Tables\Columns\TextColumn::make('brand.name'),
                Tables\Columns\TextColumn::make('fuel_type'),
                Tables\Columns\TextColumn::make('transmission'),
                Tables\Columns\TextColumn::make('seating_capicity'),
                Tables\Columns\TextColumn::make('mileage')
                    ->suffix('km/ltr'),
                Tables\Columns\IconColumn::make('is_published')
                    ->label('Published')
                    ->boolean(),
                Tables\Columns\IconColumn::make('is_featured')
                    ->label('Featured')
                    ->boolean(),
                Tables\Columns\TextColumn::make('createdBy.name')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updatedBy.name')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListVehicles::route('/'),
            'create' => Pages\CreateVehicle::route('/create'),
            'view' => Pages\ViewVehicle::route('/{record}'),
            'edit' => Pages\EditVehicle::route('/{record}/edit'),
        ];
    }


}
