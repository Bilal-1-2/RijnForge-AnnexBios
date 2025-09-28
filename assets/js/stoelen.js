document.addEventListener("DOMContentLoaded", function () {
  const stoelen = document.querySelectorAll(".chair");
  let maxSeats = getTotalTickets();

  // Update maxSeats when ticket selects change
  const ticketSelects = document.querySelectorAll('select[name^="aantal-tickets-"]');
  ticketSelects.forEach(function (select) {
    select.addEventListener("change", function () {
      maxSeats = getTotalTickets();
      console.log("Max seats updated to:", maxSeats);
      // Optionally, deselect excess seats if any
      enforceMaxSeats();
    });
  });

  stoelen.forEach(function (stoel) {
    stoel.addEventListener("click", function () {
      const isSelected = stoel.classList.contains("selected");
      const currentSelected = document.querySelectorAll(".chair.selected").length;

      if (!isSelected && currentSelected >= maxSeats) {
        alert("Je kunt niet meer stoelen selecteren dan het aantal tickets.");
        return;
      }

      stoel.classList.toggle("selected");
      console.log("Stoel geklikt:", stoel.id);
      updateSelectedSeats();
    });
  });

  function getTotalTickets() {
    const normaal = parseInt(document.getElementById("aantal-tickets-normaal").value) || 0;
    const kind = parseInt(document.getElementById("aantal-tickets-kind").value) || 0;
    const senior = parseInt(document.getElementById("aantal-tickets-senior").value) || 0;
    return normaal + kind + senior;
  }

  function enforceMaxSeats() {
    const selected = document.querySelectorAll(".chair.selected");
    if (selected.length > maxSeats) {
      // Deselect excess seats (last selected first)
      for (let i = selected.length - 1; i >= maxSeats; i--) {
        selected[i].classList.remove("selected");
      }
      updateSelectedSeats();
    }
  }

  function updateSelectedSeats() {
    const selectedSeats = [];
    stoelen.forEach(function (stoel) {
      if (stoel.classList.contains("selected")) {
        selectedSeats.push(stoel.id);
      }
    });
    document.getElementById("selectedSeats").value = selectedSeats.join(", ");
    console.log("Geselecteerde stoelen:", selectedSeats);
  }

  // Initial update to show any pre-selected seats
  updateSelectedSeats();

  // Optional: Add hover effect for better UX
  stoelen.forEach(function (stoel) {
    stoel.addEventListener("mouseover", function () {
      stoel.style.cursor = "pointer";
    });
    stoel.addEventListener("mouseout", function () {
      stoel.style.cursor = "default";
    });
  });
});
