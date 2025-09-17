<header>
  <div id="header-top">
    <div id="header-top-container">
      <div>
        <a href="index.php">
          <img class="logo" src="assets/logo/logo.PNG" alt="Annex Bios Logo" />
        </a>
      </div>
      <div id="header-top-links" class="links">
        <a href="#">FILM AGENDA</a>
        <a href="#">ALLE VESTIGINGEN</a>
        <a href="#">CONTACT</a>
      </div>
    </div>
  </div>
  <div id="header-bottom">
    <div id="header-bottom-container">
      <div id="purchase-ticket" class="links">
        <a href="">KOOP JE TICKETS</a>
      </div>


      <select class="dropdown-select"  onfocus='this.size=10;' onblur='this.size=1;' onchange='this.size=1; this.blur();' >
        <option value="">Kies je film </option>
 
       
  <?php foreach( $data as $title ): ?>
  <option value="<?php echo htmlspecialchars($title['titel']); ?>">
    <?php echo htmlspecialchars($title['titel']); ?>
  </option>
  
  <?php endforeach; ?>

      </select>


      <div id="order-link" class="links">
        <a href="#">BESTEL TICKETS </a>
      </div>
    </div>
  </div>

</header>