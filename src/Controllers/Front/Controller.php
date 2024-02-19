<?php

namespace Aphly\LaravelChat\Controllers\Front;

use Illuminate\Support\Facades\View;

class Controller extends \Aphly\LaravelCommon\Controllers\Front\Controller
{
    public $shop_setting = [];

    public function __construct()
    {
        $this->middleware(function ($request, $next){
            View::share("shop_setting",$this->shop_setting);
            return $next($request);
        });
        parent::__construct();
    }


}
