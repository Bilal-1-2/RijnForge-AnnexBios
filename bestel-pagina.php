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
    include 'assets/includes/tijdelijk-database.php';
    include 'assets/includes/header.php';
    // Get the film ID from the POST data
    $filmId = isset($_POST['id']) ? (int)$_POST['id'] : 0;

    // Debug: Show what we're receiving
    if ($filmId === 0) {
        echo "<p>Debug: No film ID received in POST data. POST data: " . print_r($_POST, true) . "</p>";
        exit;
    }

    // Find the film in the data array
    $film = null;

    foreach ($data as $item) {
        if ($item['film_id'] === $filmId) {
            $film = $item;
            break;
        }
    }

    if (!$film) {
        echo "<p>Film not found. Looking for film ID: " . $filmId . "</p>";
        echo "<p>Available film IDs in database: ";
        foreach ($data as $item) {
            echo $item['film_id'] . " (" . $item['titel'] . "), ";
        }
        echo "</p>";
        exit;
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