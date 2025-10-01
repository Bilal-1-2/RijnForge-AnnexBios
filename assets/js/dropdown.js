
const toggle = document.getElementById('dropdownToggle');
const menu = document.getElementById('dropdownMenu');
const input = document.getElementById('dropdownInput');

toggle.addEventListener('click', () => {
  menu.classList.toggle('open');
});

menu.addEventListener('click', (e) => {
  if (e.target.classList.contains('dropdown-item')) {
    // Set button text
    toggle.textContent = e.target.textContent;

    // Update hidden input so PHP sees it
    input.value = e.target.dataset.value;

    // Close dropdown
    menu.classList.remove('open');
  }
});

// Close if you click outside
document.addEventListener('click', (e) => {
  if (!document.getElementById('dropdown').contains(e.target)) {
    menu.classList.remove('open');
  }
});


const bestelDropdowns = document.querySelectorAll('.bestel-dropdown');

bestelDropdowns.forEach(dropdown => {
  const bestelToggle = dropdown.querySelector('.bestel-dropdown-toggle');
  const bestelMenu = dropdown.querySelector('.bestel-dropdown-menu');
  const bestelInput = dropdown.querySelector('.bestel-dropdown-input');

  bestelToggle.addEventListener('click', () => {
    bestelMenu.classList.toggle('open');
  });

  bestelMenu.addEventListener('click', (e) => {
    if (e.target.classList.contains('bestel-dropdown-item')) {
      // Set button text
      bestelToggle.textContent = e.target.textContent;

      // Update hidden input so PHP sees it
      bestelInput.value = e.target.dataset.value;

      // Close dropdown
      bestelMenu.classList.remove('open');
    }
  });

  // Close if you click outside this dropdown
  document.addEventListener('click', (e) => {
    if (!dropdown.contains(e.target)) {
      bestelMenu.classList.remove('open');
    }
  });
});
chooseMovie = (e) => {
  const filmId = document.getElementById('dropdownInput').value;
  if (!filmId) {
    e.preventDefault();
    alert('Please select a movie first.');
  }
  // If filmId is set, allow the form to submit via POST
}
document.querySelector('#order-link button').addEventListener('click', chooseMovie);

