<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./assets/css/stoelen.css">
  <title>Document</title>
</head>

<body>
  <hr>
  <h3 class="filmdoek-heading">Filmdoek</h3>

  <div class="parent">
    <?php
    for ($y = 0; $y < 11; $y++) {

      for ($x = 0; $x < 10; $x++) {
        echo  '<div id="' .   ($x + 1) . '-' . ($y + 1) . '" class="chair"><div class="seat"></div></div>';
      }
    }
    ?>
  </div>

  <input type="text" id="selectedSeats" readonly name="selectedSeats">
  <div class="legenda">
    <div class="legenda-item">
      beschikbaar
    </div>
    <div class="legenda-item reserved">
      bezet
    </div>
    <div class="legenda-item selected">
      selectie
    </div>
  </div>

  <script src="./assets/js/stoelen.js"></script>
</body>

</html>