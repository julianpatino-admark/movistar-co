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
  new Splide($OfferCarrousel, {
    perPage: 1,
    autoWidth: true,
    arrows: false,
    rewind: true,
    mediaQuery: "min",
    breakpoints: {
      768: {
        perPage: 2,
        arrows: true,
      },
      1201: {
        perPage: 3,
      },
      1401: {
        perPage: 4,
      },
    },
  }).mount();
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
