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

    <div class="bedankt-title-container">
        <h1>Bedankt voor je bestelling!</h1>
    </div>

    <div class="bedankt-pagina-container">
        
        <div class="poster-section">
            <img src="assets/films/Jurassic-World_-Fallen-Kingdom.jpg" alt="poster" class="poster-image">  
        </div>

        <div class="info-section">
        
                <h2>Je bestelling is succesvol afgerond.</h2>
                <p>Hierin vind je alle details van je bestelling.</p>
                
                <div class="info-details">
                    <div class="film-title">Film: Jurassic World: Fallen Kingdom</div>
                    <div class="datum">Datum: 29-09-25</div>
                    <div class="tijdsduur">Tijd: 2u 9 min</div>
                    <div class="ticket-aantal">tickets: 2</div>
                    <div class="stoelen">Stoelen: Rij 5 zitplaatsen 7 tot 8</div>
                    <div class="bedrag">Bedrag: €14,00</div>
                </div>


        </div>
                
            

        
        
       

    </div>
 
        <?php
        include 'assets/includes/footer.php';
        ?>


</body>

</html>