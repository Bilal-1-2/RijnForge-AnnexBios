<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>bedanktpagina</title>
    <link rel="stylesheet" href="assets/css/bedankt-pagina.css">

</head>

<body>

    <?php
    include 'assets/includes/tijdelijk-database.php';
    include 'assets/includes/header.php';
    ?>

    <div class="bedankt-pagina-container">
        <h1>Bedankt voor je bestelling!</h1>
        <p>Je ontvangt zo snel mogelijk een bevestigingsmail met daarin je tickets.</p>
        <a href="index.php" class="terug-naar-home-button">Terug naar home</a>

 
        <?php
        include 'assets/includes/footer.php';
        ?>


</body>

</html>