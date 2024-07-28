<?php

namespace App\Models;

use App\Models\Group;
use App\Models\MessageAttachment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'message',
        'sender_id',
        'group_id',
        'receiver_id',
    ];

    public function sender():BelongsTo{
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function receiver():BelongsTo{
        return $this->belongsTo(User::class, 'receiver_id');
    }


    public function group():BelongsTo{
        return $this->belongsTo(Group::class);
    }

    public function attachments(){
        return $this->hasMany(MessageAttachment::class);
    }
}
