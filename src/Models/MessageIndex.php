<?php

namespace Aphly\LaravelChat\Models;
use Aphly\Laravel\Libs\Helper;
use Aphly\Laravel\Models\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Cache;

class MessageIndex extends Model
{
    use HasFactory;
    protected $table = 'chat_message_index';
    public $timestamps = false;

    protected $fillable = [
        'uuid','last_author','last_message','status'
    ];




}
