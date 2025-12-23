<?php

namespace App\Filament\Resources\ContentResource\Pages;

use App\Filament\Resources\ContentResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditContent extends EditRecord
{
    protected static string $resource = ContentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('view_on_site')
                ->label('Sitede Görüntüle')
                ->icon('heroicon-o-arrow-top-right-on-square')
                ->url(fn () => $this->record->getPublicUrl())
                ->openUrlInNewTab()
                ->visible(fn (): bool => 
                    $this->record->is_active && 
                    $this->record->published_at !== null &&
                    $this->record->published_at->isPast()
                )
                ->color('success'),
            Actions\DeleteAction::make(),
        ];
    }
}
