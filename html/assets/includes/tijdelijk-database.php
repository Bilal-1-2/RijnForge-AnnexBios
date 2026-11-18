<?php
/*
  Lokale filmdatabase (vervangt de externe API).

  Dit bestand bevat:
  - de films ($data)
  - hulpfuncties: getFilmById(), getVertoningen(), fetchTicketOrders(), getKijkwijzer()
  - prijzen en bioscoopgegevens

  Gebruik in een pagina:  require_once 'assets/includes/tijdelijk-database.php';
*/

date_default_timezone_set('Europe/Amsterdam');

if (defined('TIJDELIJK_DATABASE_GELADEN')) {
    return;
}
define('TIJDELIJK_DATABASE_GELADEN', true);

const BIOSCOOP_NAAM = 'AnnexBios Leidscherijn';
const FILM_PRIJZEN = ['normaal' => 9, 'kind' => 5, 'senior' => 7];

/* ---------------------------------------------------------------
   Hulpfuncties
--------------------------------------------------------------- */

// Bepaalt de Kijkwijzer op basis van de genres (Engels of Nederlands).
function getKijkwijzer($genreString)
{
    $kijkwijzer = ['age' => '12', 'warnings' => []];
    $genreList = array_map('trim', explode(',', $genreString));

    $horror    = ['Horror', 'Thriller', 'Mystery', 'Mysterie'];
    $actie     = ['Action', 'Actie', 'Adventure', 'Avontuur', 'Sci-Fi', 'Sciencefiction', 'Fantasy', 'Fantasie'];
    $animatie  = ['Animation', 'Animatie', 'Family', 'Familie'];
    $drama     = ['Drama', 'Comedy', 'Komedie', 'Romance', 'Romantiek', 'Musical'];

    if (array_intersect($horror, $genreList)) {
        $kijkwijzer = ['age' => '16', 'warnings' => ['geweld', 'angst']];
    } elseif (array_intersect($actie, $genreList)) {
        $kijkwijzer = ['age' => '12', 'warnings' => ['geweld', 'angst']];
    } elseif (array_intersect($animatie, $genreList)) {
        $kijkwijzer = ['age' => 'AL', 'warnings' => []];
    } elseif (array_intersect($drama, $genreList)) {
        $kijkwijzer = ['age' => '12', 'warnings' => ['grof-taal']];
    }

    $kijkwijzer['warnings'] = array_values(array_unique($kijkwijzer['warnings']));
    return $kijkwijzer;
}

// Maakt van een naam een bestandsnaam: "Jack O'Connell" -> "jack-o-connell".
function slugify($tekst)
{
    return trim(preg_replace('/[^a-z0-9]+/', '-', strtolower($tekst)), '-');
}

// Placeholder poster (SVG) voor films zonder poster-URL.
function posterPlaceholder($titel)
{
    $titel = trim($titel);
    if (mb_strlen($titel) > 26) {
        $titel = mb_substr($titel, 0, 25) . '…';
    }
    $titel = htmlspecialchars($titel, ENT_XML1);
    $svg = '<svg xmlns="http://www.w3.org/2000/svg" width="500" height="750" viewBox="0 0 500 750">'
        . '<rect width="500" height="750" fill="#0080ff"/>'
        . '<rect x="20" y="20" width="460" height="710" fill="none" stroke="#ffffff" stroke-width="4"/>'
        . '<text x="250" y="360" font-family="Lato, Arial, sans-serif" font-size="30" font-weight="700" fill="#ffffff" text-anchor="middle">' . $titel . '</text>'
        . '<text x="250" y="410" font-family="Lato, Arial, sans-serif" font-size="20" fill="#ffffff" text-anchor="middle">AnnexBios</text>'
        . '</svg>';
    return 'data:image/svg+xml;charset=utf-8,' . rawurlencode($svg);
}

