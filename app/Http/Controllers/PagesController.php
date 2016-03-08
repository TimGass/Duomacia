<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class PagesController extends Controller
{
  public function welcome(){
    return view("welcome");
  }

  public function welcomeerr($status){
    return view("welcome", compact($status));
  }
}
