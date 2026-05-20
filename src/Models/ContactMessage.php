<?php

namespace Greeate\Greeate\Models;

use Greeate\Greeate\Traits\LogsActivityTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContactMessage extends Model
{
    use LogsActivityTrait, SoftDeletes;

    protected $table = 'greeate_contact_messages';

    protected $fillable = [
        'name', 'email', 'phone', 'subject', 'message', 'status', 'ip_address', 'user_agent',
    ];
}
