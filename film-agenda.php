<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="assets/css/style.css">

  <script src="assets/js/scrollbare-header.js" defer></script>
  <script src="assets/js/dropdown.js" defer></script>
  <title>AnnexBios Leidscherijn</title>
</head>

<body alt="">
  <?php
  include 'assets/includes/api-database.php';
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
          <div class="film-card">
            <form action="detail-pagina.php" method="post" class="film-poster-form">
              <input type="hidden" name="id" value="<?php echo $film['film_id']; ?>">
              <button type="submit" style="border: none; background: none; padding: 0;">
                <img style="height: 100%;" src="<?php echo htmlspecialchars($film['poster']); ?>"
                  alt="<?php echo htmlspecialchars($film['titel']); ?>">
              </button>
            </form>

            <div class="film-info">
              <div class="film-title"><?php echo htmlspecialchars($film['titel']); ?></div>
              <div class="ratings">
                <img src="assets/icons/ster.svg" alt="">
                <img src="assets/icons/ster.svg" alt="">
                <img src="assets/icons/ster.svg" alt="">
                <img src="assets/icons/ster.svg" alt="">
                <img src="assets/icons/ster.svg" alt="">
              </div>
              <div class="film-release-date">
                Release: <?php echo htmlspecialchars($film['releasedatum']); ?>
              </div>
              <div class="film-details">
                <div class="film-text" id="film-text-<?php echo $i; ?>">
                  <?php echo htmlspecialchars($film['informatie']); ?>
                </div>
              </div>

             <form action="detail-pagina.php" method="post">
               <input type="hidden" name="id" value="<?php echo $film['film_id']; ?>">
               <button type="submit" class="film-info-btn">MEER INFO & TICKETS</button>
             </form>
            </div>
          </div>

        <?php endfor; ?>
      </div>

    </div>







  </main>

  <?php
  include 'assets/includes/footer.php';
  ?>
</body>

</html>