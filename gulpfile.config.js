var gutil = require("gulp-util");
var versionLanding = gutil.env.version;
var versionIndex = versionLanding === "generica" ? "index" : versionLanding;

var constants = {
  versionLanding: "generica",

  versions: ["generica", "movil"],

  versionIndex: function () {
    return this.versionLanding === "generica" ? "index" : this.versionLanding;
  },

  default: {
    host: "https://movistar.test",
    versionLanding: "generica",
  },
};

var plugins = {
  copy: {
    config: {
      dest: "./",
    },
  },

  delete: {
    vendor: ["./resources/views/vendor/"],

    cache: [
      "./storage/framework/views/*.php",
      "./storage/framework/sessions/*",
      "./storage/framework/testing/*",
      "./storage/framework/cache/*",
    ],
  },

  sass: {
    src: "./css/sass/*.scss",

    dest: "./css/",

    options: {
      outputStyle: "compressed",
    },
  },

  replace: [],

  purge: {
    /**
     * Tiempo que se retrasa la finalización de la tarea para evitar tener
     * que exportar 2 veces css para que se apliquen los cambios
     */
    delay: 50,

    /**
     * Debe ser un array.
     * Añadir la cadena {versionLanding} para que se se sustituya por el css correspondiente definido en la constante versions.
     * ej: "./css/{versionLanding}.css"
     */
    src: ["./css/generica.css", "./css/movil.css"],

    dest: "./css/purged/",

    content: {
      default: [
        "./resources/views/components/**/*.php",
        "./resources/views/dev/tracking/{versionLanding}.blade.php",
        "./resources/views/dev/partials/id_version/{versionLanding}/**/*.php",
        "./resources/views/dev/partials/components/**/*.php",
        "./resources/views/dev/partials/layouts/**/*.php",
        "./js/dist/{versionLanding}.js",
      ],
    },

    safelist: [
      "modal",
      "in",
      "loading",
      "fade",
      "modal-dialog",
      "modal-open",
      "modal-backdrop",
      "dropdown",
      "open",
      "close",
      "error",
      "loading",
      "collapsing",
      "carousel",
      "carousel-item",
      "carousel-item-next",
      "carousel-item-right",
      "carousel-item-left",
      /^cc-/,
      /^carousel-/,
      "autocomplete-results",
    ],
  },

  inline: {
    folders: {
      src: "./resources/views/dev/",

      folders: [
        "tracking",
        "tracking/movil",
        "tracking/duo-fibra",
        "tracking/trio-fibra",
        "tracking/aviso-legal",
        "tracking/privacy",
        "tracking/privacidad-basica",
        "tracking/cookies",
        "tracking/errors",
        "tracking/gracias",
      ],

      dest: "./resources/views/vendor/",
    },
  },

  /**
   * Bloquear el acceso a tracking y AMP en minify para que no pise el contenido
   */
  minify: {
    src: [
      "./resources/views/dev/**/*.php",
      "!./resources/views/dev/tracking/**/*.php",
    ],

    dest: "./resources/views/vendor/",

    options: {
      collapseWhitespace: true,
    },
  },

  watch: {
    css: ["./css/purged/*.css"],

    sass: ["./css/sass/**/*.scss"],

    js: ["./js/dev/**/*.js"],

    views: [
      "./resources/views/components/**/*.php",
      "./resources/views/dev/**/*.php",
    ],
  },
};

module.exports.constants = constants;
module.exports.plugins = plugins;