// Placeholder voor acteursfoto's.
function actorPlaceholder()
{
    $svg = '<svg xmlns="http://www.w3.org/2000/svg" width="200" height="340" viewBox="0 0 200 340">'
        . '<rect width="200" height="340" fill="#d9d9d9"/>'
        . '<circle cx="100" cy="130" r="45" fill="#9a9a9a"/>'
        . '<rect x="35" y="200" width="130" height="140" rx="60" fill="#9a9a9a"/>'
        . '</svg>';
    return 'data:image/svg+xml;charset=utf-8,' . rawurlencode($svg);
}

/*
  Genereert vertoningen voor een film voor de komende 10 dagen.
  Altijd hetzelfde patroon per film_id (geen willekeur), en alleen tijden
  in de toekomst. Zo werken de filters "vandaag" en "deze week" altijd.
  Geeft dezelfde structuur terug als de oude API-functie fetchTicketOrders().
*/
function getVertoningen($filmId)
{
    $filmId = (int)$filmId;
    $slots = ['13:30', '16:15', '18:45', '21:15'];
    $orders = [];
    $nu = time();

    for ($dag = 0; $dag < 10; $dag++) {
        if ((($filmId + $dag) % 3) === 0) {
            continue; // niet elke dag een vertoning
        }
        $datum = date('Y-m-d', strtotime("+$dag day"));
        $aantal = 2 + (($filmId + $dag) % 2);
        $begin = ($filmId + $dag) % count($slots);

        for ($i = 0; $i < $aantal; $i++) {
            $tijd = $slots[($begin + $i) % count($slots)];
            $start = $datum . ' ' . $tijd . ':00';
            if (strtotime($start) <= $nu) {
                continue;
            }
            $orders[] = [
                'vertoning' => ['starttijd' => $start],
                'bioscoop'  => [
                    'name' => BIOSCOOP_NAAM,
                    'zaal' => 'Zaal ' . ((($filmId + $dag + $i) % 4) + 1),
                ],
                'prijzen'   => FILM_PRIJZEN,
            ];
        }
    }

    usort($orders, function ($a, $b) {
        return strcmp($a['vertoning']['starttijd'], $b['vertoning']['starttijd']);
    });
    return $orders;
}

// Zelfde naam als in de oude API-code, nu op basis van de lokale data.
function fetchTicketOrders($movieId)
{
    return getVertoningen($movieId);
}

