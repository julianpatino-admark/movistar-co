import "bootstrap/js/dist/modal.js";

let idleTime = 0;
let idleInterval;
const $retencionModal = document.getElementById("modal-retencion");

function timerIncrement() {
  idleTime = idleTime + 1;
  if (idleTime > 1) {
    $($retencionModal).modal("show");
    clearInterval(idleInterval);
  }
}


$(".modal").each(function () {
  $(this).modal();
});

document.querySelectorAll(".modal").forEach((el) => {
  if (el.id !== "modal-retencion") $(el).modal();
});

const a = window.location.toString();

if (!a.includes("gracias")) {
  // Increment the idle time counter every minute.
  idleInterval = setInterval(timerIncrement, 10500); // 1 minute

  // Zero the idle timer on mouse movement.
  document.addEventListener("mousemove", (e) => (idleTime = 0));

  document.addEventListener("keypress", (e) => (idleTime = 0));

  $($retencionModal).on("show.bs.modal", function (event) {
    const $retencionForm = $retencionModal.querySelector("form");
    $retencionForm.dataset.layerPage = "/c2c/retencion/conversion";
  });
}
