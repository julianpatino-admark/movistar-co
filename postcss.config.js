import purgecss from '@fullhuman/postcss-purgecss';

export default {
    plugins: [
        (purgecss.default || purgecss)({
            content: [
                './resources/views/**/*.blade.php',
                './resources/js/**/*.js',
            ],
            defaultExtractor: content => content.match(/[\w-/:]+(?<!:)/g) || [],
            safelist: {
                standard: [
                    
                ],
                deep: [/^splide/],
            },
        })
    ]
}