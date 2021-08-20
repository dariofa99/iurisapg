<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Mail\UserNotification as Mailable;
use App\User;
class UserNotification extends Notification
{
    use Queueable;

    private $notifify;
    private $link_to;
    private $mensaje;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(User $notifify)
    {
        $this->notifify = $notifify;        
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database','mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
      
        return (new Mailable($notifiable))
        ->subject('Notificación')
        ->to($notifiable->email);

    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toDatabase($notifiable)
    {
    
        return [
           'type_notification'=>$this->notifify->notification,
           'link_to'=>$this->notifify->link_to,
           'mensaje'=>$this->notifify->mensaje
        ];
    }
   

    
}
