<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="assets/css/style.css">

  <script src="assets/js/scrollbare-header.js" defer></script>
  <title>AnnexBios 5</title>
</head>

<body alt="">
  <?php
  include 'assets/includes/tijdelijk-database.php';
  include 'assets/includes/header.php';

  // Film data array

  ?>

  <main>
    <div id="content-container">
      <div class="content-title">FILM AGENDA</div>
      <div class="filter">
        <div class=".film-agenda-menu"><img src="assets/icons/menu-svgrepo-com.svg" alt=""></div>
        <div class="filter-options">
          <input type="radio" id="films" name="style" value="films">
          <label for="films"><strong>FILMS </strong></label>
        </div>
        <div class="filter-options">
          <input type="radio" id="deze-week" name="style" value="deze-week">
          <label for="deze-week"><strong>DEZE WEEK </strong></label>
        </div>
        <div class="filter-options">
          <input type="radio" id="vandaag" name="style" value="vandaag">
          <label for="vandaag"><strong> VANDAAG </strong></label>
        </div>

        <select class="categorie-select" name="categorie" onfocus='this.size=5;' onblur='this.size=1;' onchange='this.size=1; this.blur();'>

          <option value=""><strong>CATEGORIE </strong></option>
          <option value="action">ACTION</option>
          <option value="comedy">COMEDY</option>
          <option value="drama">DRAMA</option>
          <option value="horror">HORROR</option>
          <option value="sci-fi">SCI-FI</option>
          <option value="thriller">THRILLER</option>
          <option value="animation">ANIMATION</option>
        </select>

      </div>
      <div class="films-container">
        <?php
        $total = 18;
        $count = count($data);
     for ($i = 0; $i < $total; $i++):
          $film = $data[$i % $count];
        ?>
    <a href="detail-pagina.php?id=<?php echo $film['film_id']; ?>" class="film-card-link">
            <div class="film-card">
              <img  class="film-poster" src="<?php echo htmlspecialchars($film['poster']); ?>"
               alt="<?php echo htmlspecialchars($film['titel']); ?>">
              <div class="film-info">
                <div class="film-title"><?php echo htmlspecialchars($film['titel']); ?></div>
                <div class="film-release-date">
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
          </a>
        <?php endfor; ?>
      </div>

    </div>







  </main>

  <?php
  include 'assets/includes/footer.php';
  ?>
</body>

</html>