<!DOCTYPE html>
<html>
    <head>
        <title>DUOmacia</title>
        <link rel="stylesheet" href="./css/normalize.css" media="screen" title="no title" charset="utf-8">
        <link rel="stylesheet" href="./css/welcome.css" media="screen" title="no title" charset="utf-8">
    </head>
    <body>
        <div class="container">
            <div class="hero">
              <img class="Logo" src="./images/Duomacia2.svg" alt="Duomacia's official logo. Says the words DUOmacia with very fancy text!" />
              <img class="GarenImg" src="./images/GoodEnough.svg" alt="Garen, the might of demacia! Large man, with giant armor and a massive sword! DEMACIA!!!" />
            </div>
            <label for="search">Please input the account you wish to search:</label>
            <form class="search" action="search" method="post">
              {{-- @if($status)
                <input class="failed" type="text" name="search" placeholder="Account not found in NA" />
              @else --}}
                <input type="text" name="search" placeholder="NA only" />
              {{-- @endif --}}
              <button type="submit" name="submit">Forge onwards!</button>
            </form>
        </div>
        <footer>
          <p>DUOmacia is a free website meant to be used by players. No distribution or use of images, code, or other material is approved, except by owner.</p>
        </footer>
    </body>
</html>
