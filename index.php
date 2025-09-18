<!DOCTYPE html>
<html lang="en">

<head>


  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link rel="stylesheet" href="assets/css/style.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap" rel="stylesheet">
  <title>AnnexBios 5</title>
  <script src="assets/js/scrollbare-header.js" defer></script>
</head>

<body alt="">
  <?php
  include 'assets/includes/tijdelijk-database.php';
  include 'assets/includes/header-homepage.php';
  ?>

  <main>

    <div class="hero-section">
      <h1 class="hero-section__title">WELKOM BIJ ANNEXBIOS 5</h1>
      <p class="hero-section__intro">Lorem ipsum dolor, sit amet consectetur adipisicing elit. Iusto, obcaecati quod consectetur ipsam temporibus alias nemo exercitationem nulla aspernatur doloremque!</p>
      <a href="#" class="hero-section__link">Bekijk de draaiende films</a>
    </div>

    <div class="company-details">

      <div class="company-maps">
        <img src="./assets/maps/maps.png" alt="maps" height="400">
      </div>
      <div class="company-image">
        <img src="./assets/vestigingen/vestiging 7 leidscherijn/208_2160.jpg" alt="" height="400">
      </div>

      <div class="company-info">
        <div class="company-location">
          <svg class="company-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640"><!--!Font Awesome Free v7.0.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.-->
            <path fill="#fff" d="M128 252.6C128 148.4 214 64 320 64C426 64 512 148.4 512 252.6C512 371.9 391.8 514.9 341.6 569.4C329.8 582.2 310.1 582.2 298.3 569.4C248.1 514.9 127.9 371.9 127.9 252.6zM320 320C355.3 320 384 291.3 384 256C384 220.7 355.3 192 320 192C284.7 192 256 220.7 256 256C256 291.3 284.7 320 320 320z" />
          </svg>
          <div class="company-container">
            <span class="company-adres">Berlijnplein 101
            </span> <br>
            <span class="company-postalcode">3541 CM Utrecht</span>
          </div>
        </div>
        <div class="company-contact">
          <svg class="company-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640"><!--!Font Awesome Free v7.0.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.-->
            <path fill="#ffffff" d="M224.2 89C216.3 70.1 195.7 60.1 176.1 65.4L170.6 66.9C106 84.5 50.8 147.1 66.9 223.3C104 398.3 241.7 536 416.7 573.1C493 589.3 555.5 534 573.1 469.4L574.6 463.9C580 444.2 569.9 423.6 551.1 415.8L453.8 375.3C437.3 368.4 418.2 373.2 406.8 387.1L368.2 434.3C297.9 399.4 241.3 341 208.8 269.3L253 233.3C266.9 222 271.6 202.9 264.8 186.3L224.2 89z" />
          </svg>

          <span class="company-number">088 - 5152050</span>
        </div>
        <div class="company-accessibility">
          <h4 class="company-accessibility__title">Bereikbaarheid</h4>
          <p class="company-accessibility__paragraph">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Commodi molestiae accusantium eveniet. Incidunt aspernatur voluptatum iure natus consectetur fugiat, voluptates aperiam id beatae? Voluptates nulla provident, sequi vero exercitationem eius?</p>
        </div>
      </div>
    </div>

    <div id="content-container">
      <div class="content-title">FILM AGENDA</div>
      <div class="filter">
        <div class="film-agenda-menu"><img src="assets/icons/menu-svgrepo-com.svg" alt=""></div>
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
        $total = 12;
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
      <div class="content-film-agenda-btn links"><a href="film-agenda.php">BEKIJK ALLE FILMS</a> </div>
    </div>

  </main>

  <?php
  include 'assets/includes/footer.php';
  ?>
</body>

</html>