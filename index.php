<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="assets/css/style.css">
  <title></title>
</head>

<body alt="">
  <?php
  include 'assets/includes/header.php';

  // Film data array
  include 'assets/includes/tijdelijk-database.php';
  ?>

  <main>
    <div id="content-container">
      <div class="content-title">FILM AGENDA</div>
      <div class="filter">
        <div class="filter-options"style="padding:0px;" ><img src="assets/icons/menu-svgrepo-com.svg" alt=""></div>
        <div class="filter-options">
          <div></div><strong >FILMS</strong>
        </div>
        <div class="filter-options">
          <div></div> <strong> DEZE WEEK</strong>
        </div>
        <div class="filter-options">
          <div></div><strong>VANDAAG</strong>
        </div>
        <div class="filter-options">
          <div></div><strong>  CATEGORIE   </strong><img src="assets/icons/arrow_dropdown-blue.svg" alt="dropdown" class="content-dropdown-icon">
        </div>
      </div>
      <div class="films-container">
        <?php
        $total = 12;
        $count = count($data);
        for ($i = 0; $i < $total; $i++):
          $film = $data[$i % $count];
        ?>
          <div class="film-card">
            <img class="film-poster" src="<?php echo htmlspecialchars($film['poster']); ?>" alt="<?php echo htmlspecialchars($film['titel']); ?>">
            <div class="film-info">
              <div class="film-title"><?php echo htmlspecialchars($film['titel']); ?></div>
              <div>
                Release: <?php echo htmlspecialchars($film['releasedatum']); ?>
              </div>
              <div class="film-details">
                <div class="film-text" id="film-text-<?php echo $i; ?>">
                 <?php echo htmlspecialchars($film['informatie']); ?>
                </div>
              </div>
              <button class="film-info-btn">MEER INFO & TICKETS</button>
            </div>
          </div>
        <?php endfor; ?>
      </div>
      <div class="content-film-agenda-btn" class="links"><a href="#">BEKIJK ALLE FILMS</a> </div>
    </div>







  </main>

</body>

</html>