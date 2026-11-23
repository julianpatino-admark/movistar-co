import Splide from '@splidejs/splide';

const desktop = window.matchMedia('(min-width: 1200px)').matches;
const wide = window.matchMedia('(min-width: 900px)').matches;
const phone = window.matchMedia('(max-width: 479px)').matches;
const labels = {
    carousel: 'Promociones de Internet', slide: 'Promoción',
    select: 'Selecciona una promoción', pageX: 'Ver promoción %s', slideX: 'Ver promoción %s',
};

export function initFiberLanding() {
    const banners = document.querySelector('[data-fiber-banners]');
    const offers = document.querySelector('[data-fiber-offers]');
    if (banners) {
        new Splide(banners, {
            perPage: 1, arrows: false, rewind: true, start: desktop ? 0 : 1,
            autoplay: false, i18n: labels,
        }).mount();
    }

    if (offers) {
        new Splide(offers, {
            perPage: 1, arrows: false, rewind: true,
            start: wide ? 0 : (phone ? Number(offers.dataset.phoneStart ?? 1) : 1),
            gap: '24px', mediaQuery: 'min',
            breakpoints: {
                480: { gap: '32px' },
                900: { perPage: 2, pagination: false, drag: false },
                1200: { gap: '50px' },
            },
            i18n: { ...labels, carousel: 'Planes de Internet', slide: 'Plan', pageX: 'Ver plan %s', slideX: 'Ver plan %s' },
        }).mount();
    }
}
