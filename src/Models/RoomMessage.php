<?php

namespace Aphly\LaravelChat\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Aphly\Laravel\Models\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Scopes\SplitTableScope;

class RoomMessage extends Model
{
    use HasFactory;
    protected $table;
    static protected $table_pre = 'chat_room_message';
    public $timestamps = false;

    protected $fillable = [
        'room_id','uuid','to_uuid','content','is_read','delete_at'
    ];

    public static function booted()
    {
        static::addGlobalScope(new SplitTableScope);
    }

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = self::$table_pre .'_'. date('Y_m') . "_1";
        $hasTable = Cache::get('has_' . $this->table, 0);
        if(!$hasTable){
            if (!Schema::hasTable($this->table)) {
                DB::update('create table ' .  $this->table . ' like ' . self::$table_pre);
            }
            Cache::set('has_' . $this->table, 1);
        }
    }

    public static function getSubTablesByMonth($startTime, $endTime = null)
    {
        $now = time();
        $endTime = empty($endTime) ? $now : $endTime;
        if ($endTime instanceof \Illuminate\Support\Carbon) {
            $endTime = $endTime->timestamp;
        }
        $nowTime = strtotime(date("Y-m-1", $endTime)); // 当前1号的时间戳
        $indexTime = empty($startTime) ? $now : $startTime;
        if ($indexTime instanceof \Illuminate\Support\Carbon) {
            $indexTime = $indexTime->timestamp;
        }
        $indexTime = strtotime(date("Y-m-1", $indexTime)); // 开始时间的1号时间戳
        $queryList = [];
        while ($indexTime <= $nowTime) {
            $queryList[] = date('Y_m', $indexTime) . "_1";
            $indexTime = strtotime("+1 month", $indexTime);
        }
        return array_unique($queryList);
    }

    public static function makeUnionQuery($startTime,$endTime = null)
    {
        $queryList = static::getSubTablesByMonth($startTime,$endTime); // 要查询的表,该方法在下面
        $unionTable = collect();
        foreach ($queryList as $suffix) {
            $tempTable = self::$table_pre.'_' . $suffix;
            $hasTable = Cache::get('has_' . $tempTable, 0);
            if($hasTable){
                $unionTable->push($tempTable);
            }else{
                if (!Schema::hasTable($tempTable)) {
                    DB::update('create table ' .  $tempTable . ' like ' . self::$table_pre);
                }
                Cache::set('has_' . $tempTable, 1);
            }
        }
        $self = new self;
        $unionTableSql = implode('{SPLIT_TABLE_FLAG}', $unionTable->toArray());
        return $self->setTable(DB::raw("{SPLIT_TABLE}$unionTableSql{SPLIT_TABLE}"));
    }
    //VideoTimeInfoDetails::makeUnionQuery($LearnTime->created_at,$LearnTime->updated_at)
    //->where('video_time_info_id',$LearnTime['id'])->orderByDesc('start_play_time')->first();
}
