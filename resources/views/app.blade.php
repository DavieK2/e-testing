<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <title>CBT Portal</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])  
    @inertiaHead

    <style>
      @font-face {
        font-family: 'Satoshi Black';
        src: url('/assets/fonts/Satoshi-Black.otf')
      }
      @font-face {
        font-family: 'Satoshi Regular';
        src: url('/assets/fonts/Satoshi-Variable.ttf')
      }

      body{
        font-family: 'Satoshi Regular'
      }
    </style>

  </head>
  <body>
    @inertia
  </body>
</html>