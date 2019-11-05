<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\TaskCollection;
use App\App;

class AppController extends Controller
{
    public function index(){
        $apps = App::get();
        $result = compact('apps');
        return response()->json($result);
        
        //  $apps = App::with('app_info')
        // ->with('app_infra')
        // ->get();
        
    }
    
    public function store(Request $request)
     {
         
     $app = new App();
     $app->name = $request->name;
     
      $app->service_id = $request->service_id;
      $app->app_type_cd = $request->app_type_cd;
      $app->app_state_cd = $request->app_state_cd;
      $app->enable_flg = $request->enable_flg;
     $app->save();
     
     $result = compact('app');
    return response()->json($result);
   }
      public function update($id, Request $request)
   {
       $app = App::find($id);
       $app->name = $request;
       $app->save();
       
       $result = compact('app');
    return response()->json($result);    
       
   }

   public function delete($id)
   {
     $app = App::find($id);
     $app->delete();
     return response()->json('successfully deleted');
   }
   
   public function search($app_name)
    {   
        if (!empty($app_name)) {
            $apps = App::where('name', 'LIKE', "%$app_name%")
                    ->limit(20)
                    ->get();
                    
        $result = compact('apps');
        return response()->json($result);
        }
    }
}
