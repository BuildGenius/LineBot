<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CallabcLog extends Model
{
    use HasFactory;
    protected $table = 'call__alert_bot_center__logs';
    protected $primaryKey = 'id';

}
