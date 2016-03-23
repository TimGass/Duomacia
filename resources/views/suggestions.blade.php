<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $displayname }} on DUOmacia!</title>
    <link rel="stylesheet" href="/css/normalize.css" media="screen" title="no title" charset="utf-8">
    <link rel="stylesheet" href="/css/suggestions.css" media="screen" title="no title" charset="utf-8">
  </head>
  <body>
    <div class="headingBox">
      <a href="../../../">Home</a>
      <a href="./">Back</a>
      <h1>Hello, {{ $displayname }}!</h1>
      <h2>Here are your results:</h2>
    </div>
    <div class="leftBox">
      <h3>Suggested Players!</h3>
      @if(count($preffered) >= 5)
        @foreach($preffered as $player)
          <div class="innerWrapper">
            <h4> {{ $player["name"] }} </h4>
            <h5>
              percentage: {{ $player["percentage"] }}%
            </h5>
            <h5>
              Games: {{ $player["total"] }}
            </h5>
          </div>
        @endforeach
      @else
        @foreach($lesspreffered as $player)
          <div class="innerWrapper">
            <h4> {{ $player["name"] }} </h4>
            <h5>
              percentage: {{ $player["percentage"] }}%
            </h5>
            <h5>
              Games: {{ $player["total"] }}
            </h5>
          </div>
        @endforeach
      @endif
    </div>
    <img class="Logo" src="/images/Duomacia2.svg" alt="Duomacia's official logo. Says the words DUOmacia with very fancy text!" />
    <div class="rightBox">
      <h3>All players!</h3>
      @foreach($totalmapped as $player)
        <div class="innerWrapper">
          <h4> {{ $player["name"] }} </h4>
          <h5>
            percentage: {{ $player["percentage"] }}%
          </h5>
          <h5>
            Games: {{ $player["total"] }}
          </h5>
        </div>
      @endforeach
    </div>
    <script type="text/javascript" src="/js/summoner.js">
    </script>
  </body>
</html>
