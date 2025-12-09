<?php

namespace App\Events;

use App\Models\User;
use App\Models\UserNotificationAlert;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class NotificationEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets;

    public $user;
    public $notification;

    /**
     * @param  \App\Models\User  $user
     * @param  string $title
     * @param  string $message
     * @param  string|null $link
     * @param  string|null $image
     */
    public function __construct(User $user, $title, $message, $link = null, $image = null)
    {
        $this->user = $user;

 
        $this->notification = UserNotificationAlert::create([
            'user_id' => $user->id,
            'title'   => $title,
            'message' => $message,
            'link'    => $link,   
            'image'   => $image,  
            'is_read' => 0,
        ]);
    }

    public function broadcastOn()
    {
        return new PrivateChannel('notifications.' . $this->user->id);
    }

    public function broadcastAs()
    {
        return 'NotificationEvent';
    }

    public function broadcastWith()
    {
        return [
            'id'         => $this->notification->id,
            'title'      => $this->notification->title,
            'message'    => $this->notification->message,
            'link'       => $this->notification->link,   
            'image'      => $this->notification->image, 
            'is_read'    => $this->notification->is_read,
            'created_at' => $this->notification->created_at->toDateTimeString(),
        ];
    }
}
