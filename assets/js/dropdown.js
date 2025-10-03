
// Dit script beheert de dropdown menu's voor het selecteren van opties, zoals films en bestel opties.
const toggle = document.getElementById('dropdownToggle');
const menu = document.getElementById('dropdownMenu');
const input = document.getElementById('dropdownInput');

// Open of sluit het dropdown menu bij klik op de toggle.
toggle.addEventListener('click', () => {
  menu.classList.toggle('open');
});

// Selecteer een item uit het dropdown menu.
menu.addEventListener('click', (e) => {
  if (e.target.classList.contains('dropdown-item')) {
    // Stel de tekst van de toggle in.
    toggle.textContent = e.target.textContent;

    // Update de verborgen input zodat PHP het ziet.
    input.value = e.target.dataset.value;

    // Sluit het dropdown menu.
    menu.classList.remove('open');
  }
});

// Sluit het menu als je buiten klikt.
document.addEventListener('click', (e) => {
  if (!document.getElementById('dropdown').contains(e.target)) {
    menu.classList.remove('open');
  }
});

// Selecteer alle bestel dropdowns.
const bestelDropdowns = document.querySelectorAll('.bestel-dropdown');

bestelDropdowns.forEach(dropdown => {
  const bestelToggle = dropdown.querySelector('.bestel-dropdown-toggle');
  const bestelMenu = dropdown.querySelector('.bestel-dropdown-menu');
  const bestelInput = dropdown.querySelector('.bestel-dropdown-input');

  // Open of sluit het bestel dropdown menu bij klik op de toggle.
  bestelToggle.addEventListener('click', () => {
    bestelMenu.classList.toggle('open');
  });

  // Selecteer een item uit het bestel dropdown menu.
  bestelMenu.addEventListener('click', (e) => {
    if (e.target.classList.contains('bestel-dropdown-item')) {
      // Stel de tekst van de toggle in.
      bestelToggle.textContent = e.target.textContent;

      // Update de verborgen input zodat PHP het ziet.
      bestelInput.value = e.target.dataset.value;

      // Sluit het bestel dropdown menu.
      bestelMenu.classList.remove('open');
    }
  });

  // Sluit het menu als je buiten deze dropdown klikt.
  document.addEventListener('click', (e) => {
    if (!dropdown.contains(e.target)) {
      bestelMenu.classList.remove('open');
    }
  });
});

// Controleer of een film is geselecteerd voordat bestellen.
chooseMovie = (e) => {
  const filmId = document.getElementById('dropdownInput').value;
  if (!filmId) {
    e.preventDefault();
    alert('Please select a movie first.');
  }
  // Als filmId is ingesteld, sta het formulier toe om via POST te verzenden.
}
document.querySelector('#order-link button').addEventListener('click', chooseMovie);

