export default {
    plugins: {
        '@fullhuman/postcss-purgecss': {
            content: [
                './resources/views/**/*.blade.php',
                './resources/js/**/*.js',
            ],
            safelist: {
            },
            defaultExtractor: content => content.match(/[\w-/:]+(?<!:)/g) || []
        }
    }
}