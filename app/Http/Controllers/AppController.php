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
    }
    
    public function store(Request $request)
     {
     $app = new App([
       'title' => $request->get('title'),
     ]);
     $app->save();
     
     $result = compact('app');
    return response()->json($result);
   }
      public function update($id, Request $request)
   {
       $app = App::find($id);
       $app->title = $request;
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
}
