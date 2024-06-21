<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Email extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $fillable = [
        'sender_email',
        'subject',
        'body',
        'is_spam',
        'user_id',
        'receiver_email',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
