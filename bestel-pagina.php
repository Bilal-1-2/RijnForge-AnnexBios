<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/bestel-pagina.css">

    <script src="assets/js/scrollbare-header.js" defer></script>
    <script src="assets/js/dropdown.js" defer></script>
    <script src="assets/js/bestel-dropdown-filter.js" defer></script>
    <title>ticket</title>
</head>

<body>
    <?php
    include 'assets/includes/api-database.php';
    include 'assets/includes/price.php';
    include 'assets/includes/stars-filter.php';
    // Get the film ID from POST data
    if (!isset($_POST['id']) || empty($_POST['id'])) {
        header('Location: index.php');
        exit;
    }
    $filmId = (int)$_POST['id'];

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

        $film = [
            "film_id" => $filmDetails['id'] ?? 0,
            "titel" => $filmDetails['movie']['title'] ?? '',
            "releasedatum" => $filmDetails['release_date'] ?? '',
            "duur" => $filmDetails['runtime'] ?? 0,
            "genre" => $genreString ?: 'Action, Thriller',
            "stars" => $filmDetails['stars'] ?? 0,
            "regisseur" => $regisseur ?: 'Timo Tjahjanto',
            "land" => $filmDetails['origin_country'] ?? 'US',
            "acteurs" => $acteurs,
            "poster" => $filmDetails['movie']['poster_path'] ? 'https://image.tmdb.org/t/p/w500' . $filmDetails['movie']['poster_path'] : '',
            "trailers" => '',
            "informatie" => $filmDetails['overview'] ?? ''
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
    }

    // Fetch ticket orders for this movie
    $ticketOrders = fetchTicketOrders($filmId);

    // Extract unique dates and times from ticket orders
    $dates = [];
    $timesByDate = [];
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
    }

    // Get prices from the first ticket order (assuming same for all)
    $prijzen = isset($ticketOrders[0]['prijzen']) ? $ticketOrders[0]['prijzen'] : ['normaal' => 9, 'kind' => 5, 'senior' => 7];
    ?>
    <script>
        var timesByDate = <?php echo json_encode($timesByDate); ?>;
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

                <div class="gegevens-betaalwijze-container">
                    <h1>STAP 4: VUL JE GEGEVENS IN</h1>

                    <input type="text" id="firstname" name="voornaam" placeholder="Voornaam" required>
                    <input type="text" id="surname" name="achternaam" placeholder="Achternaam*" required><br>

                    <input type="email" id="email" name="email" placeholder="E-mailadres" required><br>
                    <input type="email" id="email-bevestiging" name="email_bevestiging" placeholder="E-mailadres*" required>

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
            </form>
            <div class="bestel-film-card">
                <div  class="bestel-film-poster">
                    <img style="height: 100%;" src="<?php echo htmlspecialchars($film['poster']); ?>"
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
                        <div class="bestel-film-text" id="film-text-<?php echo $i; ?>">
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