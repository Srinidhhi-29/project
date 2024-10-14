<?php

namespace App\Http\Controllers;
// use App\Models\tm;

// use Illuminate\Http\Request;

use App\Models\tm;
use Illuminate\Http\Request;
use App\Jobs\sendemail;

class APITasksController extends Controller
{
   public function create(Request $request){
      
       $data= new tm();
       $data->task_discription =  $request->get('task_discription');
       $data->task_owner = $request->get('task_owner');
       $data->owner_email = $request->get('owner_email');
       $data->task_eta = $request->get('task_eta');

       if($data->save()){
        return "yes";
       }else{
        return"no";
       }
    }
   

   public function index(){
    $data=tm::get();
    return $data;
   }


   public function getTaskByID($id){
      $data=tm::find($id);
      return $data;
   }


   public function update(Request $request,$id){
      $data= tm::find($id);
      $data->task_discription =  $request->get('task_discription');
      $data->task_owner = $request->get('task_owner');
      $data->owner_email = $request->get('owner_email');
      $data->task_eta = $request->get('task_eta');
      
      if($data->save()){
         dispatch(new sendemail($data));
       return "updated";
      }else{
       return"no";
      }
   }


   public function markAsDone($id){
      $data= tm::find($id);
      $data->status=1;
      if($data->save()){
         dispatch(new sendemail($data));
         dispatch(new sendemail($data));
         return "mark task as done";
        }else{
         return"no";
        }
   }


   public function delete($id){
    $data=tm::find($id);
    if($data->delete()){
      return "deleted";
     }else{
      return"no";
     }
   }

}
