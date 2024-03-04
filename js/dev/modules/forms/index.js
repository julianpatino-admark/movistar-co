const init = () => {
  /*
  Redirect page to thankyou page after success registration
   */

  document
    .querySelectorAll("[data-toggle=form-simple]:not(#whatsapp-c2c-form)")
    .forEach((el) => {
      $(el).on("form-finished", (ev, data) => {
        const { origin, search, hash } = window.location;
        if (data.status === true)
          window.location.href = `${origin}/gracias${search}${hash}`;
      });
    });

  $("#whatsapp-c2c-form").on("form-finished", (_, { status = false }) => {
    if (status === true) {
      const PARAMS = new URLSearchParams ({
        phone: "573009122062",
        text: "Hola quiero información sobre sus productos",
        type: "phone_number",
        app_absent: 0,
      });
      const WPP_URL = new URL(`https://api.whatsapp.com/send`);
      WPP_URL.search = PARAMS;

      window.location.href = WPP_URL.toString();
    }
  });
};

export default {
  init,
};
