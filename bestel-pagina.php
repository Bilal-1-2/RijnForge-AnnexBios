<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/bestel-pagina.css">
    <title>ticket</title>
</head>

<body>
    <?php
    include 'assets/includes/tijdelijk-database.php';
    include 'assets/includes/header.php';
    ?>

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

                <select name="aantal-tickets-normaal" id="aantal-tickets-normaal">
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

                <select name="aantal-tickets-kinderen" id="aantal-tickets-kinderen">
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

                <select name="aantal-tickets-ouderen" id="aantal-tickets-ouderen">
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


<?php
    include 'assets/includes/footer.php';
    ?>
</body>

</html>