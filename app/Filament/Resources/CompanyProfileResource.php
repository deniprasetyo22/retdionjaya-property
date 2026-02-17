<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\CompanyProfile;
use Filament\Resources\Resource;
use Illuminate\Support\HtmlString;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Repeater;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Filters\TrashedFilter;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\CompanyProfileResource\Pages;
use App\Filament\Resources\CompanyProfileResource\RelationManagers;

class CompanyProfileResource extends Resource
{
    protected static ?string $model = CompanyProfile::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office-2';
    protected static ?string $navigationLabel = 'Profil Perusahaan';
    protected static ?string $modelLabel = 'Profil Perusahaan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                RichEditor::make('about')
                    ->label('Tentang Kami')
                    ->placeholder('Tentang Kami')
                    ->columnSpanFull()
                    ->autofocus()
                    ->required(),

                RichEditor::make('vision')
                    ->label('Visi')
                    ->placeholder('Visi')
                    ->columnSpanFull()
                    ->required(),

                RichEditor::make('mission')
                    ->label('Misi')
                    ->placeholder('Misi')
                    ->columnSpanFull()
                    ->required(),

                TextInput::make('video_link')
                    ->label(new HtmlString('Link Video <small class="text-gray-500" style="font-size: 0.8em;">(ex: https://youtu.be/Gx-jDkR55aU -> Gx-jDkR55aU)</small>'))
                    ->placeholder('Link Video')
                    ->columnSpanFull(),

                Section::make('Achievements')
                    ->schema([
                        Repeater::make('achievements')
                            ->label(new HtmlString(
                                'Prestasi <span class="text-xs text-gray-400 italic">(Optional)</span>'
                            ))
                            ->schema([
                                RichEditor::make('description')
                                    ->label('Deskripsi')
                                    ->placeholder('Deskripsi'),

                                FileUpload::make('image')
                                    ->label('Gambar')
                                    ->image()
                                    ->disk('public')
                                    ->directory('achievements'),
                            ])
                            ->columnSpanFull()
                            ->addActionLabel('Add Achievement')
                    ]),

                Section::make('Portfolio')
                    ->schema([
                        Repeater::make('portfolio')
                            ->label(new HtmlString(
                                'Portofolio <span class="text-xs text-gray-400 italic">(Optional)</span>'
                            ))
                            ->schema([
                                TextInput::make('title')
                                    ->label('Judul')
                                    ->placeholder('Judul'),

                                RichEditor::make('description')
                                    ->label('Deskripsi')
                                   ->placeholder('Deskripsi'),

                                FileUpload::make('image')
                                    ->label('Gambar')
                                    ->image()
                                    ->disk('public')
                                    ->directory('portfolio'),
                            ])
                            ->columnSpanFull()
                            ->addActionLabel('Add Portfolio'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('about')
                    ->label('Tentang Kami')
                    ->limit(50) // ✅ max 50 karakter di table
                    ->html()    // karena dari RichEditor
                    ->wrap()
                    ->tooltip(fn($record) => strip_tags($record->about)),

                TextColumn::make('vision')
                    ->label('Visi')
                    ->limit(40)
                    ->html()
                    ->wrap()
                    ->tooltip(fn($record) => strip_tags($record->vision)),

                TextColumn::make('mission')
                    ->label('Misi')
                    ->limit(40)
                    ->html()
                    ->wrap()
                    ->tooltip(fn($record) => strip_tags($record->mission)),

                TextColumn::make('updated_at')
                    ->label('Diperbarui Pada')
                    ->dateTime('d M Y H:i'),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                    Tables\Actions\ForceDeleteAction::make(),
                    Tables\Actions\RestoreAction::make(),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
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
            'index' => Pages\ListCompanyProfiles::route('/'),
            'create' => Pages\CreateCompanyProfile::route('/create'),
            'view' => Pages\ViewCompanyProfile::route('/{record}'),
            'edit' => Pages\EditCompanyProfile::route('/{record}/edit'),
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