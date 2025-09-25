document.addEventListener("DOMContentLoaded", function () {
  const stoelen = document.querySelector(".chair");

  stoelen.addEventListener("click", function () {
    stoelen.classList.toggle("active");
  });
});
