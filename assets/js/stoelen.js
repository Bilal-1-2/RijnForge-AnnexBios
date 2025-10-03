/*
  Dit script beheert de stoelselectie op de bestelpagina.
  Het zorgt ervoor dat gebruikers niet meer stoelen kunnen selecteren dan het aantal gekochte tickets.
  Daarnaast wordt de totaalprijs van de tickets bijgewerkt en worden geselecteerde stoelen weergegeven.
*/
document.addEventListener("DOMContentLoaded", function () {
  // Selecteer alle stoel elementen.
  const stoelen = document.querySelectorAll(".chair");
  // Bepaal het maximale aantal stoelen dat geselecteerd mag worden.
  let maxSeats = getTotalTickets();

  // Update maxSeats wanneer het aantal tickets verandert.
  const ticketSelects = document.querySelectorAll('select[name^="aantal-tickets-"]');
  ticketSelects.forEach(function (select) {
    select.addEventListener("change", function () {
      maxSeats = getTotalTickets();
      console.log("Max stoelen bijgewerkt naar:", maxSeats);
      // Optioneel: deselecteer overtollige stoelen.
      enforceMaxSeats();
    });
  });

  // Voeg klik event listeners toe aan elke stoel.
  stoelen.forEach(function (stoel) {
    stoel.addEventListener("click", function () {
      const isSelected = stoel.classList.contains("selected");
      const currentSelected = document.querySelectorAll(".chair.selected").length;

      // Voorkom dat er meer stoelen geselecteerd worden dan het aantal tickets.
      if (!isSelected && currentSelected >= maxSeats) {
        alert("Je kunt niet meer stoelen selecteren dan het aantal tickets.");
        return;
      }

      // Wissel de selectie status van de stoel.
      stoel.classList.toggle("selected");
      console.log("Stoel geklikt:", stoel.id);
      updateSelectedSeats();
    });
  });

  // Haal het totaal aantal tickets op.
  function getTotalTickets() {
    const normaal = parseInt(document.getElementById("aantal-tickets-normaal").value) || 0;
    const kind = parseInt(document.getElementById("aantal-tickets-kind").value) || 0;
    const senior = parseInt(document.getElementById("aantal-tickets-senior").value) || 0;
    return normaal + kind + senior;
  }

  // Deselecteer overtollige stoelen als er meer zijn geselecteerd dan toegestaan.
  function enforceMaxSeats() {
    const selected = document.querySelectorAll(".chair.selected");
    if (selected.length > maxSeats) {
      // Deselecteer overtollige stoelen (laatst geselecteerd eerst).
      for (let i = selected.length - 1; i >= maxSeats; i--) {
        selected[i].classList.remove("selected");
      }
      updateSelectedSeats();
    }
  }

  // Werk de lijst van geselecteerde stoelen bij.
  function updateSelectedSeats() {
    const selectedSeats = [];
    const formattedSeats = [];
    stoelen.forEach(function (stoel) {
      if (stoel.classList.contains("selected")) {
        selectedSeats.push(stoel.id);
        const [seatNum, rowNum] = stoel.id.split('-');
        formattedSeats.push(`Rij ${rowNum} Stoel ${seatNum}`);
      }
    });
    document.getElementById("selectedSeats").value = selectedSeats.join(", ");
    const displaySpan = document.getElementById("selectedSeatsDisplay");
    if (displaySpan) {
      displaySpan.textContent = formattedSeats.join(', ');
    }
    console.log("Geselecteerde stoelen:", selectedSeats);
  }

  // Initialiseer de weergave van geselecteerde stoelen.
  updateSelectedSeats();

  // Voeg hover effecten toe voor betere gebruikerservaring.
  stoelen.forEach(function (stoel) {
    stoel.addEventListener("mouseover", function () {
      stoel.style.cursor = "pointer";
    });
    stoel.addEventListener("mouseout", function () {
      stoel.style.cursor = "default";
    });
  });

  // Werk de totaalprijs en ticketinformatie bij.
  function updateTotals() {
    const normaal = parseInt(document.getElementById("aantal-tickets-normaal").value) || 0;
    const kind = parseInt(document.getElementById("aantal-tickets-kind").value) || 0;
    const senior = parseInt(document.getElementById("aantal-tickets-senior").value) || 0;
    const total = normaal * prijzen.normaal + kind * prijzen.kind + senior * prijzen.senior;
    const ticketsText = `Normaal: ${normaal}, Kind: ${kind}, Senior: ${senior}`;
    document.querySelector('.controll-tickets').textContent = `Tickets: ${ticketsText}`;
    document.querySelector('.controll-tickets-price').textContent = `Totaal: €${total.toFixed(2).replace('.', ',')}`;
  }

  // Update totaalprijs wanneer het aantal tickets verandert.
  ticketSelects.forEach(function (select) {
    select.addEventListener("change", function () {
      updateTotals();
    });
  });

  // Initialiseer de totaalprijsweergave.
  updateTotals();
});
