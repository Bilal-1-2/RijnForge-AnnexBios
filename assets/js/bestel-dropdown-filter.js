document.addEventListener('DOMContentLoaded', function() {
    const datumDropdown = document.querySelector('.bestel-dropdown[data-type="datum"]');
    const datumToggle = document.querySelector('.bestel-dropdown[data-type="datum"] .bestel-dropdown-toggle');
    const datumInput = document.querySelector('.bestel-dropdown[data-type="datum"] .bestel-dropdown-input');
    const datumMenu = document.querySelector('.bestel-dropdown[data-type="datum"] .bestel-dropdown-menu');
    const tijdstipMenu = document.querySelector('.bestel-dropdown[data-type="tijdstip"] .bestel-dropdown-menu');
    const tijdstipToggle = document.querySelector('.bestel-dropdown[data-type="tijdstip"] .bestel-dropdown-toggle');
    const tijdstipInput = document.querySelector('.bestel-dropdown[data-type="tijdstip"] .bestel-dropdown-input');

    datumDropdown.querySelectorAll('.bestel-dropdown-item').forEach(item => {
        item.addEventListener('click', function() {
            const selectedDate = this.dataset.value;
            const times = timesByDate[selectedDate] || [];
            tijdstipMenu.innerHTML = '';
            times.forEach(time => {
                const div = document.createElement('div');
                div.className = 'bestel-dropdown-item';
                div.dataset.value = time;
                div.textContent = time;
                div.addEventListener('click', function() {
                    const selectedTime = this.dataset.value;
                    tijdstipToggle.textContent = selectedTime;
                    tijdstipInput.value = selectedTime;
                    tijdstipMenu.classList.remove('open');
                    const selectedDate = datumInput.value;
                    if (selectedDate) {
                        const controllWhen = document.querySelector('.controll-when-1');
                        controllWhen.innerHTML = selectedDate + ' om ' + selectedTime;
                        if (vertoningen[selectedDate] && vertoningen[selectedDate][selectedTime]) {
                            const vertoning = vertoningen[selectedDate][selectedTime];
                            const controllBioscoop = document.querySelector('.controll-bioscoop');
                            controllBioscoop.innerHTML = vertoning.bioscoop + ' - ' + vertoning.zaal;
                        }
                    }
                });
                tijdstipMenu.appendChild(div);
            });
            // Set datum selection
            datumToggle.textContent = selectedDate;
            datumInput.value = selectedDate;
            // Close datum menu
            datumMenu.classList.remove('open');
            // Reset tijdstip selection and open menu
            tijdstipToggle.textContent = 'TIJDSTIP';
            tijdstipInput.value = '';
            tijdstipMenu.classList.add('open');
        });
    });
});

