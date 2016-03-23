<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Session;

class PagesController extends Controller
{
  public function welcome(){
    if(isset($_COOKIE["displayname"])){
      $displayname = $_COOKIE["displayname"];
      return view("welcome", compact("displayname"));
    }
    return view("welcome");
  }

  public function welcomeerr($status){
    return view("welcomeerr", compact("status"));
  }

  public function summoner($name){
    $truename = strtolower(preg_replace("/[\s,.\/;'\[\]\\=`<>?:\"{}|_+~!@#$%^&*()-]/", "", $name));
    if(empty($truename)){
      $status = 404;
      return redirect()->action("PagesController@welcomeerr", $status);
    }
    $curl = curl_init('https://na.api.pvp.net/api/lol/na/v1.4/summoner/by-name/' . $truename . '?api_key=395b5161-cd52-49e4-9272-63689572df0d');
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 5);
    $result = curl_exec($curl);
    $status = curl_getinfo($curl)["http_code"];
    curl_close($curl);
    if($status !== 200){
      return redirect()->action("PagesController@welcomeerr", $status);
    }
    $phpresult = json_decode($result, true);
    $displayname = $phpresult[$truename]["name"];
    $id = $phpresult[$truename]["id"];
    $curl = curl_init('https://na.api.pvp.net/api/lol/na/v2.5/league/by-summoner/' . $id . '?api_key=395b5161-cd52-49e4-9272-63689572df0d');
    curl_setopt( $curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 5);
    $resultid = curl_exec($curl);
    $status = curl_getinfo($curl)["http_code"];
    curl_close($curl);
    if($status === 404){
      $status = "unranked";
      return redirect()->action("PagesController@welcomeerr", $status);
    }
    elseif($status !== 200){
      return redirect()->action("PagesController@welcomeerr", $status);
    }
    $resultidphp = json_decode($resultid, true);
    $percentagesort = function($a, $b){
      if(round(($b["wins"]/($b["wins"] + $b["losses"])) * 100, 2, PHP_ROUND_HALF_EVEN) === round(($a["wins"]/($a["wins"] + $a["losses"])) * 100, 2, PHP_ROUND_HALF_EVEN)){
        return ($b["wins"] + $b["losses"]) - ($a["wins"] + $a["losses"]);
      }
      return round(($b["wins"]/($b["wins"] + $b["losses"])) * 10000, 0, PHP_ROUND_HALF_EVEN) - round(($a["wins"]/($a["wins"] + $a["losses"])) * 10000, 0, PHP_ROUND_HALF_EVEN);
    };
    usort($resultidphp[$id][0]["entries"], $percentagesort);
    $hotfilter = function($player){
      return $player["isHotStreak"];
    };
    $winfilter = function($player){
      $total = $player["wins"] + $player["losses"];
      $ratio = $player["wins"]/$total;
      return ($ratio > .55) && $total > 50;
    };
    $resulting = array_filter($resultidphp[$id][0]["entries"], $hotfilter);
    $winresult = array_filter($resultidphp[$id][0]["entries"], $winfilter);
    if(isset($_COOKIE["id"])){
      unset($_COOKIE["id"]);
      setcookie('id', '', time() - 3600, '/');
    }
    if(isset($_COOKIE["displayname"])){
      unset($_COOKIE["displayname"]);
      setcookie('displayname', '', time() - 3600, '/');
    }
    setcookie("id", $id, time() + 2592000, "/");
    setcookie("displayname", $displayname, time() + 2592000, "/");
    return view("summoner", compact("winresult", "resulting", "name", "displayname"));
  }

  public function suggestions($name){
    if(isset($_COOKIE["id"]) && isset($_COOKIE["displayname"]) && ($_COOKIE["displayname"] === $name)){
      $id = (int)$_COOKIE["id"];
      $displayname = $_COOKIE["displayname"];
    }
    else{
      $truename = strtolower(preg_replace("/[\s,.\/;'\[\]\\=`<>?:\"{}|_+~!@#$%^&*()-]/", "", $name));
      if(empty($truename)){
        $status = 404;
        return redirect()->action("PagesController@welcomeerr", $status);
      }
      $curl = curl_init('https://na.api.pvp.net/api/lol/na/v1.4/summoner/by-name/' . $truename . '?api_key=395b5161-cd52-49e4-9272-63689572df0d');
      curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 5);
      $result = curl_exec($curl);
      $status = curl_getinfo($curl)["http_code"];
      curl_close($curl);
      if($status !== 200){
        return redirect()->action("PagesController@welcomeerr", $status);
      }
      $phpresult = json_decode($result, true);
      $displayname = $phpresult[$truename]["name"];
      $id = $phpresult[$truename]["id"];
      $curl = curl_init('https://na.api.pvp.net/api/lol/na/v2.5/league/by-summoner/' . $id . '?api_key=395b5161-cd52-49e4-9272-63689572df0d');
      curl_setopt( $curl, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 5);
      $resultid = curl_exec($curl);
      $status = curl_getinfo($curl)["http_code"];
      curl_close($curl);
      if($status === 404){
        $status = "unranked";
        return redirect()->action("PagesController@welcomeerr", $status);
      }
      elseif($status !== 200){
        return redirect()->action("PagesController@welcomeerr", $status);
      }
      setcookie("id", $id, time() + 2592000, "/");
      setcookie("displayname", $displayname, time() + 2592000, "/");
    }
    $curl = curl_init('https://na.api.pvp.net/api/lol/na/v2.2/matchlist/by-summoner/' . $id . '?rankedQueues=TEAM_BUILDER_DRAFT_RANKED_5x5,RANKED_SOLO_5x5&seasons=SEASON2016&api_key=395b5161-cd52-49e4-9272-63689572df0d');
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 5);
    $matchlist = curl_exec($curl);
    curl_close($curl);
    $matchlistphp = json_decode($matchlist, true);
    if(!empty($matchlistphp)){
      $matchlistmap = function($match){
        return $match["matchId"];
      };
      $matchlistarray = array_map($matchlistmap, $matchlistphp["matches"]);
      $matcharray = [];
      foreach ($matchlistarray as $number => $match) {
        if($number % 10 === 0){
          sleep(10);
        }
        $curl = curl_init('https://na.api.pvp.net/api/lol/na/v2.2/match/' . $match . '?api_key=395b5161-cd52-49e4-9272-63689572df0d');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 5);
        $result = curl_exec($curl);
        curl_close($curl);
        $resultphp = json_decode($result, true);
        if(!array_key_exists("status", $resultphp)){
          array_push($matcharray, $resultphp);
        }
      }
      $winners = [];
      $losers = [];
      foreach ($matcharray as $match) {
        $winteam;
        $loseteamplayersId = [];
        $winteamplayersId = [];
        foreach ($match["teams"] as $team) {
          if($team["winner"]){
            $winteam = $team["teamId"];
          }
        }
        foreach ($match["participants"] as $player) {
          if($player["teamId"] === $winteam){
            array_push($winteamplayersId, $player["participantId"]);
          }
          else{
            array_push($loseteamplayersId, $player["participantId"]);
          }
        }
        foreach ($match["participantIdentities"] as $participant) {
          foreach ($winteamplayersId as $partid) {
            if($participant["participantId"] === $partid){
              if($participant["player"]["summonerId"] === $id){
                foreach ($match["participantIdentities"] as $partwin) {
                  foreach ($winteamplayersId as $partwinid) {
                    if($partwin["participantId"] === $partwinid){
                      array_push($winners, $partwin["player"]["summonerName"]);
                    }
                  }
                }
              }
            }
          }
          foreach ($loseteamplayersId as $partid) {
            if($participant["participantId"] === $partid){
              if($participant["player"]["summonerId"] === $id){
                foreach ($match["participantIdentities"] as $partlose) {
                  foreach ($loseteamplayersId as $partloseid) {
                    if($partlose["participantId"] === $partloseid){
                      array_push($losers, $partlose["player"]["summonerName"]);
                    }
                  }
                }
              }
            }
          }
        }
      }
    }
    else {
      $status = "No internet connection";
      $status = urlencode($status);
      return redirect()->action("PagesController@welcomeerr", $status);
    }
    $notmefilter = function($name) use ($displayname){
      return $displayname !== $name;
    };
    $winners = array_filter($winners, $notmefilter);
    $losers = array_filter($losers, $notmefilter);
    $wincount = array_count_values($winners);
    $losecount = array_count_values($losers);
    $wincountmap = function($player, $key) use ($losecount){
      foreach ($losecount as $name => $loss) {
        if($name === $key){
          return ["name"=> $key, "wins" => $player, "losses" => $loss];
        }
      }
      return ["name" => $key, "wins" => $player];
    };
    $losecountmap = function($player, $key){
      return ["name" => $key, "losses" => $player];
    };
    $winmapped = array_map($wincountmap, $wincount, array_keys($wincount));
    $losecountfiltered = array_diff_key($losecount, $wincount);
    $losemapped = array_map($losecountmap, $losecountfiltered, array_keys($losecountfiltered));
    $total = array_merge($winmapped, $losemapped);
    $totalmap = function($player){
      $totalnum = 0;
      $winnum = 0;
      if(array_key_exists("wins", $player)){
        $totalnum += $player["wins"];
        $winnum += $player["wins"];
      }
      if(array_key_exists("losses", $player)){
        $totalnum += $player["losses"];
      }
      $ratio = $winnum / $totalnum;
      return $player + ["total" => $totalnum] + ["ratio" => $ratio] + ["percentage" => round(($ratio * 100), 2, PHP_ROUND_HALF_EVEN)];
    };
    $totalmapped = array_map($totalmap, $total);
    $percentagesort = function($a, $b){
      if($b["percentage"] === $a["percentage"]){
        return $b["total"] - $a["total"];
      }
      return ($b["percentage"] * 100) - ($a["percentage"] * 100);
    };
    usort($totalmapped, $percentagesort);
    $totalfilter = function($player){
      return ($player["total"] > 2) && ($player["ratio"] > .55);
    };
    $lessprefferedfilter = function($player){
      return ($player["ratio"] >= .5);
    };
    $preffered = array_filter($totalmapped ,$totalfilter);
    $lesspreffered = array_filter($totalmapped ,$lessprefferedfilter);
    return view("suggestions", compact("preffered", "lesspreffered", "totalmapped", "displayname"));
  }
}
