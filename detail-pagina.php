<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/detail-pagina.css">
    
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
?>
<main>
    <div class="detail-container">
        <div class="detail-title"><?php echo htmlspecialchars($film['titel']); ?></div>
        <div class="detail-poster">
            <img src="<?php echo htmlspecialchars($film['poster']); ?>" alt="<?php echo htmlspecialchars($film['titel']); ?>">
        </div>
        <div class="detail-info">
            <div class="detail-title"><?php echo htmlspecialchars($film['titel']); ?></div>
            <p class="detail-release-date">Release Date: <?php echo htmlspecialchars($film['releasedatum']); ?></p>
            <!-- <p class="detail-genre">Genre: <?php echo htmlspecialchars($film['genre']); ?></p> -->
            <p class="detail-duration">Duration: <?php echo htmlspecialchars($film['duur']); ?> minutes</p>
            <p class="detail-description"><?php echo nl2br(htmlspecialchars($film['informatie'])); ?></p>
            <button class="detail-ticket-btn">BUY TICKETS</button>
        </div>
    </div>  
</main>
<?php
include 'assets/includes/footer.php';
?>
</body>
</html>