document.addEventListener("DOMContentLoaded", function () {
  const stoelen = document.querySelectorAll(".chair");

  stoelen.forEach(function (stoel) {
    stoel.addEventListener("click", function () {
      stoel.classList.toggle("active");
      console.log("Stoel geklikt:", stoel.id);
      updateSelectedSeats();
    });
  });

  function updateSelectedSeats() {
    const selectedSeats = [];
    stoelen.forEach(function (stoel) {
      if (stoel.classList.contains("active")) {
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
