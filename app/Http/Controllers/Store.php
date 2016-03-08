<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class store extends Controller
{
  public function search(Request $values){
    $name = strtolower($values->search);
    $curl = curl_init('https://na.api.pvp.net/api/lol/na/v1.4/summoner/by-name/' . $name . '?api_key=395b5161-cd52-49e4-9272-63689572df0d');
    curl_setopt( $curl, CURLOPT_RETURNTRANSFER, 1);
    $result = curl_exec($curl);
    $status = curl_getinfo($curl)["http_code"];
    if($status === 404){
      curl_close($curl);
      return redirect()->action("/", $status);
    }
    curl_close($curl);
    $phpresult = json_decode($result, true);
    $id = $phpresult[$name]["id"];
  }
}
