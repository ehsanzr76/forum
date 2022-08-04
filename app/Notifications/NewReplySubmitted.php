<?php

namespace App\Notifications;

use App\Models\Thread;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NewReplySubmitted extends Notification
{
    use Queueable;

    /**
     * @var Thread
     */
    private Thread $thread;

    public function __construct(Thread $thread)
    {
        $this->thread = $thread;
    }

    /**
     * @param $notifiable
     * @return string[]
     */
    public function via($notifiable): array
    {
        return ['database'];
    }

    /**
     * @param $notifiable
     * @return array
     */
    public function toDatabase($notifiable): array
    {
        return [
            'thread_title' => $this->thread->title,
            'url' => route('threads.show', [$this->thread]),
            'time' => now()->format('y-m-d H:i:s'),
        ];
    }
}
