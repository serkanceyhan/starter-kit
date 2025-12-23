<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContentResource\Pages;
use App\Models\Content;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\Builder;
use Filament\Forms\Components\Builder\Block;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class ContentResource extends Resource
{
    protected static ?string $model = Content::class;
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationLabel = 'İçerikler';
    protected static ?string $navigationGroup = 'İçerik Yönetimi';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make('type')
                ->label('İçerik Tipi')
                ->options([
                    'blog' => 'Blog Yazısı',
                    'page' => 'Sayfa',
                    'contract' => 'Sözleşme',
                    'faq' => 'SSS',
                ])
                ->required()
                ->native(false),

            Forms\Components\TextInput::make('title')
                ->label('Başlık')
                ->required()
                ->live(onBlur: true)
                ->afterStateUpdated(fn ($state, callable $set) => 
                    $set('slug', Str::slug($state))
                ),

            Forms\Components\TextInput::make('slug')
                ->label('URL Slug')
                ->required()
                ->unique(ignoreRecord: true)
                ->live(onBlur: true)
                ->helperText(function (?string $state, ?string $operation, Forms\Get $get) {
                    if ($operation === 'edit' && $state) {
                        $type = $get('type') ?? 'page';
                        $prefix = match($type) {
                            'blog' => '/blog/',
                            'page' => '/sayfa/',
                            'faq' => '/sss/',
                            'contract' => '/sozlesme/',
                            default => '/sayfa/',
                        };
                        return '🔗 Canlı URL: ' . url($prefix . $state);
                    }
                    return 'URL yapısı otomatik oluşturulacak';
                }),

            Forms\Components\FileUpload::make('cover_image')
                ->label('Kapak Görseli')
                ->image()
                ->directory('content-covers'),

            // Tiptap Editor - Full featured with Grid
            \FilamentTiptapEditor\TiptapEditor::make('content')
                ->label('İçerik')
                ->profile('default')
                ->tools([
                    'heading',
                    'bold',
                    'italic',
                    'underline',
                    'strike',
                    'link',
                    'color',
                    'highlight',
                    'align-left',
                    'align-center',
                    'align-right',
                    'bullet-list',
                    'ordered-list',
                    'blockquote',
                    'code-block',
                    'table',
                    'grid',           // Grid layout
                    'grid-builder',   // Advanced grid builder
                    'details',        // Accordion/collapsible
                    'media',
                    'hr',
                    'undo',
                    'redo',
                ])
                ->disk('public')
                ->directory('content-images')
                ->maxContentWidth('5xl')
                ->columnSpanFull()
                ->required(),

            // Hidden field for blocks (legacy)
            Forms\Components\Hidden::make('blocks')
                ->default([]),

            // SEO Section
            Forms\Components\Section::make('SEO Ayarları')
                ->schema([
                    Forms\Components\TextInput::make('seo_title')
                        ->label('Meta Başlık')
                        ->maxLength(60)
                        ->helperText('Google\'da görünecek başlık (max 60 karakter)'),
                    Forms\Components\Textarea::make('seo_description')
                        ->label('Meta Açıklama')
                        ->rows(3)
                        ->maxLength(160)
                        ->helperText('Google\'da görünecek açıklama (max 160 karakter)'),
                ])
                ->collapsed(),

            Forms\Components\Toggle::make('is_active')
                ->label('Yayında')
                ->default(false),
            
            Forms\Components\DateTimePicker::make('published_at')
                ->label('Yayın Tarihi'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('type')
                    ->label('Tip')
                    ->badge()
                    ->colors([
                        'primary' => 'blog',
                        'success' => 'page',
                        'warning' => 'contract',
                    ])
                    ->searchable(),
                Tables\Columns\TextColumn::make('title')
                    ->label('Başlık')
                    ->searchable()
                    ->limit(50),
                Tables\Columns\TextColumn::make('slug')
                    ->label('Slug')
                    ->searchable()
                    ->toggleable(),
                Tables\Columns\ImageColumn::make('cover_image')
                    ->label('Kapak'),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Yayın')
                    ->boolean(),
                Tables\Columns\TextColumn::make('published_at')
                    ->label('Yayın Tarihi')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Oluşturulma')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('type')
                    ->label('Tip')
                    ->options([
                        'blog' => 'Blog',
                        'page' => 'Sayfa',
                        'contract' => 'Sözleşme',
                        'faq' => 'SSS',
                    ]),
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Yayında'),
            ])
            ->actions([
                Tables\Actions\Action::make('view_on_site')
                    ->label('Görüntüle')
                    ->icon('heroicon-o-eye')
                    ->url(fn (Content $record) => $record->getPublicUrl())
                    ->openUrlInNewTab()
                    ->visible(fn (Content $record): bool => 
                        $record->is_active && 
                        $record->published_at !== null && 
                        $record->published_at->isPast()
                    )
                    ->color('success'),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListContents::route('/'),
            'create' => Pages\CreateContent::route('/create'),
            'edit' => Pages\EditContent::route('/{record}/edit'),
        ];
    }
}
