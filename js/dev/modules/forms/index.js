const init = () => {
  /*
  Redirect page to thankyou page after success registration
   */

  document.querySelectorAll("[data-toggle=form-simple]").forEach((el) => {
    $(el).on("form-finished", (ev, data) => {
      const { origin, search, hash } = window.location;
      if(data === true) {
        window.location.href = `${origin}/gracias${search}${hash}`;
      }
    });
  });
}

export default {
  init
}