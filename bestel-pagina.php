<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/bestel-pagina.css">

    <script src="assets/js/scrollbare-header.js" defer></script>
    <script src="assets/js/dropdown.js" defer></script>
    <title>ticket</title>
</head>

<body>
    <?php
    include 'assets/includes/api-database.php';
    include 'assets/includes/header.php';
    // Get the film ID from POST data
    $filmId = isset($_POST['id']) ? (int)$_POST['id'] : 0;

    if ($filmId === 0) {
        echo "<p>No film ID provided.</p>";
        exit;
    }

    // Try to fetch detailed movie data
    $filmDetails = fetchMovieDetails($filmId);

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
            "imdb_score" => $filmDetails['stars'] ?? 0,
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
    ?>
    <main>
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


                    <input type="hidden" name="film" class="bestel-dropdown-input">

                    <div class="bestel-dropdown-menu">
                        <?php foreach ($data as $title): ?>
                            <div class="bestel-dropdown-item" data-value="<?php echo htmlspecialchars($title['titel']); ?>">
                                <?php echo htmlspecialchars($title['titel']); ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <div class="bestel-dropdown" data-type="tijdstip">
                    <button type="button" class="bestel-dropdown-toggle">
                        TIJDSTIP
                    </button>


                    <input type="hidden" name="film" class="bestel-dropdown-input">

                    <div class="bestel-dropdown-menu">
                        <?php foreach ($data as $title): ?>
                            <div class="bestel-dropdown-item" data-value="<?php echo htmlspecialchars($title['titel']); ?>">
                                <?php echo htmlspecialchars($title['titel']); ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
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

                    <h5>€9,00</h5>


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

                <h5>€5,00</h5>

                <select name="aantal-tickets-kinderen" id="aantal-tickets-kinderen">
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
          <div class="normal-prijs-aantal-container">
                <div class="type-section">
                    <h4>Kind t/m 11 jaar</h4>
                </div>


                <div class="ticket-selector-prijs">

                    <h5>€5,00</h5>

                    <select name="aantal-tickets" id="aantal-tickets">
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


            <div class="ticket-selector-prijs">

                <h5>€7,00</h5>

                <select name="aantal-tickets-ouderen" id="aantal-tickets-ouderen">
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

                    <h5>€7,00</h5>

                    <select name="aantal-tickets" id="aantal-tickets">
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
                <input type="text" placeholder="CODE" id="voucher-code-input">
                <button>Toevoegen</button>
            </div>

    </main>
    <?php
    include 'assets/includes/footer.php';
    ?>
</body>

</html>