/* ---------------------------------------------------------------
   Films
   Nieuwe film toevoegen: kopieer een blok, geef een nieuw film_id.
   Optioneel: "poster" (URL), "trailers" (YouTube-URL), "kijkwijzer", "stars".
   Zonder poster wordt automatisch een placeholder getoond.
--------------------------------------------------------------- */
$films = [
  [
    "film_id" => 1,
    "titel" => "The Conjuring: Last Rites",
    "releasedatum" => "2025-09-04",
    "duur" => 135,
    "genre" => "Horror, Thriller",
    "imdb_score" => 7.2,
    "regisseur" => "Michael Chaves",
    "land" => "USA",
    "acteurs" => [
      ["naam" => "Vera Farmiga", "foto" => "assets/acteurs/BryceDallas.jpg"],
      ["naam" => "Patrick Wilson", "foto" => "assets/acteurs/Chris_Pratt.jpg"],
      ["naam" => "Mia Tomlinson", "foto" => "assets/acteurs/rafe_spall.jpg"],
      ["naam" => "Ben Hardy", "foto" => "assets/acteurs/Toby_Jones.jpg"]
    ],
    "poster" => "https://image.tmdb.org/t/p/w1280/3TriEvr5SmYFwhmVdfb8C9Fyobl.jpg",
    "trailers" => "https://youtu.be/bMgfsdYoEEo",
    "informatie" => "The Conjuring: Last Rites van New Line Cinema is het negende deel in het Conjuring-universum, dat al goed is voor een bioscoopopbrengst van ruim 2 miljard dollar. De film wordt geregisseerd door veteraan Michael Chaves en geproduceerd door James Wan en Peter Safran, zonder wie de franchise er niet was geweest. Met The Conjuring: Last Rites, dat gebaseerd is op een waargebeurd verhaal, wordt er weer een bloedstollend hoofdstuk toegevoegd aan het iconische Conjuring-universum. Vera Farmiga en Patrick Wilson komen nog één keer samen als de befaamde paranormale onderzoekers Ed en Lorraine Warren voor een laatste zaak in een meeslepend en angstaanjagend nieuw deel van de over de hele wereld succesvolle franchise.
Naast Farmiga en Wilson zijn in de film ook Mia Tomlinson en Ben Hardy te zien als Ed en Lorraines dochter Judy Warren en haar vriendje Tony Spera. En verder ook Steve Coulter, die terugkeert als priester Gordon, Rebecca Calder, Elliot Cowan, Kíla Lord Cassidy, Beau Gadsdon, John Brotherton en Shannon Kook. Chaves regisseert de film naar een scenario van Ian Goldberg, Richard Naing en David Leslie Johnson-McGoldrick en een treatment van David Leslie Johnson-McGoldrick en James Wan, dat gebaseerd is op de door Chad Hayes en Carey W. Hayes gecreëerde personages. De uitvoerend producenten zijn Michael Clear, Judson Scott, Hans Ritter, David Leslie Johnson-McGoldrick, Natalia Safran, John Rickard en Michael Chaves. Achter de schermen wordt Chaves bijgestaan door zijn creatieve team dat onder anderen bestaat uit director of photography Eli Born, production designer John Frankish, editors Elliot Greenberg en Gregory Plotkin, visual effects supervisor Scott Edelstein, visual effects producer Eric Bruneau en kostuumontwerper Graham Churchyard. De casting is in handen van Rose Wicksteed en Sophie Kingston-Smith en de muziek is gecomponeerd door Benjamin Wallfisch, met Ian Broucek als music supervisor. New Line Cinema presenteert The Conjuring: Last Rites, een productie van The Safran Company en Atomic Monster. De film wordt wereldwijd gedistribueerd door Warner Bros. Pictures.",
    "kijkwijzer" => ["age" => "16", "warnings" => ["geweld", "angst"]]
  ],
  [
    "film_id" => 2,
    "titel" => "The Roses",
    "releasedatum" => "2025-08-28",
    "duur" => 110,
    "genre" => "Drama, Comedy",
    "imdb_score" => 6.8,
    "regisseur" => "Jay Roach",
    "land" => "USA",
    "acteurs" => [
      ["naam" => "Benedict Cumberbatch", "foto" => "assets/acteurs/BryceDallas.jpg"],
      ["naam" => "Olivia Colman", "foto" => "assets/acteurs/Chris_Pratt.jpg"],
      ["naam" => "Andy Samberg", "foto" => "assets/acteurs/rafe_spall.jpg"],
      ["naam" => "Kate McKinnon", "foto" => "assets/acteurs/Toby_Jones.jpg"]
    ],
    "poster" => "https://filmhallen.nl/content/uploads/sites/4/2025/06/The-Roses_ps_1_jpg_sd-high_2025-Searchlight-Pictures-scaled-729x1080.jpg",
    "trailers" => "https://www.youtube.com/watch?v=XkgMaS5gbaA",
    "informatie" => "Onder de façade van een perfect stel ontstaat een kruitvat van concurrentie en wrok, wanneer de professionele dromen van de man in duigen vallen.",
    "kijkwijzer" => ["age" => "12", "warnings" => ["grof-taal"]]
  ],
  [
    "film_id" => 3,
    "titel" => "Highest 2 Lowest",
    "releasedatum" => "2025-09-05",
    "duur" => 133,
    "genre" => "Drama, Thriller",
    "imdb_score" => 7.5,
    "regisseur" => "Spike Lee",
    "land" => "USA",
    "acteurs" => [
      ["naam" => "Denzel Washington", "foto" => "assets/acteurs/BryceDallas.jpg"],
      ["naam" => "Jeffrey Wright", "foto" => "assets/acteurs/Chris_Pratt.jpg"],
      ["naam" => "Ice Spice", "foto" => "assets/acteurs/rafe_spall.jpg"],
      ["naam" => 'A$AP Rocky', "foto" => "assets/acteurs/Toby_Jones.jpg"]
    ],
    "poster" => "https://image.tmdb.org/t/p/w1280/kOzwIr0R7WhaFgoYUZFLPZA2RBZ.jpg",
    "trailers" => "https://www.youtube.com/watch?v=Sh8yqcozfn8",
    "informatie" => "Als er losgeld van een muziekmagnaat wordt geëist, staat hij voor een zwaar moreel dilemma. Kan hij zijn gezin en nalatenschap beschermen?",
    "kijkwijzer" => ["age" => "16", "warnings" => ["geweld", "angst"]]
  ],
  [
    "film_id" => 4,
    "titel" => "F1 - The Movie",
    "releasedatum" => "2025-06-25",
    "duur" => 155,
    "genre" => "Action, Drama",
    "imdb_score" => 7.6,
    "regisseur" => "Joseph Kosinski",
    "land" => "USA",
    "acteurs" => [
      ["naam" => "Brad Pitt", "foto" => ""],
      ["naam" => "Damson Idris", "foto" => ""],
      ["naam" => "Kerry Condon", "foto" => ""],
      ["naam" => "Javier Bardem", "foto" => ""]
    ],
    "poster" => "",
    "trailers" => "",
    "informatie" => "Sonny Hayes was ooit het grootste talent van de Formule 1, tot een crash zijn carrière bijna beëindigde. Dertig jaar later wordt hij teruggehaald door een worstelend team om als mentor van een jonge talentvolle coureur het tij te keren."
  ],
  [
    "film_id" => 5,
    "titel" => "Demon Slayer: Kimetsu no Yaiba Infinity Castle",
    "releasedatum" => "2025-09-11",
    "duur" => 155,
    "genre" => "Animation, Action, Fantasy",
    "imdb_score" => 8.9,
    "regisseur" => "Haruo Sotozaki",
    "land" => "Japan",
    "acteurs" => [
      ["naam" => "Natsuki Hanae", "foto" => "assets/acteurs/BryceDallas.jpg"],
      ["naam" => "Akari Kitō", "foto" => "assets/acteurs/Chris_Pratt.jpg"],
      ["naam" => "Yoshitsugu Matsuoka", "foto" => "assets/acteurs/rafe_spall.jpg"],
      ["naam" => "Hiro Shimono", "foto" => "assets/acteurs/Toby_Jones.jpg"]
    ],
    "poster" => "https://image.tmdb.org/t/p/w1280/aFRDH3P7TX61FVGpaLhKr6QiOC1.jpg",
    "trailers" => "https://www.youtube.com/watch?v=pD4ysb6BTqE",
    "informatie" => "Eerste film in Demon Slayer: Kimetsu no Yaiba's Infinity Castle-verhaallijn."
  ],
  [
    "film_id" => 6,
    "titel" => "Nobody 2",
    "releasedatum" => "2025-08-14",
    "duur" => 89,
    "genre" => "Action, Thriller",
    "imdb_score" => 7.4,
    "regisseur" => "Timo Tjahjanto",
    "land" => "USA",
    "acteurs" => [
      ["naam" => "Bob Odenkirk", "foto" => "assets/acteurs/BryceDallas.jpg"],
      ["naam" => "Connie Nielsen", "foto" => "assets/acteurs/Chris_Pratt.jpg"],
      ["naam" => "Christopher Lloyd", "foto" => "assets/acteurs/rafe_spall.jpg"],
      ["naam" => "RZA", "foto" => "assets/acteurs/Toby_Jones.jpg"]
    ],
    "poster" => "https://image.tmdb.org/t/p/w1280/wW49x8HBIFW2C9DQM4rbLKBFQ0A.jpg",
    "trailers" => "https://www.youtube.com/watch?v=UGOvEad8qd4",
    "informatie" => "Hutch Mansell, een voormalige huurmoordenaar uit de buitenwijken, wordt teruggetrokken in zijn gewelddadige verleden nadat hij een huisoverval heeft verijdeld. Dit zet een reeks gebeurtenissen in gang die geheimen over het verleden van zijn vrouw Becca en dat van hemzelf aan het licht brengen."
  ],
  [
    "film_id" => 7,
    "titel" => "Superman",
    "releasedatum" => "2025-07-10",
    "duur" => 130,
    "genre" => "Action, Adventure, Fantasy",
    "imdb_score" => 8.3,
    "regisseur" => "James Gunn",
    "land" => "USA",
    "acteurs" => [
      ["naam" => "David Corenswet", "foto" => "assets/acteurs/BryceDallas.jpg"],
      ["naam" => "Rachel Brosnahan", "foto" => "assets/acteurs/Chris_Pratt.jpg"],
      ["naam" => "Nicholas Hoult", "foto" => "assets/acteurs/rafe_spall.jpg"],
      ["naam" => "Isabela Merced", "foto" => "assets/acteurs/Toby_Jones.jpg"]
    ],
    "poster" => "https://image.tmdb.org/t/p/w1280/f5CRM9z0LUoQa8BiVuZZccU8oRu.jpg",
    "trailers" => "https://www.youtube.com/watch?v=nZTgJy8ym34",
    "informatie" => "Superman, een jonge verslaggever in Metropolis, begint aan een reis om zijn Kryptonische afkomst te verzoenen met zijn menselijke opvoeding als Clark Kent."
  ],
  [
    "film_id" => 8,
    "titel" => "The Naked Gun",
    "releasedatum" => "2025-07-31",
    "duur" => 85,
    "genre" => "Comedy, Crime",
    "imdb_score" => 6.9,
    "regisseur" => "Akiva Schaffer",
    "land" => "USA",
    "acteurs" => [
      ["naam" => "Liam Neeson", "foto" => "assets/acteurs/BryceDallas.jpg"],
      ["naam" => "Pamela Anderson", "foto" => "assets/acteurs/Chris_Pratt.jpg"],
      ["naam" => "Paul Walter Hauser", "foto" => "assets/acteurs/rafe_spall.jpg"],
      ["naam" => "Kevin Durand", "foto" => "assets/acteurs/Toby_Jones.jpg"]
    ],
    "poster" => "https://image.tmdb.org/t/p/w1280/l6KbCTdI5rOaEgziVhA6eyggEsD.jpg",
    "trailers" => "",
    "informatie" => "Slechts één man beschikt over de specifieke vaardigheden… om Police Squad aan te voeren en de wereld te redden! Inspecteur Frank Drebin Jr. treedt in de voetsporen van zijn vader."
  ],
  [
    "film_id" => 9,
    "titel" => "Weapons",
    "releasedatum" => "2025-08-07",
    "duur" => 129,
    "genre" => "Horror, Mystery",
    "imdb_score" => 7.1,
    "regisseur" => "Zach Cregger",
    "land" => "USA",
    "acteurs" => [
      ["naam" => "Julia Garner", "foto" => "assets/acteurs/BryceDallas.jpg"],
      ["naam" => "Josh Brolin", "foto" => "assets/acteurs/Chris_Pratt.jpg"],
      ["naam" => "Alden Ehrenreich", "foto" => "assets/acteurs/rafe_spall.jpg"],
      ["naam" => "Amy Madigan", "foto" => "assets/acteurs/Toby_Jones.jpg"]
    ],
    "poster" => "https://image.tmdb.org/t/p/w1280/cpf7vsRZ0MYRQcnLWteD5jK9ymT.jpg",
    "trailers" => "https://www.youtube.com/watch?v=0nHzpGSdL7c",
    "informatie" => "Wanneer alle kinderen, op één na, uit dezelfde klas op mysterieuze wijze op exact hetzelfde tijdstip en dezelfde nacht verdwijnen, vraagt de gemeenschap zich af wie of wat er achter hun verdwijning zit."
  ],
  [
    "film_id" => 10,
    "titel" => "Jurassic World Rebirth",
    "releasedatum" => "2025-07-03",
    "duur" => 134,
    "genre" => "Action, Adventure, Sci-Fi",
    "imdb_score" => 7.8,
    "regisseur" => "Gareth Edwards",
    "land" => "USA",
    "acteurs" => [
      ["naam" => "Scarlett Johansson", "foto" => "assets/acteurs/BryceDallas.jpg"],
      ["naam" => "Mahershala Ali", "foto" => "assets/acteurs/Chris_Pratt.jpg"],
      ["naam" => "Jonathan Bailey", "foto" => "assets/acteurs/rafe_spall.jpg"],
      ["naam" => "Rupert Friend", "foto" => "assets/acteurs/Toby_Jones.jpg"]
    ],
    "poster" => "https://image.tmdb.org/t/p/w1280/risWrEYBeXkLxgZNc4tVakF2HQr.jpg",
    "trailers" => "https://www.youtube.com/watch?v=2ZhB-YO5Tnk",
    "informatie" => "Vijf jaar na de gebeurtenissen in Jurassic World Dominion wordt geheime operatie expert Zora Bennett gecontracteerd om een bekwaam team te leiden op een uiterst geheime missie om genetisch materiaal van 's werelds drie grootste dinosaurussen veilig te stellen. Wanneer Zora's operatie kruist met een burgerfamilie wiens bootexpeditie kapseisde, stranden ze allemaal op een eiland waar ze oog in oog komen te staan met een sinistere, schokkende ontdekking die al tientallen jaren voor de wereld verborgen is gehouden."
  ],

  /* ----- Nieuwe films ----- */
  [
    "film_id" => 11,
    "titel" => "Sinners",
    "releasedatum" => "2025-04-16",
    "duur" => 137,
    "genre" => "Horror, Thriller",
    "imdb_score" => 7.6,
    "regisseur" => "Ryan Coogler",
    "land" => "USA",
    "acteurs" => [
      ["naam" => "Michael B. Jordan", "foto" => ""],
      ["naam" => "Hailee Steinfeld", "foto" => ""],
      ["naam" => "Miles Caton", "foto" => ""],
      ["naam" => "Jack O'Connell", "foto" => ""]
    ],
    "poster" => "",
    "trailers" => "",
    "informatie" => "Twee broers keren in de jaren dertig terug naar hun geboortestreek in het zuiden van de Verenigde Staten om opnieuw te beginnen. Wat ze daar tegenkomen is een veel groter kwaad dan ze hadden verwacht."
  ],
  [
    "film_id" => 12,
    "titel" => "How to Train Your Dragon",
    "releasedatum" => "2025-06-11",
    "duur" => 125,
    "genre" => "Fantasy, Family, Adventure",
    "imdb_score" => 7.8,
    "regisseur" => "Dean DeBlois",
    "land" => "USA",
    "acteurs" => [
      ["naam" => "Mason Thames", "foto" => ""],
      ["naam" => "Nico Parker", "foto" => ""],
      ["naam" => "Gerard Butler", "foto" => ""],
      ["naam" => "Nick Frost", "foto" => ""]
    ],
    "poster" => "",
    "trailers" => "",
    "informatie" => "Op het eiland Berk leven Vikingen en draken al eeuwen in oorlog. De jonge Hikkie raakt bevriend met de draak Tandloos en ontdekt dat alles wat zijn volk over draken denkt te weten, niet klopt.",
    "kijkwijzer" => ["age" => "12", "warnings" => ["angst"]]
  ],
  [
    "film_id" => 13,
    "titel" => "Lilo & Stitch",
    "releasedatum" => "2025-05-21",
    "duur" => 108,
    "genre" => "Family, Comedy",
    "imdb_score" => 7.0,
    "regisseur" => "Dean Fleischer Camp",
    "land" => "USA",
    "acteurs" => [
      ["naam" => "Maia Kealoha", "foto" => ""],
      ["naam" => "Sydney Agudong", "foto" => ""],
      ["naam" => "Zach Galifianakis", "foto" => ""],
      ["naam" => "Chris Sanders", "foto" => ""]
    ],
    "poster" => "",
    "trailers" => "",
    "informatie" => "Een eenzaam Hawaïaans meisje adopteert wat zij denkt dat een vreemde hond is, maar eigenlijk een ontsnapt buitenaards experiment is. Samen ontdekken ze wat 'ohana' echt betekent."
  ],
  [
    "film_id" => 14,
    "titel" => "Mission: Impossible - The Final Reckoning",
    "releasedatum" => "2025-05-21",
    "duur" => 169,
    "genre" => "Action, Thriller",
    "imdb_score" => 7.3,
    "regisseur" => "Christopher McQuarrie",
    "land" => "USA",
    "acteurs" => [
      ["naam" => "Tom Cruise", "foto" => ""],
      ["naam" => "Hayley Atwell", "foto" => ""],
      ["naam" => "Ving Rhames", "foto" => ""],
      ["naam" => "Simon Pegg", "foto" => ""]
    ],
    "poster" => "",
    "trailers" => "",
    "informatie" => "Ethan Hunt en zijn team nemen het op tegen de Entiteit, een kunstmatige intelligentie die de wereld bedreigt. Hun missie voert hen naar de meest gevaarlijke plekken die ze ooit hebben bezocht.",
    "kijkwijzer" => ["age" => "12", "warnings" => ["geweld"]]
  ],
  [
    "film_id" => 15,
    "titel" => "The Fantastic Four: First Steps",
    "releasedatum" => "2025-07-23",
    "duur" => 115,
    "genre" => "Sci-Fi, Adventure, Action",
    "imdb_score" => 7.0,
    "regisseur" => "Matt Shakman",
    "land" => "USA",
    "acteurs" => [
      ["naam" => "Pedro Pascal", "foto" => ""],
      ["naam" => "Vanessa Kirby", "foto" => ""],
      ["naam" => "Joseph Quinn", "foto" => ""],
      ["naam" => "Ebon Moss-Bachrach", "foto" => ""]
    ],
    "poster" => "",
    "trailers" => "",
    "informatie" => "In een retrofuturistische wereld moet het eerste gezin van Marvel zijn rol als helden combineren met het gezinsleven, terwijl een kosmische bedreiging de aarde nadert."
  ],
  [
    "film_id" => 16,
    "titel" => "Final Destination Bloodlines",
    "releasedatum" => "2025-05-14",
    "duur" => 110,
    "genre" => "Horror",
    "imdb_score" => 7.0,
    "regisseur" => "Zach Lipovsky",
    "land" => "USA",
    "acteurs" => [
      ["naam" => "Kaitlyn Santa Juana", "foto" => ""],
      ["naam" => "Teo Briones", "foto" => ""],
      ["naam" => "Richard Harmon", "foto" => ""],
      ["naam" => "Anna Lore", "foto" => ""]
    ],
    "poster" => "",
    "trailers" => "",
    "informatie" => "Een studente wordt geplaagd door een terugkerende nachtmerrie. Ze ontdekt dat de dood al decennia een familie op de hoogte houdt en dat zij de enige is die het tij kan keren."
  ],
  [
    "film_id" => 17,
    "titel" => "The Bad Guys 2",
    "releasedatum" => "2025-08-01",
    "duur" => 104,
    "genre" => "Animation, Family, Comedy",
    "imdb_score" => 6.9,
    "regisseur" => "Pierre Perifel",
    "land" => "USA",
    "acteurs" => [
      ["naam" => "Sam Rockwell", "foto" => ""],
      ["naam" => "Marc Maron", "foto" => ""],
      ["naam" => "Awkwafina", "foto" => ""],
      ["naam" => "Craig Robinson", "foto" => ""]
    ],
    "poster" => "",
    "trailers" => "",
    "informatie" => "De voormalige criminelen proberen een eerlijk leven te leiden, maar worden verleid tot één laatste klus wanneer een nieuwe bende bijzonder vaardige dieven opduikt."
  ],
  [
    "film_id" => 18,
    "titel" => "Wicked: For Good",
    "releasedatum" => "2025-11-19",
    "duur" => 138,
    "genre" => "Fantasy, Musical, Drama",
    "imdb_score" => 7.0,
    "regisseur" => "Jon M. Chu",
    "land" => "USA",
    "acteurs" => [
      ["naam" => "Cynthia Erivo", "foto" => ""],
      ["naam" => "Ariana Grande", "foto" => ""],
      ["naam" => "Jonathan Bailey", "foto" => ""],
      ["naam" => "Michelle Yeoh", "foto" => ""]
    ],
    "poster" => "",
    "trailers" => "",
    "informatie" => "Elphaba leeft als verbannen 'Wicked Witch of the West', terwijl Glinda de geliefde figuur van Oz is geworden. Hun wegen kruisen opnieuw in het tweede deel van het Wicked-verhaal.",
    "kijkwijzer" => ["age" => "12", "warnings" => ["angst"]]
  ],
  [
    "film_id" => 19,
    "titel" => "Zootopia 2",
    "releasedatum" => "2025-11-26",
    "duur" => 108,
    "genre" => "Animation, Family, Comedy",
    "imdb_score" => 7.5,
    "regisseur" => "Jared Bush",
    "land" => "USA",
    "acteurs" => [
      ["naam" => "Ginnifer Goodwin", "foto" => ""],
      ["naam" => "Jason Bateman", "foto" => ""],
      ["naam" => "Ke Huy Quan", "foto" => ""],
      ["naam" => "Fortune Feimster", "foto" => ""]
    ],
    "poster" => "",
    "trailers" => "",
    "informatie" => "Agenten Judy Hopps en Nick Wilde worden gedwongen undercover te gaan om een nieuwe zaak op te lossen die de hele stad Zootopia op zijn kop zet."
  ],
  [
    "film_id" => 20,
    "titel" => "Avatar: Fire and Ash",
    "releasedatum" => "2025-12-17",
    "duur" => 198,
    "genre" => "Sci-Fi, Adventure, Action",
    "imdb_score" => 7.4,
    "regisseur" => "James Cameron",
    "land" => "USA",
    "acteurs" => [
      ["naam" => "Sam Worthington", "foto" => ""],
      ["naam" => "Zoe Saldaña", "foto" => ""],
      ["naam" => "Sigourney Weaver", "foto" => ""],
      ["naam" => "Stephen Lang", "foto" => ""]
    ],
    "poster" => "",
    "trailers" => "",
    "informatie" => "Jake Sully en Neytiri krijgen te maken met een nieuw en gewelddadig Na'vi-volk, de Asche, terwijl de strijd om Pandora verder escaleert."
  ]
];

