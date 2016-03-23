<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>DUOmacia</title>
    <link rel="stylesheet" href="/css/normalize.css" media="screen" title="no title" charset="utf-8">
    <link rel="stylesheet" href="/css/welcome.css" media="screen" title="no title" charset="utf-8">
  </head>
  <body>
    <div class="container">
        <div class="hero">
          <img class="Logo" src="/images/Duomacia2.svg" alt="Duomacia's official logo. Says the words DUOmacia with very fancy text!" />
          <img class="GarenImg" src="/images/GoodEnough.svg" alt="Garen, the might of demacia! Large man, with giant armor and a massive sword! DEMACIA!!!" />
        </div>
        <label for="search">Please input the account you wish to search:</label>
        <h1>Use "Valkrin" for testing</h1>
        <form class="search" action="/search" method="post">
          @yield('input')
          <button type="submit" name="submit">Forge onwards!</button>
        </form>
    </div>
    <footer>
      <p>DUOmacia is a free website meant to be used by players. No distribution or use of images, code, or other material is approved, except by respective owners.</p>
    </footer>
    <script type="text/javascript" src="/js/welcome.js">
    </script>
  </body>
</html>
