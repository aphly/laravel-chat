<?php

namespace Aphly\LaravelChat\Models;

use Aphly\Laravel\Models\Manager;
use Aphly\Laravel\Models\Menu;
use Aphly\Laravel\Models\Module as Module_base;
use Illuminate\Support\Facades\DB;

class Module extends Module_base
{
    public $dir = __DIR__;

    public function install($module_id){
        parent::install($module_id);

        $manager = Manager::where('username','admin')->firstOrError();

        $menu = Menu::create(['name' => '客服系统','route' =>'','pid'=>0,'uuid'=>$manager->uuid,'type'=>1,'module_id'=>$module_id,'sort'=>20]);
        if($menu){

            $menu22 = Menu::create(['name' => '商户管理','route' =>'','pid'=>$menu->id,'uuid'=>$manager->uuid,'type'=>1,'module_id'=>$module_id,'sort'=>0]);
            if($menu22){
                $data=[];
                $data[] =['name' => '商户列表','route' =>'common_admin/merchant/index','pid'=>$menu22->id,'uuid'=>$manager->uuid,'type'=>2,'module_id'=>$module_id,'sort'=>0];
                DB::table('admin_menu')->insert($data);
            }
        }

        $menuData = Menu::where(['module_id'=>$module_id])->get();
        $data=[];
        foreach ($menuData as $val){
            $data[] =['role_id' => 1,'menu_id'=>$val->id];
        }
        DB::table('admin_role_menu')->insert($data);

        return 'install_ok';
    }

    public function uninstall($module_id){
        parent::uninstall($module_id);
        return 'uninstall_ok';
    }


}
