import Splide from "@splidejs/splide";

const $BannerCarrousel = document.getElementById("carouselBanner");
if ($BannerCarrousel) {
  const BannerSplide = new Splide($BannerCarrousel, {
    type: "loop",
    perPage: 1,
    arrows: false,
  });

  BannerSplide.mount();
}

const $OfferCarrousel = document.getElementById("offert-carrousel");
if ($OfferCarrousel) {
  const OfferSplide = new Splide($OfferCarrousel, {
    type: "loop",
    autoWidth: true,
    arrows: true,
    breakpoints: {
      480: {
        perPage: 1,
      },
      992: {
        autoWidth: false,
        arrows: false,
        perPage: 2,
      },
    },
  });
  OfferSplide.mount();
}

const $ServicesCarrousel = document.getElementById("servicesCarousel");
if ($ServicesCarrousel) {
  const ServiceSplide = new Splide($ServicesCarrousel, {
    type: "slide",
    arrows: false,
    pagination: true,
    perPage: 1,
    mediaQuery: "min",
    breakpoints: {
      768: {
        autoWidth: true,
        pagination: false,
        perPage: 2,
      },
    },
  });
  ServiceSplide.mount();
}
