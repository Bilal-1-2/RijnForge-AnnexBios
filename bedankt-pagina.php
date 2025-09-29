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

    <div class="bedankt-container">
        <div class="bedankt-header">
            <h1 class="bedankt-title">Bedankt voor je bestelling!</h1>
            <p class="bedankt-subtitle">Je ontvangt zo snel mogelijk een bevestigingsmail met daarin je tickets.</p>
        </div>

        <div class="order-overview">
            <div class="overview-section">
                <h2 class="overview-title">Besteloverzicht</h2>
                <div class="movie-info">
                    <?php if (isset($film['poster']) && !empty($film['poster'])): ?>
                        <img src="<?php echo htmlspecialchars($film['poster']); ?>" alt="<?php echo htmlspecialchars($film['titel']); ?>" class="movie-poster">
                    <?php endif; ?>
                    <div class="movie-details">
                        <h3><?php echo htmlspecialchars($film['titel']); ?></h3>
                        <p><?php echo htmlspecialchars($film['titel']); ?></p>
                    </div>
                </div>
                <div class="location-info">
                    <div class="location-item">
                        <span class="location-label">Bioscoop:</span> <?php echo htmlspecialchars(!empty($selectedBioscoop) ? $selectedBioscoop : $bioscoop); ?>
                    </div>
                    <div class="location-item">
                        <span class="location-label">Zaal:</span> <?php echo htmlspecialchars(!empty($selectedZaal) ? $selectedZaal : $zaal); ?>
                    </div>
                    <div class="location-item">
                        <span class="location-label">Datum & Tijd:</span> <?php echo htmlspecialchars($datum . ' om ' . $tijdstip); ?>
                    </div>
                </div>
                <div class="seats-info">
                    <span class="location-label">Stoelen:</span>
                    <ul class="seats-list">
                        <?php foreach ($formattedSeats as $seat): ?>
                            <li class="seat-item"><?php echo htmlspecialchars($seat); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
            <div class="tickets-section">
                <h3 class="overview-title">Tickets</h3>
                <div class="ticket-type">
                    <span>Normaal: <?php echo $normaal; ?> x €<?php echo formatPrice($prijzen['normaal']); ?></span>
                    <span>= €<?php echo formatPrice($normaal * $prijzen['normaal']); ?></span>
                </div>
                <div class="ticket-type">
                    <span>Kind: <?php echo $kind; ?> x €<?php echo formatPrice($prijzen['kind']); ?></span>
                    <span>= €<?php echo formatPrice($kind * $prijzen['kind']); ?></span>
                </div>
                <div class="ticket-type">
                    <span>Senior: <?php echo $senior; ?> x €<?php echo formatPrice($prijzen['senior']); ?></span>
                    <span>= €<?php echo formatPrice($senior * $prijzen['senior']); ?></span>
                </div>
                <div class="ticket-total">
                    Totaal: €<?php echo formatPrice($total); ?>
                </div>
            </div>
        </div>

        <div class="customer-info">
            <h2 class="customer-title">Klantgegevens</h2>
            <div class="customer-details">
                <div class="detail-item">
                    <span class="detail-label">Naam:</span> <?php echo htmlspecialchars($voornaam . ' ' . $achternaam); ?>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Email:</span> <?php echo htmlspecialchars($email); ?>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Betaalwijze:</span> <?php echo htmlspecialchars($betaalwijze); ?>
                </div>
            </div>
        </div>

        <a href="index.php" class="home-button">Terug naar home</a>

     </div>
 <?php
        include 'assets/includes/footer.php';
        ?>

</body>
  
</html>