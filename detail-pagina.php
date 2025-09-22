<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/detail-pagina.css">
    <script src="assets/js/lees-meer.js" defer></script>

    <title></title>

</head>

<body>

    <?php
    include 'assets/includes/tijdelijk-database.php';
    include 'assets/includes/header.php';
    // Get the film ID from the URL
    $filmId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
    // Find the film in the data array
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
    // Create DateTime object for formatting the release date
    $date = new DateTime($film['releasedatum']);
    ?>
    <main>
        <div class="detail-title"><?php echo htmlspecialchars($film['titel']); ?></div>
        <div class="film-detail-container">
            <div class="film-detail-poster">
                <img src="<?php echo htmlspecialchars($film['poster']); ?>" alt="<?php echo htmlspecialchars($film['titel']); ?>">
            </div>
            <div class="detail-info">
                <div class="detail-ratings">
                    <img src="assets/icons/ster.svg" alt="">
                    <img src="assets/icons/ster.svg" alt="">
                    <img src="assets/icons/ster.svg" alt="">
                    <img src="assets/icons/ster.svg" alt="">
                    <img src="assets/icons/ster.svg" alt="">
                </div>
                <?php
                $fullDescription = htmlspecialchars($film['informatie']);
                $shortDescription = mb_substr($fullDescription, 0, 321) . (strlen($fullDescription) > 321 ? '...' : '');
                ?>
                <div class="detail-viewing-guide">
                    <img src="assets/kijkwijzers/kijkwijzer-12.png" alt="Age Rating">
                    <img src="assets/kijkwijzers/kijkwijzer-eng.png" alt="Age Rating">
                    <img src="assets/kijkwijzers/kijkwijzer-geweld.png" alt="Age Rating">
                </div>

                <div class="detail-release-date">Release: <?php echo date_format($date, "d-m-Y"); ?></div>

                <!-- Short description -->
                <div class="detail-description">
                    <?php echo nl2br($shortDescription); ?>
                </div>
                <?php if (strlen($fullDescription) > 321): ?>
                    <button class="read-more-btn" onclick="openModal()">LEES MEER</button>
                <?php endif; ?>
                <p class="detail-duration">Duration: <?php echo htmlspecialchars($film['duur']); ?> minutes</p>




                <div class="overlay" id="overlay">
                    <div class="modal">
                        <h2><?php echo htmlspecialchars($film['titel']); ?></h2>
                        <p>
                            <?php echo nl2br($fullDescription); ?>
                        </p>
                        <button class="close-btn" onclick="closeModal()">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <button class="detail-ticket-btn">BUY TICKETS</button>

        <div class="trailer-container">
            <iframe width="420" height="315"
                    src="  <?php echo htmlspecialchars($film['trailers']); ?>"
                    frameborder="0"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                    allowfullscreen>
            </iframe>
        </div>
    </main>
    <?php
    include 'assets/includes/footer.php';
    ?>
</body>

</html>