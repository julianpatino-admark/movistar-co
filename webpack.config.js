const path = require('path');
const webpack = require('webpack');

module.exports = {

    entry: {
        "generica" : [
            "./js/dev/index.js"
        ]
    },

    output: {
        path: path.resolve(__dirname, "./js/dist/"),
        filename: "[name].bundle.js",
        environment : {
            arrowFunction : false
        }
    },

    resolve: {

        modules: [
            path.resolve(__dirname),
            "node_modules"
        ]

    },

    plugins : [
        new webpack.ProvidePlugin({
            $: 'jquery',
            jQuery: 'jquery'
        })
    ],

    optimization: {
        minimize: true
    },

    module: {
        rules: [
            {
                test: /\.js$/,
                exclude: /node_modules/,
                use: {
                    loader: 'babel-loader',
                    options: {
                        presets: [
                            [
                                "@babel/preset-env",
                                {
                                    "targets": {
                                        "edge": "17",
                                        "firefox": "60",
                                        "chrome": "67",
                                        "safari": "11.1",
                                        "ie": "11"
                                    }
                                }
                            ]
                        ],
                        plugins: [
                            "@babel/plugin-proposal-class-properties",
                            "@babel/plugin-transform-arrow-functions",
                            "@babel/plugin-transform-runtime",
                            [
                                "@babel/plugin-proposal-decorators",
                                {
                                    "decoratorsBeforeExport":true
                                }
                            ]
                        ]
                    }
                }
            }
        ]
    }

};