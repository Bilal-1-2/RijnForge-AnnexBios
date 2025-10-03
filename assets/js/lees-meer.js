// Dit script beheert het openen en sluiten van de modal voor "lees meer".
function openModal() {
  // Toon de overlay (modal) door display op flex te zetten.
  document.getElementById("overlay").style.display = "flex";
}

function closeModal() {
  // Verberg de overlay (modal) door display op none te zetten.
  document.getElementById("overlay").style.display = "none";
}

// Optioneel: sluit de modal als de gebruiker buiten de modal box klikt.
window.onclick = function(event) {
  let overlay = document.getElementById("overlay");
  if (event.target === overlay) {
    overlay.style.display = "none";
  }
}
