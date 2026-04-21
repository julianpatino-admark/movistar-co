import Splide from "@splidejs/splide";

const initSplide = (id, options) => {
  const element = document.getElementById(id);
  if(!element) return;

  const config = typeof options === 'function' ? options(element) : options;
  new Splide(element, config).mount();
};

const initCarousels = () => {
  // Banner Carousel
  initSplide("carouselBanner", (el) => ({
    type: "loop",
    perPage: 1,
    arrows: false,
    start: parseInt(el.dataset.startOn || /* istanbul ignore next */ 0, 10)
  }))

  // Offer Carrousel Fibra
  initSplide("offert-carrousel-fibra", {
    perPage: 1,
    autoWidth: true,
    arrows: false,
    rewind: true,
    mediaQuery: "min",
    breakpoints: {
      768: { perPage: 2, arrows: true },
      1200: { perPage: 3, arrows: false }
    }
  })

  // Offer Carrousel
  initSplide("offer-carrousel", {
    perPage: 1,
    autoWidth: false,
    arrows: false,
    rewind: true,
    mediaQuery: "min",
    breakpoints: {
      768: { perPage: 2 },
      1201: { perPage: 3 },
      1401: { perPage: 4 },
    },
  })
  
  // Elegi Apps
  
  initSplide("elegiApps", {
    type: "slide",
    arrows: false,
    pagination: true,
    perPage: 1,
    mediaQuery: "min",
    breakpoints: {
      768: { autoWidth: true, pagination: false, perPage: 3 },
    },
  });

  // Services Carousel
  initSplide("servicesCarousel", {
    type: "slide",
    arrows: false,
    pagination: true,
    perPage: 1,
    mediaQuery: "min",
    breakpoints: {
      768: { autoWidth: true, pagination: false, perPage: 2 },
    },
  });

  // Offer Carrousel Bogota
  initSplide("offert-carrousel-bogota-fibra", {
    type: "slide",
    arrows: false,
    pagination: true,
    perPage: 1,
    mediaQuery: "min",
    breakpoints: {
      768: { autoWidth: true, pagination: false, perPage: 2 },
    },
  });
}

const initSingleSelector = (container) => {
  // Elementos del DOM
  const listaOtts = container.querySelectorAll('.package-included');
  const button = container.closest('.card-offer_wrapper')?.querySelector('.btn-flex.btn-carousel');
  const errorMsg = container.querySelector('.error-message');

  let hasSelection = false;

  /* istanbul ignore next */
  if(!button || listaOtts.length === 0) return;

  button.classList.add("disabled");

  const handleSelection = (e) => {
    listaOtts.forEach(ele => ele.classList.remove('selected'));
    e.currentTarget.classList.add('selected');
    hasSelection = true;

    if(errorMsg) errorMsg.style.display = 'none';
    button.classList.remove('disabled');
  };

  const handleSubmit = (e) => {
    if(!hasSelection) {
      e.preventDefault();
      e.stopPropagation();
      e.stopImmediatePropagation();

      if(errorMsg) {
        errorMsg.style.display = 'block';
        errorMsg.textContent = 'Por favor, selecciona una opción antes de continuar.';
      }
    }
  }

  listaOtts.forEach(service => service.addEventListener('click', handleSelection));
  button.addEventListener('click', handleSubmit, true);
};

const selectOtts = () => {
  const packageList = document.querySelectorAll('.packages-list');

  packageList.forEach(container => initSingleSelector(container));
}

export { initCarousels, selectOtts };