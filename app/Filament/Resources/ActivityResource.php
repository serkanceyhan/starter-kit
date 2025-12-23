<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ActivityResource\Pages;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Spatie\Activitylog\Models\Activity;

class ActivityResource extends Resource
{
    protected static ?string $model = Activity::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';

    protected static ?string $navigationLabel = 'Aktivite Logları';

    protected static ?string $modelLabel = 'Aktivite';

    protected static ?string $pluralModelLabel = 'Aktivite Logları';

    protected static ?int $navigationSort = 99;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('log_name')
                    ->label('Log Adı'),
                Forms\Components\TextInput::make('description')
                    ->label('Açıklama'),
                Forms\Components\TextInput::make('subject_type')
                    ->label('Konu Tipi'),
                Forms\Components\TextInput::make('subject_id')
                    ->label('Konu ID'),
                Forms\Components\TextInput::make('causer_type')
                    ->label('Yapan Tipi'),
                Forms\Components\TextInput::make('causer_id')
                    ->label('Yapan ID'),
                Forms\Components\KeyValue::make('properties')
                    ->label('Özellikler'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('log_name')
                    ->label('Log')
                    ->badge()
                    ->searchable(),
                Tables\Columns\TextColumn::make('description')
                    ->label('İşlem')
                    ->searchable(),
                Tables\Columns\TextColumn::make('subject_type')
                    ->label('Model')
                    ->formatStateUsing(fn ($state) => class_basename($state))
                    ->sortable(),
                Tables\Columns\TextColumn::make('subject_id')
                    ->label('ID')
                    ->sortable(),
                Tables\Columns\TextColumn::make('causer.name')
                    ->label('Yapan')
                    ->default('Sistem')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tarih')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('log_name')
                    ->label('Log Türü'),
                Tables\Filters\SelectFilter::make('subject_type')
                    ->label('Model Türü')
                    ->options([
                        'App\\Models\\Quote' => 'Quote',
                    ]),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
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
            'index' => Pages\ListActivities::route('/'),
            'view' => Pages\ViewActivity::route('/{record}'),
        ];
    }
}
