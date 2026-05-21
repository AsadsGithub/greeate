<?php

namespace Greeate\Greeate\Models;

use Greeate\Greeate\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContactMessage extends Model
{
    use LogsActivity, SoftDeletes;

    protected $table = 'greeate_contact_messages';

    protected $fillable = [
        'name', 'email', 'phone', 'subject', 'message', 'status', 'ip_address', 'user_agent',
    ];
}
