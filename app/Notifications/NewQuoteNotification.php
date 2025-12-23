<?php

namespace App\Notifications;

use App\Models\Quote;
use App\Filament\Resources\QuoteResource;
use Filament\Notifications\Notification as FilamentNotification;
use Filament\Notifications\Actions\Action;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewQuoteNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        public Quote $quote
    ) {}

    /**
     * Get the notification's delivery channels.
     */
    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    /**
     * Get the database/Filament representation of the notification.
     */
    public function toDatabase(object $notifiable): array
    {
        return FilamentNotification::make()
            ->title('Yeni Teklif Talebi')
            ->body("{$this->quote->company_name} - {$this->quote->service_type}")
            ->icon('heroicon-o-envelope')
            ->actions([
                Action::make('view')
                    ->label('Görüntüle')
                    ->url(QuoteResource::getUrl('view', ['record' => $this->quote]))
            ])
            ->getDatabaseMessage();
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Yeni Teklif Talebi - ' . $this->quote->company_name)
            ->greeting('Merhaba ' . $notifiable->name)
            ->line('Yeni bir teklif talebi geldi.')
            ->line('**Şirket:** ' . $this->quote->company_name)
            ->line('**İsim:** ' . $this->quote->name)
            ->line('**Hizmet:** ' . $this->quote->service_type)
            ->action('Teklifi Görüntüle', url('/admin/quotes/' . $this->quote->id))
            ->line('Tamirat Platform');
    }
}
