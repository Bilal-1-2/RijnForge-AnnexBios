document.addEventListener('DOMContentLoaded', function() {
    const filmCards = document.querySelectorAll('.film-card');
    const styleRadios = document.querySelectorAll('input[name="style"]');
    const categorieSelect = document.querySelector('.categorie-select');

    function applyFilters() {
        const selectedStyle = document.querySelector('input[name="style"]:checked')?.value || 'films';
        const selectedCategory = categorieSelect.value.toLowerCase();

        const today = new Date();
        const todayStr = today.toISOString().split('T')[0]; // YYYY-MM-DD
        const weekAgo = new Date(today);
        weekAgo.setDate(today.getDate() - 7);
        const weekAgoStr = weekAgo.toISOString().split('T')[0];

        filmCards.forEach(card => {
            const showtimes = JSON.parse(card.dataset.showtimes || '[]');
            const genres = card.dataset.genre || '';

            let showByDate = true;
            if (selectedStyle === 'vandaag') {
                showByDate = showtimes.includes(todayStr);
            } else if (selectedStyle === 'deze-week') {
                showByDate = showtimes.some(date => date >= weekAgoStr && date <= todayStr);
            } // 'films' shows all

            let showByCategory = true;
            if (selectedCategory) {
                showByCategory = genres.includes(selectedCategory);
            }

            card.style.display = (showByDate && showByCategory) ? 'block' : 'none';
        });
    }

    // Event listeners
    styleRadios.forEach(radio => {
        radio.addEventListener('change', applyFilters);
    });
    categorieSelect.addEventListener('change', applyFilters);

    // Initial filter application (default: all films, no category)
    applyFilters();
});
