const init = () => {
  /*
  Redirect page to thankyou page after success registration
   */

  document.querySelectorAll("[data-toggle=form-simple]:not(#whatsapp-c2c-form)").forEach((el) => {
    $(el).on("form-finished", (ev, data) => {
      const { origin, search, hash } = window.location;
      if(data.status === true) window.location.href = `${origin}/gracias${search}${hash}`;
    });
  });

  document.getElementById("whatsapp-c2c-form").addEventListener("submit", e => {
    e.preventDefault();
    $(e.currentTarget).on("form-finished", (ev, data) => {
      if(data.status === true) window.location.href = 'https://api.whatsapp.com/send/?phone=573009122062&text=Hola%20quiero%20información%20sobre%20sus%20productos&type=phone_number&app_absent=0';
    });
  });
};

export default {
  init
}