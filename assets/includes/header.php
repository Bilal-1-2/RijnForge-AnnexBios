<header>

  <div id="header-top">
    <div id="header-top-container">
      <div>
        <a href="index.php">
          <img class="logo" src="assets/logo/logo.PNG" alt="Annex Bios Logo" />
        </a>
      </div>
      <!-- <div id="header-top-links" class="links">
        <a href="film-agenda.php">FILM AGENDA</a>
        <a href="#">ALLE VESTIGINGEN</a>
        <a href="#">CONTACT</a>
      </div> -->
    </div>
  </div>
  <div id="header-bottom">
    <div id="header-bottom-container">
      <form action="bestel-pagina.php" method="POST">
        <div id="purchase-ticket" class="links">
          KOOP JE TICKETS
        </div>

        <div class="dropdown" id="dropdown">
          <button type="button" class="dropdown-toggle" id="dropdownToggle"required>
            Kies je film
          </button>

          <input type="hidden"  name="id" id="dropdownInput" value="" >

          <div class="dropdown-menu" id="dropdownMenu">
            <?php foreach ($data as $film): ?>
              <div class="dropdown-item" data-value="<?php echo htmlspecialchars($film['film_id']); ?>" data-title="<?php echo htmlspecialchars($film['titel']); ?>">
                <?php echo htmlspecialchars($film['titel']); ?>
              </div>
            <?php endforeach; ?>
          </div>
        </div>

        <div id="order-link" class="links">
          <button type="submit" class="film-card-link">BESTEL TICKETS</button>
        </div>
      </form>
    </div>
  </div>

</header>