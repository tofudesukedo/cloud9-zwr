<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\TaskCollection;
use App\App;
use App\Domain;
use App\Srv;
use App\AppInfra;

class AppController extends Controller {
    
    public function index(Request $request){
        
        $apps = App::with('app_info')
            ->with(['app_infra' => function($q){
                $q->with('domain')->with('srv');
            }])->paginate(10);
        
        $domains = Domain::get();
        $servers = Srv::get();
        
        $result = compact('apps','domains','servers');
        return response()->json($result);
        
    }
    
    public function store(Request $request){
         
        $app = new App();
        $app->name = $request->name;
        $app->service_id = $request->service_id;
        $app->app_type_cd = $request->app_type_cd;
        $app->app_state_cd = $request->app_state_cd;
        $app->enable_flg = $request->enable_flg;
        $app->save();
     
        $result  = compact('app');
        return response()->json($result);
    }
      public function update($id, Request $request){
        
        $app = App::find($id);
        $app->name = $request->name;
        $app->service_id = $request->service_id;
        $app->app_type_cd = $request->app_type_cd;
        $app->app_state_cd = $request->app_state_cd;
        $app->enable_flg = $request->enable_flg;
        $app->save();
       
        $result = compact('app');
        return response()->json($result);    
   }

   public function delete(Request $request){
        
        // return response()->json($request);
        
        if (!empty($request)) {
            $apps = App::whereIn('id', $request);
            $apps->delete();
        } elseif (!empty($id)) {
            $app = App::find($id);
            $app->delete();
        }
        return response()->json('successfully deleted');
   }
   
   public function search(Request $request){   
       
        if (!empty($request)) {
            $apps = App::where('name', 'LIKE', "%$request->name%")
                    ->limit(20)
                    ->get();
                    
            $result = compact('apps');
            return response()->json($result);
        }
    }
    
    public function edi1tInfra($id, Request $request){
        
        $infra = AppInfra::find($id);
        $infra->name = $request->name;
        $infra->srv_id = $request->srv_id;
        $infra->domain_id = $request->domain_id;
        $infra->enable_flg = $request->enable_flg;
        $infra->save();
        
        $infra =AppInfra::where('id', $id)
        ->with('domain')
        ->with('srv')
        ->first();
       
        $result = compact('infra');
        return response()->json($result);    
    }
    
}
