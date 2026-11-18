// Dit script beheert het filteren van films op basis van datum en categorie in de filmagenda.
document.addEventListener('DOMContentLoaded', function() {
    // Controleer of we op de film-agenda pagina zijn
    const isFilmAgenda = window.location.pathname.includes('film-agenda.php');

    // Selecteer alle filmkaarten, radio buttons voor stijl en de categorie select.
    const filmCards = document.querySelectorAll('.film-card');
    const styleRadios = document.querySelectorAll('input[name="style"]');
    const categorieSelect = document.querySelector('.categorie-select');

    // Functie om de filters toe te passen op de filmkaarten.
    function applyFilters() {
        // Haal de geselecteerde stijl en categorie op.
        const selectedStyle = document.querySelector('input[name="style"]:checked')?.value;
        const selectedCategory = categorieSelect.value.toLowerCase();

        // Controleer of er filters zijn geselecteerd.
        if (selectedStyle || selectedCategory) {
            // Bereken de datums voor vandaag en een week geleden.
            const today = new Date();
            const todayStr = today.toISOString().split('T')[0];
            const weekAgo = new Date(today);
            weekAgo.setDate(today.getDate() - 7);
            const weekAgoStr = weekAgo.toISOString().split('T')[0];

            // Array om overeenkomende kaarten op te slaan.
            const matchingCards = [];

            // Loop door alle filmkaarten om te controleren welke voldoen aan de filters.
            filmCards.forEach(card => {
                // Haal de vertoningstijden en genres op uit de data-attributen.
                const showtimes = JSON.parse(card.dataset.showtimes || '[]');
                const genres = card.dataset.genre || '';

                // Controleer op datumfilter.
                let showByDate = true;
                if (selectedStyle === 'vandaag') {
                    // Toon alleen films die vandaag draaien.
                    showByDate = showtimes.includes(todayStr);
                } else if (selectedStyle === 'deze-week') {
                    // Toon films die deze week draaien.
                    showByDate = showtimes.some(date => date >= weekAgoStr && date <= todayStr);
                } else if (selectedStyle === 'films') {
                    // Toon alle films.
                }

                // Controleer op categoriefilter.
                let showByCategory = true;
                if (selectedCategory) {
                    // Controleer of het genre overeenkomt.
                    showByCategory = genres.includes(selectedCategory);
                }

                // Als beide voorwaarden waar zijn, voeg toe aan overeenkomende kaarten.
                if (showByDate && showByCategory) {
                    matchingCards.push(card);
                }
            });

            // Verberg eerst alle kaarten.
            filmCards.forEach(card => {
                card.style.display = 'none';
            });

            // Toon alle overeenkomende kaarten of de eerste 12.
            if (isFilmAgenda) {
                matchingCards.forEach(card => {
                    card.style.display = 'block';
                });
            } else {
                matchingCards.slice(0, 12).forEach(card => {
                    card.style.display = 'block';
                });
            }
        } else {
            // Geen filters geselecteerd, toon alle films of de eerste 12.
            if (isFilmAgenda) {
                filmCards.forEach(card => {
                    card.style.display = 'block';
                });
            } else {
                filmCards.forEach((card, index) => {
                    card.style.display = index < 12 ? 'block' : 'none';
                });
            }
        }
    }

    // Voeg event listeners toe aan de radio buttons voor stijl.
    styleRadios.forEach(radio => {
        radio.addEventListener('change', applyFilters);
    });
    // Voeg event listener toe aan de categorie select.
    categorieSelect.addEventListener('change', applyFilters);

    // Pas de filters toe bij het laden van de pagina.
    applyFilters();
});
