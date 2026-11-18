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
    require_once 'assets/includes/tijdelijk-database.php';
    include_once 'assets/includes/price.php';
    include 'assets/includes/stars-filter.php';

    // Get POST data
    $filmId = isset($_POST['id']) ? (int)$_POST['id'] : 0;
    if (!$filmId) {
        header('Location: index.php');
        exit;
    }
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

    // Film uit de lokale database
    $film = getFilmById($filmId);
    if (!$film) {
        header('Location: index.php');
        exit;
    }

    // Prijzen en bioscoop uit de lokale database
    $prijzen = FILM_PRIJZEN;
    $bioscoop = BIOSCOOP_NAAM;
    $zaal = '';

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
                    <?php if (!empty($film['poster'])): ?>
                        <img src="<?php echo htmlspecialchars($film['poster']); ?>" alt="<?php echo htmlspecialchars($film['titel']); ?>" class="movie-poster">
                    <?php endif; ?>
                    <div class="movie-details">
                        <h3><?php echo htmlspecialchars($film['titel']); ?></h3>
                        <p><?php echo htmlspecialchars($film['genre']); ?></p>
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
