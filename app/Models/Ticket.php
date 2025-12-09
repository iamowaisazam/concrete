<?php

namespace App\Models;
use App\Models\User;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'user_name',
        'issue_topic',
        'issue_type',
        'details',
        'attachment',
        'status',
        'priority', 
        'closed_at', 
        'rating', 
        'feedback'
    ];


    public function replies()
{
    return $this->hasMany(TicketReply::class);
}

public function user()
{
    return $this->belongsTo(User::class);
}


}
