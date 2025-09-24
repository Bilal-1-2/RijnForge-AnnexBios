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
    for ($y = 0; $y < 10; $y++) {

      for ($x = 0; $x < 11; $x++) {
        echo  '<div id="' . $x . '-' . $y . '" class="chair"><div class="seat"></div></div>';
      }
    }
    ?>
  </div>

  <script src="./assets/stoelen.js"></script>
</body>

</html>