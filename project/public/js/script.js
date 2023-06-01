// custom js
const checkbox = document.getElementById("switcher");
const contentDisponible = document.getElementById("disponible");
const contentReserve = document.getElementById("reserve");

checkbox.addEventListener("change", function() {
  if (checkbox.checked) {
    console.log("Disponible");
    contentDisponible.style.display = "flex";
    contentReserve.style.display = "none";

  } else {
    console.log("Reservé");
    contentDisponible.style.display = "none";
    contentReserve.style.display = "flex";
  }
});