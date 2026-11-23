// Keep the existing forms, tracking and modal behavior on the redesigned page.
import './landing';
import Splide from '@splidejs/splide';

const offers = document.getElementById('movil-offers');

if (offers) {
    new Splide(offers, {
        perPage: 1,
        arrows: false,
        rewind: true,
        gap: '24px',
        mediaQuery: 'min',
        breakpoints: {
            900: { perPage: 2, pagination: false, drag: false },
            480: { gap: '32px' },
            1200: { gap: '50px' },
        },
        i18n: {
            carousel: 'Planes pospago',
            slide: 'Plan',
            select: 'Selecciona un plan para ver',
            pageX: 'Ver plan %s',
            slideX: 'Ver plan %s',
        },
    }).mount();
}
