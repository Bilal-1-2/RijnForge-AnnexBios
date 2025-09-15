<!DOCTYPE html>
<html lang="en">

  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/style.css">
    <title>Document</title>
  </head>

<body alt="">
  <?php
  include 'assets/includes/header.php';

  // Film data array
  $data = [
    [
      "film_id" => 1,
      "titel" => "The Conjuring: Last Rites",
      "releasedatum" => "2025-09-04",
      "duur" => 135,
      "poster" => "https://image.tmdb.org/t/p/w1280/3TriEvr5SmYFwhmVdfb8C9Fyobl.jpg",
      "trailers" => "https://www.youtube.com/channel/UCtS8hD5lhZTgHZAKeD89CFA?embeds_referring_euri=https%3A%2F%2Fwww.pa…",
      "informatie" => "Paranormale onderzoekers Ed en Lorraine Warren pakken een laatste angstaanjagende zaak aan, waarbij ze te maken krijgen met mysterieuze wezens."
    ],
    [
      "film_id" => 2,
      "titel" => "The Roses",
      "releasedatum" => "2025-08-28",
      "duur" => 110,
      "poster" => "https://filmhallen.nl/content/uploads/sites/4/2025/06/The-Roses_ps_1_jpg_sd-high_2025-Searchlight-Pictures-scaled-729x1080.jpg%22",
      "trailers" => "https://www.youtube.com/watch?v=XkgMaS5gbaA",
      "informatie" => "Onder de façade van een perfect stel ontstaat een kruitvat van concurrentie en wrok, wanneer de professionele dromen van de man in duigen vallen."
    ],
    [
      "film_id" => 3,
      "titel" => "Highest 2 Lowest",
      "releasedatum" => "2025-09-05",
      "duur" => 133,
      "poster" => "https://image.tmdb.org/t/p/w1280/kOzwIr0R7WhaFgoYUZFLPZA2RBZ.jpg",
      "trailers" => "https://www.youtube.com/watch?v=Sh8yqcozfn8",
      "informatie" => "Als er losgeld van een muziekmagnaat wordt geëist, staat hij voor een zwaar moreel dilemma. Kan hij zijn gezin en nalatenschap beschermen?"
    ],
    [
      "film_id" => 4,
      "titel" => "F1 - The Movie",
      "releasedatum" => "2025-06-26",
      "duur" => 156,
      "poster" => "https://image.tmdb.org/t/p/w1280/4khsAOhh6si1Qbx8lWqYQTk6gA5.jpg",
      "trailers" => "https://www.youtube.com/watch?v=ge_ABjtYx88",
      "informatie" => "Race legende Sonny Hayes wordt uit zijn pensioen gehaald om een worstelend Formule 1-team te leiden, en een jonge hotshot-coureur te begeleiden, terwijl hij nog een kans op glorie najaagt."
    ],
    [
      "film_id" => 5,
      "titel" => "Demon Slayer: Kimetsu no Yaiba Infinity Castle ",
      "releasedatum" => "2025-09-11",
      "duur" => 155,
      "poster" => "https://image.tmdb.org/t/p/w1280/aFRDH3P7TX61FVGpaLhKr6QiOC1.jpg",
      "trailers" => "https://www.youtube.com/watch?v=pD4ysb6BTqE",
      "informatie" => "Eerste film in Demon Slayer: Kimetsu no Yaiba's Infinity Castle-verhaallijn."
    ],
    [
      "film_id" => 6,
      "titel" => "Nobody 2 ",
      "releasedatum" => "2025-08-14",
      "duur" => 89,
      "poster" => "https://image.tmdb.org/t/p/w1280/wW49x8HBIFW2C9DQM4rbLKBFQ0A.jpg",
      "trailers" => "https://www.youtube.com/watch?v=UGOvEad8qd4",
      "informatie" => "Hutch Mansell, een voormalige huurmoordenaar uit de buitenwijken, wordt teruggetrokken in zijn gewelddadige verleden nadat hij een huisoverval heeft verijdeld. Dit zet een reeks gebeurtenissen in gang die geheimen over het verleden van zijn vrouw Becca en dat van hemzelf aan het licht brengen."
    ],
    [
      "film_id" => 7,
      "titel" => "Superman",
      "releasedatum" => "2025-07-10",
      "duur" => 130,
      "poster" => "https://image.tmdb.org/t/p/w1280/f5CRM9z0LUoQa8BiVuZZccU8oRu.jpg",
      "trailers" => "https://www.youtube.com/watch?v=nZTgJy8ym34",
      "informatie" => "Superman, een jonge verslaggever in Metropolis, begint aan een reis om zijn Kryptonische afkomst te verzoenen met zijn menselijke opvoeding als Clark Kent."
    ],
    [
      "film_id" => 8,
      "titel" => "The Naked Gun",
      "releasedatum" => "2025-07-31",
      "duur" => 85,
      "poster" => "https://image.tmdb.org/t/p/w1280/l6KbCTdI5rOaEgziVhA6eyggEsD.jpg",
      "trailers" => "https://image.tmdb.org/t/p/w1280/l6KbCTdI5rOaEgziVhA6eyggEsD.jpg",
      "informatie" => "Slechts één man beschikt over de specifieke vaardigheden… om Police Squad aan te voeren en de wereld te redden! Inspecteur Frank Drebin Jr. treedt in de voetsporen van zijn vader."
    ],
    [
      "film_id" => 9,
      "titel" => "Weapons",
      "releasedatum" => "2025-08-07",
      "duur" => 129,
      "poster" => "https://image.tmdb.org/t/p/w1280/cpf7vsRZ0MYRQcnLWteD5jK9ymT.jpg",
      "trailers" => "https://www.youtube.com/watch?v=0nHzpGSdL7c",
      "informatie" => "Wanneer alle kinderen, op één na, uit dezelfde klas op mysterieuze wijze op exact hetzelfde tijdstip en dezelfde nacht verdwijnen, vraagt de gemeenschap zich af wie of wat er achter hun verdwijning zit."
    ],
    [
      "film_id" => 10,
      "titel" => "Jurassic World Rebirth",
      "releasedatum" => "2025-07-03",
      "duur" => 134,
      "poster" => "https://image.tmdb.org/t/p/w1280/risWrEYBeXkLxgZNc4tVakF2HQr.jpg",
      "trailers" => "https://www.youtube.com/watch?v=2ZhB-YO5Tnk",
      "informatie" => "Vijf jaar na de gebeurtenissen in Jurassic World Dominion wordt geheime operatie expert Zora Bennett gecontracteerd om een bekwaam team te leiden op een uiterst geheime missie om genetisch materiaal van 's werelds drie grootste dinosaurussen veilig te stellen. Wanneer Zora's operatie kruist met een burgerfamilie wiens bootexpeditie kapseisde, stranden ze allemaal op een eiland waar ze oog in oog komen te staan met een sinistere, schokkende ontdekking die al tientallen jaren voor de wereld verborgen is gehouden."
    ]
  ];
  ?>

  <main>
    <div id="content-container">
      <div class="content-title">FILM AGENDA</div>
      <div class="filter">
        <div class="filter-options">kfs</div>
        <div class="filter-options">
          <div></div><strong>FILMS</strong>
        </div>
        <div class="filter-options">
          <div></div> <strong> DEZE WEEK</strong>
        </div>
        <div class="filter-options">
          <div></div><strong>VANDAAG</strong>
        </div>
        <div class="filter-options">
          <div></div><strong >CATEGORIE  </strong>
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
                <p>Release: <?php echo htmlspecialchars($film['releasedatum']); ?></p>
              </div>
            <div class="film-details">
                <div class="film-text" id="film-text-<?php echo $i; ?>">
                  <p><?php echo htmlspecialchars($film['informatie']); ?></p>
                </div>
              </div>
            </div>
           
            <button class="film-info-btn">MEER INFO & TICKETS</button>
          </div>
        <?php endfor; ?>
      </div>
    </div>






  </main>

</body>

</html>