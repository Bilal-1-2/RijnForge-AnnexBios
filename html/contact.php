<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Contact - AnnexBios Leidscherijn</title>
    <link rel="stylesheet" href="assets/css/contact.css" />
    <script src="assets/js/scrollbare-header.js" defer></script>
    <!-- <script src="assets/js/film-filters.js" defer></script> -->
    <script src="assets/js/dropdown.js" defer></script>
</head>

<body>

    <?php
    include 'assets/includes/api-database.php';
    include 'assets/includes/header.php'; ?>

    <main>
        <section class="contact-section">
            <h1>Contact</h1>
            <p>Heeft u vragen of opmerkingen? Neem gerust contact met ons op via onderstaand formulier of via de contactgegevens.</p>

            <div class="contact-container">
                <div class="contact-info">
                    <h2>Contactgegevens</h2>
                    <p><strong>Adres:</strong> Berlijnplein 101, 3541 CM Utrecht</p>
                    <p><strong>Telefoon:</strong> 088 - 5152050</p>
                    <p><strong>Email:</strong> info@annexbiosleidscherijn.nl</p>
                </div>

                <div class="contact-form">
                    <h2>Contactformulier</h2>
                    <form action="contact-submit.php" method="POST">
                        <label for="name">Naam:</label><br />
                        <input type="text" id="name" name="name" required /><br />

                        <label for="email">E-mail:</label><br />
                        <input type="email" id="email" name="email" required /><br />

                        <label for="message">Bericht:</label><br />
                        <textarea id="message" name="message" rows="6" required></textarea><br />

                        <button type="submit">Verstuur</button>
                    </form>
                </div>
            </div>
        </section>
    </main>

    <?php include 'assets/includes/footer.php'; ?>
</body>

</html>
