<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/detail-pagina.css">
    <script src="assets/js/lees-meer.js" defer></script>
  <script src="assets/js/scrollbare-header.js" defer></script>
  <script src="assets/js/dropdown.js" defer></script>
    <title></title>

</head>

<body>

    <?php
    function convertToEmbedUrl($url)
    {
        // Check if it's a YouTube URL
        if (strpos($url, 'youtube.com/watch?v=') !== false) {
            // Extract video ID
            $videoId = '';
            parse_str(parse_url($url, PHP_URL_QUERY), $params);
            if (isset($params['v'])) {
                $videoId = $params['v'];
            }

            // Convert to embed URL with parameters to hide branding and title
            if (!empty($videoId)) {
                return "https://www.youtube.com/embed/" . $videoId . "?modestbranding=1&showinfo=0&rel=0&iv_load_policy=3&controls=1&disablekb=0";
            }
        } elseif (strpos($url, 'youtu.be/') !== false) {
            // Handle shortened youtu.be URLs
            $videoId = str_replace('https://youtu.be/', '', $url);
            if (!empty($videoId)) {
                return "https://www.youtube.com/embed/" . $videoId . "?modestbranding=1&showinfo=0&rel=0&iv_load_policy=3&controls=1&disablekb=0";
            }
        }

        // Return original URL if not a YouTube URL or conversion fails
        return $url;
    }

    include 'assets/includes/api-database.php';
    include 'assets/includes/header.php';
    // Get the film ID from the URL
    // Get the film ID from the POST data
    $filmId = isset($_POST['id']) ? (int)$_POST['id'] : 0;

    if ($filmId === 0) {
        echo "<p>No film ID provided.</p>";
        exit;
    }

    // Try to fetch detailed movie data
    $filmDetails = fetchMovieDetails($filmId);

    if ($filmDetails) {
        // Format the detailed data to match the expected structure
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

        $regisseur = '';
        if (isset($filmDetails['crew']) && is_array($filmDetails['crew'])) {
            foreach ($filmDetails['crew'] as $crewMember) {
                if (isset($crewMember['job']) && $crewMember['job'] === 'Director') {
                    $regisseur = $crewMember['name'] ?? '';
                    break;
                }
            }
        }

        $film = [
            "film_id" => $filmDetails['movie']['id'] ?? 0,
            "titel" => $filmDetails['movie']['title'] ?? '',
            "releasedatum" => $filmDetails['movie']['release_date'] ?? '',
            "duur" => $filmDetails['movie']['runtime'] ?? 0,
            "genre" => $genreString ?: 'Action, Thriller',
            "imdb_score" => $filmDetails['movie']['stars'] ?? 0,
            "regisseur" => $regisseur ?: 'Timo Tjahjanto',
            "land" => $filmDetails['movie']['origin_country'] ?? 'US',
            "acteurs" => $acteurs,
            "poster" => $filmDetails['movie']['poster_path'] ? 'https://image.tmdb.org/t/p/w500' . $filmDetails['movie']['poster_path'] : '',
            "trailers" => '', // Not provided
            "informatie" => $filmDetails['movie']['overview'] ?? ''
        ];
    } else {
        // Fallback to basic data from list
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
                $shortDescription = mb_substr($fullDescription, 0, 700) . (strlen($fullDescription) > 700 ? '...' : '');
                ?>
                <div class="detail-viewing-guide">
                    <img src="assets/kijkwijzers/kijkwijzer-12.png" alt="Age Rating">
                    <img src="assets/kijkwijzers/kijkwijzer-eng.png" alt="Age Rating">
                    <img src="assets/kijkwijzers/kijkwijzer-geweld.png" alt="Age Rating">
                </div>

                <div class="detail-release-date">Release: <?php echo date_format($date, "d-m-Y"); ?></div>


                <div class="detail-description">
                    <?php echo nl2br($shortDescription); ?>
                </div>
                <?php if (strlen($fullDescription) > 700): ?>
                    <button class="read-more-btn" onclick="openModal()">LEES MEER</button>
                <?php endif; ?>

                <div class="detail-separator">
                    <div class="detail-genre">Genre: <?php echo htmlspecialchars($film['genre']); ?></div>
                    <div class="detail-duration">Filmlengte: <?php echo htmlspecialchars($film['duur']); ?> minutes</div>
                    <div class="detail-country">Land: <?php echo htmlspecialchars($film['land']); ?></div>
                    <div class="detail-imdb-score">Imdb Score: <?php echo htmlspecialchars($film['imdb_score']); ?>/10</div>
                    <div class="detail-Director">Regisseur: <?php echo htmlspecialchars($film['regisseur']); ?></div>
                    <div class="detail-writer"> Acteurs: </div>
                </div>
                <div class="detail-actors">
                    <?php
                    if (is_array($film['acteurs'])) {
                        $displayActeurs = array_slice($film['acteurs'], 0, 4);
                        foreach ($displayActeurs as $acteur) {
                            echo '<div class="actor-item">';
                            echo '<img src="' . htmlspecialchars($acteur['foto']) . '" alt="' . htmlspecialchars($acteur['naam']) . '" class="actor-photo">';
                            echo '<div class="actor-name">' . htmlspecialchars($acteur['naam']) . '</div>';
                            echo '</div>';
                        }
                    } else {
                        echo '<div class="detail-actors-list">Acteurs: ' . htmlspecialchars($film['acteurs']) . '</div>';
                    }
                    ?>
                </div>


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

        <form action="bestel-pagina.php" method="post">
          <input type="hidden" name="id" value="<?php echo $film['film_id']; ?>">
          <button type="submit" class="detail-ticket-btn">BUY TICKETS</button>
        </form>

        <div class="trailer-container">
            <iframe width="100%" height="600px"
                src="<?php echo htmlspecialchars(convertToEmbedUrl($film['trailers'])); ?>"
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