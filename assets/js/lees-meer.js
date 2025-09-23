 function openModal() {
    document.getElementById("overlay").style.display = "flex";
  }

  function closeModal() {
    document.getElementById("overlay").style.display = "none";
  }

  // Optional: close modal if user clicks outside the modal box
  window.onclick = function(event) {
    let overlay = document.getElementById("overlay");
    if (event.target === overlay) {
      overlay.style.display = "none";
    }
  }