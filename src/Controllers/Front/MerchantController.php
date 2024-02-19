<?php

namespace Aphly\LaravelChat\Controllers\Front;

use Aphly\Laravel\Exceptions\ApiException;
use Aphly\LaravelChat\Models\Merchant;
use Aphly\LaravelCommon\Models\User;
use Illuminate\Http\Request;

class MerchantController extends Controller
{
    public function index(Request $request)
    {
        $res['title'] = 'Merchant Add';
        $res['merchant'] = Merchant::where('uuid',User::uuid())->first();
        if($request->isMethod('post')) {
            if(!empty($res['merchant'])){
                $res['merchant']->name = $request->input('name','');
                $res['merchant']->save();
            }else{
                Merchant::create(['name'=>$request->input('name',''),'uuid'=>User::uuid()]);
            }
            throw new ApiException(['code'=>0,'msg'=>'success','data'=>['redirect'=>'/merchant/center']]);
        }else{
            return $this->makeView('laravel-chat-front::merchant.index',['res'=>$res]);
        }
    }

    public function center(Request $request)
    {
        $res['title'] = 'Merchant Center';
        $res['merchant'] = Merchant::where('uuid',User::uuid())->first();
        if(empty($res['merchant'])){
            throw new ApiException(['code'=>0,'msg'=>'success','data'=>['redirect'=>'/merchant/index']]);
        }

        return $this->makeView('laravel-chat-front::merchant.center',['res'=>$res]);
    }

}
