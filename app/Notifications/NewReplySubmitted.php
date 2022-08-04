<?php

namespace App\Notifications;

use App\Models\Thread;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NewReplySubmitted extends Notification
{
    use Queueable;

    private \Illuminate\Database\Eloquent\Builder $thread;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->thread = Thread::query();
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
            'url' => route('threads.show', $this->thread->id),
            'time' => now()->format('y-m-d H:i:s'),
        ];
    }
}
