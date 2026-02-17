<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProjectResource\Pages;
use App\Filament\Resources\ProjectResource\RelationManagers;
use App\Models\Project;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class ProjectResource extends Resource
{
    protected static ?string $model = Project::class;

    protected static ?string $navigationIcon = 'heroicon-o-home-modern';
    protected static ?string $navigationLabel = 'Proyek';
    protected static ?string $modelLabel = 'Proyek';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->label('Judul Proyek')
                    ->autofocus()
                    ->required()
                    ->maxLength(255)
                    ->placeholder('Judul Proyek'),

                Forms\Components\Select::make('status')
                    ->label('Status')
                    ->required()
                    ->options([
                        'In Progress' => 'In Progress',
                        'Completed' => 'Completed',
                ]),

                Forms\Components\Select::make('province_id')
                    ->label('Provinsi')
                    ->searchable()
                    ->options(function () {
                        return Cache::remember('provinces_list', 60 * 24, function () {
                            $response = Http::get('https://emsifa.github.io/api-wilayah-indonesia/api/provinces.json');
                            if ($response->successful()) {
                                return collect($response->json())->mapWithKeys(fn($prov) => [
                                    $prov['id'] => $prov['name']
                                ])->toArray();
                            }
                            return [];
                        });
                    })
                    ->reactive()
                    ->required(),

                Forms\Components\Select::make('location')
                    ->label('Kota/Kabupaten')
                    ->searchable()
                    ->options(function (callable $get) {
                        $provinceId = $get('province_id');
                        if (! $provinceId) {
                            return [];
                        }

                        return Cache::remember("regencies_for_{$provinceId}", 60 * 24, function () use ($provinceId) {
                            $response = Http::get("https://emsifa.github.io/api-wilayah-indonesia/api/regencies/{$provinceId}.json");
                            if ($response->successful()) {
                                return collect($response->json())->mapWithKeys(fn($kab) => [
                                    $kab['name'] => $kab['name']
                                ])->toArray();
                            }
                            return [];
                        });
                    })
                    ->reactive()
                    ->required(),

                Forms\Components\DatePicker::make('start_date')
                    ->label('Tanggal Mulai')
                    ->required()
                    ->reactive()
                    ->maxDate(fn ($get) => $get('end_date')),

                Forms\Components\DatePicker::make('end_date')
                    ->label('Tanggal Selesai')
                    ->required()
                    ->reactive()
                    ->minDate(fn ($get) => $get('start_date')),

                Forms\Components\RichEditor::make('description')
                    ->label('Deskripsi Proyek')
                    ->required()
                    ->columnSpanFull()
                    ->placeholder('Project Description'),

                Forms\Components\FileUpload::make('thumbnail')
                    ->label('Thumbnail')
                    ->required()
                    ->image()
                    ->columnSpanFull()
                    ->directory('project-thumbnail'),

                Forms\Components\FileUpload::make('media')
                    ->label('Foto dan Video')
                    ->multiple()
                    ->acceptedFileTypes(['image/*', 'video/*'])
                    ->multiple()
                    ->directory('project-media')
                    ->required()
                    ->columnSpanFull()
                    ->panelLayout('grid')
                    ->openable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('updated_at', 'desc')
            ->columns([
                Tables\Columns\ImageColumn::make('thumbnail')
                    ->label('Thumbnail')
                    ->square()
                    ->height(60),
                Tables\Columns\TextColumn::make('title')
                    ->label('Judul')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('location')
                    ->label('Lokasi')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('start_date')
                    ->label('Tanggal Mulai')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('end_date')
                    ->label('Tanggal Selesai')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat Pada')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ]),
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
            'index' => Pages\ListProjects::route('/'),
            'create' => Pages\CreateProject::route('/create'),
            'view' => Pages\ViewProject::route('/{record}'),
            'edit' => Pages\EditProject::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}