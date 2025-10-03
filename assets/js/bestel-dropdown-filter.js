// Dit script beheert de dropdown filters voor datum en tijdstip selectie in de bestelpagina, en valideert het formulier.
document.addEventListener('DOMContentLoaded', function() {
    // Selecteer de elementen voor de datum dropdown.
    const datumDropdown = document.querySelector('.bestel-dropdown[data-type="datum"]');
    const datumToggle = document.querySelector('.bestel-dropdown[data-type="datum"] .bestel-dropdown-toggle');
    const datumInput = document.querySelector('input[name="datum"]');
    const datumMenu = document.querySelector('.bestel-dropdown[data-type="datum"] .bestel-dropdown-menu');
    // Selecteer de elementen voor de tijdstip dropdown.
    const tijdstipMenu = document.querySelector('.bestel-dropdown[data-type="tijdstip"] .bestel-dropdown-menu');
    const tijdstipToggle = document.querySelector('.bestel-dropdown[data-type="tijdstip"] .bestel-dropdown-toggle');
    const tijdstipInput = document.querySelector('input[name="tijdstip"]');

    // Controleer of de datum dropdown bestaat.
    if (datumDropdown) {
        // Voeg event listeners toe aan elke datum item.
        datumDropdown.querySelectorAll('.bestel-dropdown-item').forEach(item => {
            item.addEventListener('click', function() {
                // Haal de geselecteerde datum op.
                const selectedDate = this.dataset.value;
                // Haal de beschikbare tijden voor deze datum op.
                const times = timesByDate[selectedDate] || [];
                // Leeg de tijdstip menu.
                tijdstipMenu.innerHTML = '';
                // Voeg tijdstip opties toe aan het menu.
                times.forEach(time => {
                    const div = document.createElement('div');
                    div.className = 'bestel-dropdown-item';
                    div.dataset.value = time;
                    div.textContent = time;
                    // Voeg event listener toe aan tijdstip item.
                    div.addEventListener('click', function() {
                        // Haal het geselecteerde tijdstip op.
                        const selectedTime = this.dataset.value;
                        // Update de toggle tekst en input waarde.
                        tijdstipToggle.textContent = selectedTime;
                        tijdstipInput.value = selectedTime;
                        // Sluit het tijdstip menu.
                        tijdstipMenu.classList.remove('open');
                        // Haal de geselecteerde datum op.
                        const selectedDate = datumInput.value;
                        if (selectedDate) {
                            // Update de controle tekst voor wanneer.
                            const controllWhen = document.querySelector('.controll-when-1');
                            controllWhen.innerHTML = selectedDate + ' om ' + selectedTime;
                            // Controleer of er een vertoning is voor deze datum en tijd.
                            if (vertoningen[selectedDate] && vertoningen[selectedDate][selectedTime]) {
                                const vertoning = vertoningen[selectedDate][selectedTime];
                                // Update de controle tekst voor bioscoop.
                                const controllBioscoop = document.querySelector('.controll-bioscoop');
                                controllBioscoop.innerHTML = vertoning.bioscoop + ' - ' + vertoning.zaal;
                                // Stel verborgen inputs in voor bioscoop en zaal.
                                document.getElementById('selectedBioscoop').value = vertoning.bioscoop;
                                document.getElementById('selectedZaal').value = vertoning.zaal;
                            }
                        }
                    });
                    tijdstipMenu.appendChild(div);
                });
                // Stel de datum selectie in.
                datumToggle.textContent = selectedDate;
                datumInput.value = selectedDate;
                // Sluit het datum menu.
                datumMenu.classList.remove('open');
                // Reset de tijdstip selectie en open het menu.
                tijdstipToggle.textContent = 'TIJDSTIP';
                tijdstipInput.value = '';
                tijdstipMenu.classList.add('open');
            });
        });
    }
});

// Formuliervalidatie om ervoor te zorgen dat datum en tijdstip zijn geselecteerd voordat verzending.
document.addEventListener('DOMContentLoaded', function() {
    const bestelForm = document.getElementById('bestel-form');
    if (bestelForm) {
        bestelForm.addEventListener('submit', function(e) {
            // Haal de waarden van datum en tijdstip op.
            const datum = document.querySelector('input[name="datum"]').value;
            const tijdstip = document.querySelector('input[name="tijdstip"]').value;
            // Controleer of beide zijn geselecteerd.
            if (!datum || !tijdstip) {
                e.preventDefault();
                alert('Please select a date and time before proceeding.');
            }
        });
    }
});
