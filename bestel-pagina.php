<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/bestel-pagina.css">
    <link rel="stylesheet" href="assets/css/includes/stoelen.css">

    <script src="assets/js/scrollbare-header.js" defer></script>
    <script src="assets/js/dropdown.js" defer></script>
    <script src="assets/js/bestel-dropdown-filter.js" defer></script>
    <script src="assets/js/stoelen.js" defer></script>
    <title>ticket</title>
</head>

<body>
    <?php
    include 'assets/includes/api-database.php';
    include 'assets/includes/price.php';
    include 'assets/includes/stars-filter.php';

    // Define formatPrice if not already defined
    if (!function_exists('formatPrice')) {
        function formatPrice($price)
        {
            return number_format((float)$price, 2, ',', '');
        }
    }

    // Get the film ID from POST data
    if (!isset($_POST['id']) || empty($_POST['id'])) {
        // header('Location: index.php');
        // exit;
        $filmId = 1; // Default for testing
    } else {
        $filmId = (int)$_POST['id'];
    }

    // Fetch ticket orders for this movie first to get bioscoop and zaal
    $ticketOrders = fetchTicketOrders($filmId);

    // Set bioscoop and zaal from ticket orders if available
    $bioscoopFromTickets = isset($ticketOrders[0]['bioscoop']['name']) ? $ticketOrders[0]['bioscoop']['name'] : 'AnnexBios Leidscherijn';
    $zaalFromTickets = isset($ticketOrders[0]['bioscoop']['zaal']) ? $ticketOrders[0]['bioscoop']['zaal'] : '';

    // Try to fetch detailed movie data
    $filmDetails = fetchMovieDetails($filmId);

    include 'assets/includes/header.php';





    if ($filmDetails) {
        // Format detailed data
        $genres = [];
        if (isset($filmDetails['genres']) && is_array($filmDetails['genres'])) {
            foreach ($filmDetails['genres'] as $genre) {
                $genres[] = $genre['name'] ?? '';
            }
        }
        $genreString = implode(', ', array_filter($genres));

        $acteurs = [];
        if (isset($filmDetails['cast']) && is_array($filmDetails['cast'])) {
            foreach (array_slice($filmDetails['cast'], 0, 5) as $actor) {
                $acteurs[] = [
                    'naam' => $actor['name'] ?? '',
                    'foto' => $actor['profile_path'] ? 'https://image.tmdb.org/t/p/w200' . $actor['profile_path'] : ''
                ];
            }
        }

        $regisseur = $filmDetails['director']['name'] ?? '';
         $kijkwijzer = getKijkwijzer($genreString);

        $film = [
            "film_id" => $filmDetails['movie']['id'] ?? $filmDetails['id'] ?? 0,
            "titel" => $filmDetails['movie']['title'] ?? '',
            "releasedatum" => $filmDetails['movie']['release_date'] ?? '',
            "duur" => $filmDetails['movie']['runtime'] ?? $filmDetails['runtime'] ?? 0,
            "genre" => $genreString ?: 'Action, Thriller',
            "stars" => $filmDetails['movie']['stars'] ?? $filmDetails['stars'] ?? 0,
            "regisseur" => $regisseur ?: 'Timo Tjahjanto',
            "land" => $filmDetails['movie']['origin_country'] ?? $filmDetails['origin_country'] ?? 'US',
            "acteurs" => $acteurs,
            "poster" => $filmDetails['movie']['poster_path'] ? 'https://image.tmdb.org/t/p/w500' . $filmDetails['movie']['poster_path'] : '',
            "trailers" => '',
            "informatie" => $filmDetails['movie']['overview'] ?? $filmDetails['overview'] ?? '',
            "kijkwijzer" => $kijkwijzer,
            "bioscoop" => $bioscoopFromTickets,
            "zaal" => $zaalFromTickets,

        ];
    } else {
        // Fallback to list data
        $film = null;
        foreach ($data as $item) {
            if ($item['film_id'] === $filmId) {
                $film = $item;
                break;
            }
        }

        if (!$film) {
            echo "<p>Film not found.</p>";
            exit;
        }
        // Add bioscoop if not present in fallback data
        if (!isset($film['bioscoop'])) {
            $film['bioscoop'] = 'AnnexBios Leidscherijn';
        }
    }



    // Extract unique dates and times from ticket orders, and collect vertoningen details
    $dates = [];
    $timesByDate = [];
    $vertoningen = [];
    foreach ($ticketOrders as $order) {
        $date = date('d-m-Y', strtotime($order['vertoning']['starttijd']));
        $time = date('H:i', strtotime($order['vertoning']['starttijd']));
        if (!in_array($date, $dates)) {
            $dates[] = $date;
        }
        if (!isset($timesByDate[$date])) {
            $timesByDate[$date] = [];
        }
        if (!in_array($time, $timesByDate[$date])) {
            $timesByDate[$date][] = $time;
        }
        if (!isset($vertoningen[$date])) {
            $vertoningen[$date] = [];
        }
        $vertoningen[$date][$time] = [
            'zaal' => $order['bioscoop']['zaal'] ?? '',
            'bioscoop' => $order['bioscoop']['name'] ?? 'AnnexBios Leidscherijn'
        ];
    }

    // Get prices from the first ticket order (assuming same for all)
    $prijzen = isset($ticketOrders[0]['prijzen']) ? $ticketOrders[0]['prijzen'] : ['normaal' => 9, 'kind' => 5, 'senior' => 7];
    ?>
    <script>
        var timesByDate = <?php echo json_encode($timesByDate); ?>;
        var vertoningen = <?php echo json_encode($vertoningen); ?>;
    </script>
    <main>

        <input type="hidden" name="id" value="<?php echo $filmId; ?>">
        <div class="bestel-title-container">
            <div class="div-title">TICKETS BESTELLEN</div>
            <div class="film-info">
                <div class="film-title">
                    <?php echo htmlspecialchars($film['titel']); ?>
                </div>
                <div class="bestel-dropdown" data-type="datum">
                    <button type="button" class="bestel-dropdown-toggle">
                        DATUM
                    </button>


                    <input type="hidden" name="datum" class="bestel-dropdown-input">

                    <div class="bestel-dropdown-menu">
                        <?php foreach ($dates as $date): ?>
                            <div class="bestel-dropdown-item" data-value="<?php echo htmlspecialchars($date); ?>">
                                <?php echo htmlspecialchars($date); ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <div class="bestel-dropdown" data-type="tijdstip">
                    <button type="button" class="bestel-dropdown-toggle">
                        TIJDSTIP
                    </button>


                    <input type="hidden" name="tijdstip" class="bestel-dropdown-input">

                    <div class="bestel-dropdown-menu">
                        <!-- Times will be populated by JS -->
                    </div>
                </div>
            </div>
        </div>
        <div class="bestel-content-container">
            <form id="bestel-form" method="post" action="bedankt-pagina.php">
                <div class="ticket-container">
                    <h1>STAP 1: KIES JE TICKET</h1>

                    <div class="type-prijs-aantal">
                        <div class="type-title">
                            <h2>TYPE</h2>
                        </div>

                        <div class="prijs-aantal-title">
                            <h2>PRIJS</h2>
                            <h2>AANTAL</h2>
                        </div>
                    </div>


                    <div class="top-bottom-lines"></div>

                    <div class="normal-prijs-aantal-container">
                        <div class="type-section">
                            <h4>Normaal</h4>
                        </div>

                        <div class="ticket-selector-prijs">
                            <h5>€<?php echo formatPrice($prijzen['normaal']); ?></h5>

                            <select name="aantal-tickets-normaal" id="aantal-tickets-normaal">
                                <option value="0">0</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                                <option value="7">7</option>
                                <option value="8">8</option>
                                <option value="9">9</option>
                                <option value="10">10</option>
                            </select>
                        </div>
                    </div>

                    <div class="normal-prijs-aantal-container">
                        <div class="type-section">
                            <h4>Kind t/m 11 jaar</h4>
                        </div>

                        <div class="ticket-selector-prijs">
                            <h5>€<?php echo formatPrice($prijzen['kind']); ?></h5>

                            <select name="aantal-tickets-kind" id="aantal-tickets-kind">
                                <option value="0">0</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                                <option value="7">7</option>
                                <option value="8">8</option>
                                <option value="9">9</option>
                                <option value="10">10</option>
                            </select>
                        </div>
                    </div>

                    <div class="normal-prijs-aantal-container">
                        <div class="type-section">
                            <h4>65 +</h4>
                        </div>

                        <div class="ticket-selector-prijs">
                            <h5>€<?php echo formatPrice($prijzen['senior']); ?></h5>

                            <select name="aantal-tickets-senior" id="aantal-tickets-senior">
                                <option value="0">0</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                                <option value="7">7</option>
                                <option value="8">8</option>
                                <option value="9">9</option>
                                <option value="10">10</option>
                            </select>
                        </div>
                    </div>

                    <div class="top-bottom-lines"></div>

                    <div class="voucher-code-container">
                        <h3>VOUCHERCODE</h3>
                        <input type="text" placeholder="CODE" id="voucher-code-input" name="voucher_code">
                        <button>Toevoegen</button>
                    </div>
                </div>

                <div class="stoelen-container">
                    <h1>STAP 2: KIES JE STOELEN</h1>
                    <hr>
                    <h3 class="filmdoek-heading">Filmdoek</h3>
                    <div class="parent">
                        <?php
                        for ($y = 0; $y < 11; $y++) {
                            for ($x = 0; $x < 10; $x++) {
                                echo '<div id="' . ($x + 1) . '-' . ($y + 1) . '" class="chair"><div class="seat"></div></div>';
                            }
                        }

                        ?>
                         <input type="hidden" id="selectedSeats" name="selectedSeats" value="">
                    </div>
                    
                    <div class="legenda">
                        <div class="legenda-item">beschikbaar</div>
                        <div class="legenda-item reserved">bezet</div>
                        <div class="legenda-item selected">selectie</div>
                    </div>
                </div>
                <div class="step-3-container">
                    <div class="step-3"> STAP 3: CONTROLEER JE BESTELLING</div>
                    <div class="contianer">
                        <div class="controll-poster"><img src="<?php echo htmlspecialchars($film['poster']) ?>" alt=""></div>
                        <div class="controll-info">
                            <div class="controll-title"><?php echo htmlspecialchars($film['titel']) ?></div>
                            <div class="controll-viewing-guide"> <?php if (isset($film['kijkwijzer'])): ?>
                                    <?php
                                                                        $age = $film['kijkwijzer']['age'] ?? '12';
                                                                        $warnings = $film['kijkwijzer']['warnings'] ?? [];
                                    ?>
                                    <img src="assets/kijkwijzers/kijkwijzer-<?php echo $age; ?>.png" alt="Kijkwijzer <?php echo $age; ?>">
                                    <?php foreach ($warnings as $warning): ?>
                                        <img src="assets/kijkwijzers/kijkwijzer-<?php echo $warning; ?>.png" alt="<?php echo ucfirst(str_replace('-', ' ', $warning)); ?>">
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <!-- Fallback hardcoded if no kijkwijzer data -->
                                    <img src="assets/kijkwijzers/kijkwijzer-12.png" alt="Kijkwijzer 12">
                                    <img src="assets/kijkwijzers/kijkwijzer-angst.png" alt="Engelse taal">
                                    <img src="assets/kijkwijzers/kijkwijzer-geweld.png" alt="Geweld">
                                <?php endif; ?>
                            </div>
                            <div class="controll-bioscoop"> <?php echo htmlspecialchars($film['bioscoop']) ?></div>
                            <div class="controll-when">wanneer: <div class="controll-when-1"> </div></div>
                            <div>Geselecteerde stoelen: <span id="selectedSeatsDisplay"></span></div>
                        </div>
                    </div>
                </div>

                <div class="gegevens-betaalwijze-container">
                    <h1>STAP 4: VUL JE GEGEVENS IN</h1>
                    <div class="fullname">
                        <input type="text" id="firstname" name="voornaam" placeholder="Voornaam" required>
                        <input type="text" id="surname" name="achternaam" placeholder="Achternaam*" required><br>
                    </div>
                    <input type="email" id="email" name="email" placeholder="E-mailadres" required><br>
                    <input type="email" id="email-bevestiging" name="email_bevestiging" placeholder="E-mailadres*" required>

                    <div class="betaalwijze-container">
                        <h2>STAP 5: KIES JE BETAALWIJZE</h2>
                        <div class="custom-radio-checkbox">
                            <input type="radio" id="box1" name="betaalwijze" value="nationale">
                            <label for="box1"></label>
                            <img src="assets/images/Nationalebioslogo.png" alt="Nationalebioslogo" class="nationalebioslogo">

                            <input type="radio" id="box2" name="betaalwijze" value="maestro">
                            <label for="box2"></label>
                            <img src="assets/images/Maestro-logo.png" alt="maestro-logo" class="maestro-logo">

                            <input type="radio" id="box3" name="betaalwijze" value="ideal">
                            <label for="box3"></label>
                            <img src="assets/images/ideal-logo.png" alt="iDEAL-logo" class="ideal-logo">
                        </div>

                        <div class="terms-checkbox">
                            <input type="checkbox" id="terms" name="terms" required>
                            <label for="terms"></label>
                            <span class="terms-text">Ja, ik ga akkoord met de <a href="#">algemene voorwaarden</a></span>
                        </div>

                        <button type="submit">Afrekenen</button>
                    </div>
                </div>


            </form>












            <div class="bestel-film-card">
                <div class="bestel-film-poster">
                    <img style="height: 100%;  width: 100%;" src="<?php echo htmlspecialchars($film['poster']); ?>"
                        alt="<?php echo htmlspecialchars($film['titel']); ?>">
                </div>

                <div class="bestel-film-info">
                    <div class="bestel-film-title"><?php echo htmlspecialchars($film['titel']); ?></div>
                    <div class="bestel-ratings">
                        <?php echo filter_stars($film['stars']); ?>
                    </div>
                    <div class="bestel-film-release-date">
                        Release: <?php echo htmlspecialchars($film['releasedatum']); ?>
                    </div>
                    <div class="bestel-film-details">
                        <div class="bestel-film-text" id="film-text">
                            <?php echo htmlspecialchars($film['informatie']); ?>
                        </div>
                    </div>



                </div>
            </div>
        </div>
    </main>
    <?php
    include 'assets/includes/footer.php';
    ?>
</body>

</html>