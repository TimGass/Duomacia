<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $name }} on DUOmacia!</title>
    <link rel="stylesheet" href="/css/normalize.css" media="screen" title="no title" charset="utf-8">
    <link rel="stylesheet" href="/css/summoner.css" media="screen" title="no title" charset="utf-8">
  </head>
  <body>
    <div class="headingBox">
      <a href="../../">Home</a>
      <h1>Hello, {{ $name }}!</h1>
      <h2>Here are your results:</h2>
    </div>
    <div class="leftBox">
      <h3>Winning Players!</h3>
      @foreach($winresult as $player)
        <div class="innerWrapper">
          <h4> {{ $player["playerOrTeamName"] }} </h4>
          <h5>
            percentage: {{ round(($player["wins"]/($player["wins"] + $player["losses"])) * 100, 2, PHP_ROUND_HALF_EVEN) }}%
          </h5>
          <h5>
            Games: {{ $player["wins"] + $player["losses"] }}
          </h5>
        </div>
      @endforeach
    </div>
    <img class="Logo" src="/images/Duomacia2.svg" alt="Duomacia's official logo. Says the words DUOmacia with very fancy text!" />
    <div class="rightBox">
      <h3>Hot Streak Players!</h3>
      @foreach($resulting as $player)
        <div class="innerWrapper">
          <h4> {{ $player["playerOrTeamName"] }} </h4>
          <h5>
            percentage: {{ round(($player["wins"]/($player["wins"] + $player["losses"])) * 100, 2, PHP_ROUND_HALF_EVEN) }}%
          </h5>
          <h5>
            Games: {{ $player["wins"] + $player["losses"] }}
          </h5>
        </div>
      @endforeach
    </div>
    <form class="" action="/summoner/{{ $displayname }}/suggestions" method="post">
      <div class="suggestedBox">
        <h3>Find Suggested Players!</h3>
        <p>
          Suggested players lists the winrates you have had with all players you have played with.
          It is the most recommended feature of this site. However, due to Riot API's rate limiting
          it may take a few minutes to complete. I am currently working with Riot to get these rate
          limits removed for this site.
        </p>
      </div>
    </form>
    <script type="text/javascript" src="/js/summoner.js">
    </script>
  </body>
</html>