/* ---------------------------------------------------------------
   Normaliseren: ontbrekende velden aanvullen
--------------------------------------------------------------- */
$data = [];
foreach ($films as $film) {
    $film['stars'] = $film['stars'] ?? round(($film['imdb_score'] ?? 0) / 2, 1);
    $film['kijkwijzer'] = $film['kijkwijzer'] ?? getKijkwijzer($film['genre']);
    // Poster: eerst lokaal bestand (assets/films/film-<id>.jpg), dan URL, dan placeholder.
    $lokalePoster = 'assets/films/film-' . $film['film_id'] . '.jpg';
    if (file_exists(__DIR__ . '/../films/film-' . $film['film_id'] . '.jpg')) {
        $film['poster'] = $lokalePoster;
    } elseif (empty($film['poster'])) {
        $film['poster'] = posterPlaceholder($film['titel']);
    }

    // Acteursfoto: eerst lokaal bestand (acteurs/<naam>.jpg), dan opgegeven pad, dan placeholder.
    foreach ($film['acteurs'] as $i => $acteur) {
        $slug = slugify($acteur['naam']);
        if (file_exists(__DIR__ . '/../../acteurs/' . $slug . '.jpg')) {
            $film['acteurs'][$i]['foto'] = 'acteurs/' . $slug . '.jpg';
        } elseif (empty($acteur['foto'])) {
            $film['acteurs'][$i]['foto'] = actorPlaceholder();
        }
    }

    $showtimes = [];
    foreach (getVertoningen($film['film_id']) as $order) {
        $dag = substr($order['vertoning']['starttijd'], 0, 10);
        if (!in_array($dag, $showtimes)) {
            $showtimes[] = $dag;
        }
    }
    $film['showtimes'] = $showtimes;

    $data[] = $film;
}
unset($films);

// Zoek een film op id (geeft null als die niet bestaat).
function getFilmById($id)
{
    global $data;
    foreach ($data as $film) {
        if ((int)$film['film_id'] === (int)$id) {
            return $film;
        }
    }
    return null;
}
