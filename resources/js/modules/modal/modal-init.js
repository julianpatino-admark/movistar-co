import "bootstrap/js/dist/modal.js";

// Initialize dialogs without showing them; Bootstrap owns focus, Escape and backdrop handling.
document.querySelectorAll(".modal").forEach(el => $(el).modal({ show: false }));

const retention = document.getElementById("modal-retencion");
if (retention) {
  const delay = 21000;
  let timer;
  let shown = false;

  const cancel = () => clearTimeout(timer);
  const schedule = () => {
    cancel();
    if (shown || document.hidden || document.querySelector(".modal.show")) return;
    timer = setTimeout(() => {
      if (document.hidden || document.querySelector(".modal.show")) return;
      $(retention).modal("show");
    }, delay);
  };

  ["pointermove", "keydown", "touchstart", "scroll"].forEach(event => {
    document.addEventListener(event, schedule, { passive: true });
  });
  document.addEventListener("visibilitychange", schedule);
  $(document).on("show.bs.modal", ".modal", cancel);
  $(document).on("hidden.bs.modal", ".modal", schedule);
  $(retention).on("show.bs.modal", () => {
    shown = true;
    cancel();
    retention.querySelector("form").dataset.layerPage = "/c2c/retencion/conversion";
  });
  schedule();
}
