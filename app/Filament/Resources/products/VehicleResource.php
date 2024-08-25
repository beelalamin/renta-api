<?php

namespace App\Filament\Resources\products;

use App\Filament\Resources\products\VehicleResource\Pages;
use App\Models\products\Vehicle;
use Awcodes\Curator\Components\Forms\CuratorPicker;
use Awcodes\Curator\Components\Tables\CuratorColumn;
use Filament\Forms;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Split;
use Filament\Forms\Form;
use Filament\Resources\Concerns\Translatable;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

use function Pest\Laravel\options;

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

                    Forms\Components\Select::make('category_id')
                        ->relationship('categories', 'title')
                        ->label('Category')
                        ->native(false)
                        ->searchable()
                        ->preload()
                        ->multiple()
                        ->required(),
                    Forms\Components\Select::make('brand_id')
                        ->relationship('brand', 'brand_name')
                        ->native(false)
                        ->preload()
                        ->searchable()
                        ->label('Brand'),
                    Forms\Components\TextInput::make('vehicle_number')
                        ->label('Vehicle Number')
                        ->required(),

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

                        Forms\Components\Select::make('booking_type')
                            ->options([
                                'rental' => 'Rental',
                                'subscription' => 'Subscription',
                                'both' => 'Both',
                            ])
                            ->native(false)
                            ->required(),

                        Repeater::make('attributes')
                            ->schema([
                                Forms\Components\TextInput::make('name')->required(),
                                Forms\Components\TextInput::make('value')->required(),
                            ])->columns(2)
                            ->addActionLabel('Add Attribute')
                            ->defaultItems(2)
                            ->collapsible()
                            ->cloneable()
                    ]),

                    Forms\Components\Section::make([
                        Forms\Components\Toggle::make('status')
                            ->label('Availablity'),
                        Forms\Components\Toggle::make('isFeatured'),
                        Forms\Components\Toggle::make('isPublished'),
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
                Tables\Columns\TextColumn::make('title')
                    ->searchable(),
                Tables\Columns\TextColumn::make('price')
                    ->money('QAR')
                    ->sortable(),
                Tables\Columns\TextColumn::make('booking_type')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'both' => 'gray',
                        'rental' => 'warning',
                        'subscription' => 'success',
                    }),
                Tables\Columns\TextColumn::make('brand.brand_name'),
                Tables\Columns\TextColumn::make('vehicle_number')
                    ->badge()
                    ->color('gray')
                    ->prefix('QAR'),
                Tables\Columns\IconColumn::make('status')
                    ->label('Availability')
                    ->boolean(),
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
