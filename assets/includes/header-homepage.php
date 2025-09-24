<header>
  <div id="header-top">
    <div id="header-top-container">
      <div>
        <a href="index.php">
          <img class="logo" src="assets/logo/logo.PNG" alt="Annex Bios Logo" />
        </a>
      </div>
      <div id="header-top-links" class="links">
        <a href="film-agenda.php">FILM AGENDA</a>
        <a href="#">ALLE VESTIGINGEN</a>
        <a href="#">CONTACT</a>
      </div>
    </div>
  </div>
  <div id="header-bottom">
    <div id="header-bottom-container">
      <div id="purchase-ticket" class="links">
       KOOP JE TICKETS
      </div>


      <select class="dropdown-select" >
        <option value="">Kies je film </option>


        <?php foreach ($data as $title): ?>
          <option value="<?php echo htmlspecialchars($title['titel']); ?>">
            <?php echo htmlspecialchars(substr($title['titel'], 0, 30)); ?><?php if (strlen($title['titel']) > 30) echo '...'; ?>
          </option>

        <?php endforeach; ?>

      </select>


      <div id="order-link" class="links">
        <a href="#">BESTEL TICKETS </a>
      </div>
    </div>
  </div>

</header>