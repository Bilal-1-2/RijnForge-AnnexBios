<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>bedanktpagina</title>
    <link rel="stylesheet" href="assets/css/bedankt-pagina.css">
        <script src="assets/js/scrollbare-header.js" defer></script>
    <script src="assets/js/dropdown.js" defer></script>

</head>

<body>

    <?php
    include 'assets/includes/api-database.php';
    include 'assets/includes/price.php';
    include 'assets/includes/stars-filter.php';
    include 'assets/includes/tijdelijk-database.php';

    // Define formatPrice if not already defined
    if (!function_exists('formatPrice')) {
        function formatPrice($price)
        {
            return number_format((float)$price, 2, ',', '');
        }
    }

    // Get POST data
    $filmId = isset($_POST['id']) ? (int)$_POST['id'] : 0;
    $datum = isset($_POST['datum']) ? $_POST['datum'] : '';
    $tijdstip = isset($_POST['tijdstip']) ? $_POST['tijdstip'] : '';
    $selectedSeats = isset($_POST['selectedSeats']) ? $_POST['selectedSeats'] : '';
    $normaal = isset($_POST['aantal-tickets-normaal']) ? (int)$_POST['aantal-tickets-normaal'] : 0;
    $kind = isset($_POST['aantal-tickets-kind']) ? (int)$_POST['aantal-tickets-kind'] : 0;
    $senior = isset($_POST['aantal-tickets-senior']) ? (int)$_POST['aantal-tickets-senior'] : 0;
    $voornaam = isset($_POST['voornaam']) ? $_POST['voornaam'] : '';
    $achternaam = isset($_POST['achternaam']) ? $_POST['achternaam'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $betaalwijze = isset($_POST['betaalwijze']) ? $_POST['betaalwijze'] : '';
    $selectedBioscoop = isset($_POST['bioscoop']) ? $_POST['bioscoop'] : '';
    $selectedZaal = isset($_POST['zaal']) ? $_POST['zaal'] : '';

    // Fetch film details
    $filmDetails = fetchMovieDetails($filmId);
    $film = null;
    if ($filmDetails) {
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
            "titel" => $filmDetails['movie']['title'] ?? '',
            "poster" => $filmDetails['movie']['poster_path'] ? 'https://image.tmdb.org/t/p/w500' . $filmDetails['movie']['poster_path'] : '',
            "kijkwijzer" => $kijkwijzer,
        ];
    } else {
        foreach ($data as $item) {
            if ($item['film_id'] === $filmId) {
                $film = $item;
                break;
            }
        }
    }

    // Fetch ticket orders to get prijzen and bioscoop
    $ticketOrders = fetchTicketOrders($filmId);
    $prijzen = isset($ticketOrders[0]['prijzen']) ? $ticketOrders[0]['prijzen'] : ['normaal' => 9, 'kind' => 5, 'senior' => 7];
    $bioscoop = isset($ticketOrders[0]['bioscoop']['name']) ? $ticketOrders[0]['bioscoop']['name'] : 'AnnexBios Leidscherijn';
    $zaal = isset($ticketOrders[0]['bioscoop']['zaal']) ? $ticketOrders[0]['bioscoop']['zaal'] : '';

    // Calculate total
    $total = $normaal * $prijzen['normaal'] + $kind * $prijzen['kind'] + $senior * $prijzen['senior'];

    // Format seats
    $formattedSeats = [];
    if (!empty($selectedSeats)) {
        $seats = explode(', ', $selectedSeats);
        foreach ($seats as $seat) {
            $parts = explode('-', $seat);
            if (count($parts) == 2) {
                $formattedSeats[] = 'Rij ' . $parts[1] . ' Stoel ' . $parts[0];
            }
        }
    }

    include 'assets/includes/header.php';
    ?>

    <div class="bedankt-pagina-container">
        <h1>Bedankt voor je bestelling!</h1>
        <p>Je ontvangt zo snel mogelijk een bevestigingsmail met daarin je tickets.</p>

        <div class="order-summary">
            <h2>Besteloverzicht</h2>
            <div class="order-film">
                <?php if (isset($film['poster']) && !empty($film['poster'])): ?>
                    <img src="<?php echo htmlspecialchars($film['poster']); ?>" alt="<?php echo htmlspecialchars($film['titel']); ?>" class="order-poster">
                <?php endif; ?>
                <div class="order-film-info">
                    <h3><?php echo htmlspecialchars($film['titel']); ?></h3>
                    <p><strong>Bioscoop:</strong> <?php echo htmlspecialchars(!empty($selectedBioscoop) ? $selectedBioscoop : $bioscoop); ?></p>
                    <p><strong>Zaal:</strong> <?php echo htmlspecialchars(!empty($selectedZaal) ? $selectedZaal : $zaal); ?></p>
                    <p><strong>Datum & Tijd:</strong> <?php echo htmlspecialchars($datum . ' om ' . $tijdstip); ?></p>
                    <p><strong>Stoelen:</strong> <?php echo htmlspecialchars(implode(', ', $formattedSeats)); ?></p>
                </div>
            </div>
            <div class="order-tickets">
                <h4>Tickets</h4>
                <p>Normaal: <?php echo $normaal; ?> x €<?php echo formatPrice($prijzen['normaal']); ?> = €<?php echo formatPrice($normaal * $prijzen['normaal']); ?></p>
                <p>Kind: <?php echo $kind; ?> x €<?php echo formatPrice($prijzen['kind']); ?> = €<?php echo formatPrice($kind * $prijzen['kind']); ?></p>
                <p>Senior: <?php echo $senior; ?> x €<?php echo formatPrice($prijzen['senior']); ?> = €<?php echo formatPrice($senior * $prijzen['senior']); ?></p>
                <p><strong>Totaal: €<?php echo formatPrice($total); ?></strong></p>
            </div>
            <div class="order-customer">
                <h4>Klantgegevens</h4>
                <p><strong>Naam:</strong> <?php echo htmlspecialchars($voornaam . ' ' . $achternaam); ?></p>
                <p><strong>Email:</strong> <?php echo htmlspecialchars($email); ?></p>
                <p><strong>Betaalwijze:</strong> <?php echo htmlspecialchars($betaalwijze); ?></p>
            </div>
        </div>

        <a href="index.php" class="terug-naar-home-button">Terug naar home</a>

        <?php
        include 'assets/includes/footer.php';
        ?>


</body>

</html>