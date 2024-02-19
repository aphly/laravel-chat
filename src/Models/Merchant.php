<?php

namespace Aphly\LaravelChat\Models;

use Aphly\Laravel\Libs\Helper;
use Aphly\Laravel\Models\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Cache;

class Merchant extends Model
{
    use HasFactory;
    protected $table = 'chat_merchant';
    public $timestamps = false;

    protected $fillable = [
        'uuid','name','status'
    ];




}
