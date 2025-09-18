// document.addEventListener('DOMContentLoaded', function () {
//   document.querySelectorAll('.read-more-btn').forEach(function (button) {
//     button.addEventListener('click', function () {
//       const filmInfo = button.closest('.film-info');
//       const filmDetails = filmInfo.querySelector('.film-details');
//       const filmCard = button.closest('.film-card');

//       if (!filmDetails || !filmCard) return;

//       const expanded = filmDetails.classList.toggle('expanded');
//       filmCard.classList.toggle('expanded', expanded);

//       button.textContent = expanded ? 'Read less' : 'Read more';
//     });
//   });
// });
