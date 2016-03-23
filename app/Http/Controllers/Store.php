<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Session;

use Redirect;

class store extends Controller
{
  public function search(Request $values){
    $name = $values->search;
    if(empty($name)){
      $status = "empty";
      return redirect()->action("PagesController@welcomeerr", $status);
    }
    return redirect()->action("PagesController@summoner", $name);
  }

  public function suggestions(){
    return view("loading");
  }
}
