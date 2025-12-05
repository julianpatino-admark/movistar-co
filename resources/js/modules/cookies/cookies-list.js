var CookiesList = (function () {

    var analytics_id = "UA-132488308-1";

    // Si no hay Google Analytics 4 ponemos el mismo id de Analytics
    var analytics4_id = "XXXXXXXXX";

    var project =  "laravel";

    var get = function () {

        return {

            session: [
                {
                    name: project+"_session",
                    provider: "Admark",
                    expire: "2 horas",
                    info: "Cookie que gestiona la sesión del usuario en la aplicación."
                },
                {
                    name: "XSRF-TOKEN",
                    provider: "Admark",
                    expire: "Session",
                    info: "Esta cookie se utiliza para el envío seguro de formularios."
                },
                {
                    name: "_admcookie",
                    provider: "Admark",
                    expire: "1 año",
                    info: "Permite recordar la configuración de un usuario con respecto a la política de cookies"
                },
                {
                    name: "_admsession",
                    provider: "Admark",
                    expire: "1 año",
                    info: "Permite recordar la configuración de un usuario con respecto a la política de cookies"
                },
                {
                    name: "_admpreferences",
                    provider: "Admark",
                    expire: "1 año",
                    info: "Permite recordar la configuración de un usuario con respecto a la política de cookies"
                },
                {
                    name: "_admanalytics",
                    provider: "Admark",
                    expire: "1 año",
                    info: "Permite recordar la configuración de un usuario con respecto a la política de cookies"
                },
                {
                    name: "_admmarketing",
                    provider: "Admark",
                    expire: "1 año",
                    info: "Permite recordar la configuración de un usuario con respecto a la política de cookies"
                }
            ],

            preferences: [],

            analytics: [

                // Google Analytics
                {
                    name: "_gac_" + analytics_id,
                    provider: "Google",
                    info: "Incluye información de la campaña relativa al usuario. Si has vinculado tus cuentas de Google Analytics y Google Ads, las etiquetas de conversión en sitio web de Google Ads leerán esta cookie, a menos que la inhabilites.",
                    expire: "90 días"
                },
                {
                    name: "_ga_" + analytics4_id,
                    provider: "Google",
                    info: "Incluye información de la campaña relativa al usuario. Si has vinculado tus cuentas de Google Analytics y Google Ads, las etiquetas de conversión en sitio web de Google Ads leerán esta cookie, a menos que la inhabilites.",
                    expire: "90 días"
                },
                {
                    name: "_dc_gtm_" + analytics_id,
                    provider: "Google",
                    info: "Incluye información de la campaña relativa al usuario. Si has vinculado tus cuentas de Google Analytics y Google Ads, las etiquetas de conversión en sitio web de Google Ads leerán esta cookie, a menos que la inhabilites.",
                    expire: "90 días"
                },
                {
                    name: "_ga",
                    provider: "Google",
                    info: "Registra una identificación única que se utiliza para generar datos estadísticos acerca de cómo utiliza el visitante el sitio web.",
                    expire: "2 años"
                },
                {
                    name: "_gid",
                    provider: "Google",
                    info: "Se usa para distinguir a los usuarios.",
                    expire: "24 horas"
                },
                {
                    name: "_gat",
                    provider: "Google",
                    info: "Se usa para limitar el porcentaje de solicitudes. Si se ha implementado Google Analytics mediante Google Tag Manager, esta cookie se llamará _dc_gtm_.",
                    expire: "1 minuto"
                },
                {
                    name: "AMP_TOKEN",
                    provider: "Google",
                    info: "Incluye un token que se puede utilizar para recuperar un ID de cliente del servicio de IDs de cliente de AMP. Otros posibles valores indican inhabilitaciones, solicitudes en curso o errores obtenidos al recuperar un IDs del servicio de IDs de cliente de AMP.",
                    expire: "De 30 segundos a 1 año"
                },
                {
                    name: "__utma",
                    provider: "Google",
                    expire: "2 años a partir de la configuración o actualización",
                    info: "Se usa para distinguir usuarios y sesiones. La cookie se crea cuando se ejecuta la biblioteca de JavaScript y no hay ninguna cookie __utma. La cookie se actualiza cada vez que se envían datos a Google Analytics."
                },
                {
                    name: "__utmt",
                    provider: "Google",
                    expire: "10 minutos",
                    info: "Se usa para limitar el porcentaje de solicitudes."
                },
                {
                    name: "__utmb",
                    provider: "Google",
                    info: "Se usa para determinar nuevas sesiones o visitas. La cookie se crea cuando se ejecuta la biblioteca de JavaScript y no hay ninguna cookie __utmb. La cookie se actualiza cada vez que se envían datos a Google Analytics.",
                    expire: "30 minutos a partir de la configuración o actualización"
                },
                {
                    name: "__utmc",
                    provider: "Google",
                    expire: "Sesión",
                    info: "No se usa en ga.js. Se configura para interactuar con urchin.js. Anteriormente, esta cookie actuaba junto con la cookie __utmb para determinar si el usuario estaba en una nueva sesión o visita"
                },
                {
                    name: "__utmz",
                    provider: "Google",
                    expire: "6 meses a partir de la configuración o actualización",
                    info: "Almacena la fuente de tráfico o la campaña que explica cómo ha llegado el usuario al sitio web. La cookie se crea cuando se ejecuta la biblioteca de JavaScript y se actualiza cada vez que se envían datos a Google Analytics."
                },
                {
                    name: "__utmv",
                    provider: "Google",
                    expire: "2 años a partir de la configuración o actualización",
                    info: "Se usa para almacenar datos de variables personalizadas a nivel de visitante. Esta cookie se crea cuando un programador usa el método _setCustomVar con una variable personalizada a nivel de visitante. También se usaba para el método _setVar, que ya no está disponible. La cookie se actualiza cada vez que se envían datos a Google Analytics"
                },


                // EXPERIMENTOS
                {
                    name: "__utmx",
                    provider: "Google",
                    expire: "18 meses",
                    info: "Se usa para determinar la inclusión de un usuario en un experimento."
                },
                {
                    name: "__utmxx",
                    provider: "Google",
                    expire: "18 meses",
                    info: "Se usa para determinar la caducidad de los experimentos en los que se ha incluido a un usuario."
                },

                // OPTIMIZE
                {
                    name: "_gaexp",
                    provider: "Google",
                    expire: "Depende de la duración del experimento, pero suele ser de 90 días",
                    info: "Se utiliza para determinar la inclusión de un usuario en un experimento y la caducidad de los experimentos en los que participa."

                },
                {
                    name: "_opt_awcid",
                    provider: "Google",
                    expire: "24 horas",
                    info: "Se utiliza para las campañas asociadas a IDs de cliente de Google Ads."
                },
                {
                    name: "_opt_awmid",
                    provider: "Google",
                    expire: "24 horas",
                    info: "Se utiliza para las campañas asociadas a IDs de campaña de Google Ads."
                },
                {
                    name: "_opt_awgid",
                    provider: "Google",
                    expire: "24 horas",
                    info: "Se utiliza para las campañas asociadas a IDs de grupo de anuncios de Google Ads."
                },
                {
                    name: "_opt_awkid",
                    provider: "Google",
                    expire: "24 horas",
                    info: "Se utiliza para las campañas asociadas a IDs de criterio de Google Ads."
                },
                {
                    name: "_opt_utmc",
                    provider: "Google",
                    expire: "24 horas",
                    info: "Almacena el último parámetro de consulta utm_campaign."
                },

                // Sacadas de las webs
                {
                    name: "APISID",
                    provider: "Google",
                    expire: "2 años",
                    info: "Utilizada por los servicios de google de analítica."
                },
                {
                    name: "CONSENT",
                    provider: "Google",
                    expire: "20 Años",
                    info: "Utilizada por google para prestar sus servicios de analítica"
                },
                {
                    name: "GTM-XSRF-TOKEN",
                    provider: "Google",
                    expire: "Sesión",
                    info: "Identifica al usuario en Google Tag Manager"
                },
                {
                    name: "HSID",
                    provider: "Google",
                    expire: "1 año",
                    info: "Contiene registros encriptados y firmados de forma digital de la hora de inicio de sesión más reciente y del ID de cuenta de Google de un usuario. La combinación de estas dos cookies nos permite bloquear muchos tipos de ataques como, por ejemplo, intentos de robo del contenido de los formularios que rellenas en páginas web."
                },
                {
                    name: "SID",
                    provider: "Google",
                    expire: "1 año",
                    info: "Contiene registros encriptados y firmados de forma digital de la hora de inicio de sesión más reciente y del ID de cuenta de Google de un usuario. La combinación de estas dos cookies nos permite bloquear muchos tipos de ataques como, por ejemplo, intentos de robo del contenido de los formularios que rellenas en páginas web."
                },


            ],

            marketing: [


                // GOOGLE
                {
                    name: "1P_JAR",
                    provider: "Google",
                    expire: "1 mes",
                    info: "Tiene información sobre como el usuario utiliza la web y los anuncios que el usuario ha visto antes de llegar a la web."
                },
                {
                    name: "ANID",
                    provider: "Google",
                    expire: "1 año",
                    info: "Esta cookie la utiliza google para mostrar anuncios más relevantes."
                },
                {
                    name: "DSID",
                    provider: "Google",
                    expire: "1 semana",
                    info: "Esta cookie la utiliza google para mostrar anuncios más relevantes."
                },
                {
                    name: "IDE",
                    provider: "Google",
                    expire: "1 año",
                    info: "Esta cookie la utiliza google para mostrar anuncios más relevantes."
                },
                {
                    name: "OTZ",
                    provider: "Google",
                    expire: "1 mes",
                    info: "Esta cookie la utiliza google para mostrar anuncios más relevantes."
                },
                {
                    name: "SIDCC",
                    provider: "Google",
                    expire: "1 año",
                    info: "Cookie de seguridad de Google."
                },
                {
                    name: "UULE",
                    provider: "Google",
                    expire: "1 año",
                    info: "Tiene información sobre como el usuario utiliza la web y los anuncios que el usuario ha visto antes de llegar a la web."
                },
                {
                    name: "__Secure-3PAPISID",
                    provider: "Google",
                    expire: "2 años",
                    info: "Tiene información sobre como el usuario utiliza la web y los anuncios que el usuario ha visto antes de llegar a la web."
                },
                {
                    name: "__Secure-3PSID",
                    provider: "Google",
                    expire: "2 años",
                    info: "Tiene información sobre como el usuario utiliza la web y los anuncios que el usuario ha visto antes de llegar a la web."
                },
                {
                    name: "__Secure-APISID",
                    provider: "Google",
                    expire: "2 años",
                    info: "Tiene información sobre como el usuario utiliza la web y los anuncios que el usuario ha visto antes de llegar a la web."
                },
                {
                    name: "__Secure-HSID",
                    provider: "Google",
                    expire: "2 años",
                    info: "Tiene información sobre como el usuario utiliza la web y los anuncios que el usuario ha visto antes de llegar a la web."
                },

                {
                    name: "__Secure-SSID",
                    provider: "Google",
                    expire: "2 años",
                    info: "Tiene información sobre como el usuario utiliza la web y los anuncios que el usuario ha visto antes de llegar a la web."
                },
                {
                    name: "_fbp",
                    provider: "Google",
                    expire: "3 meses",
                    info: "Utilizada por Facebook para proporcionar una serie de productos publicitarios como pujas en tiempo real de terceros anunciantes."
                },
                {
                    name: "_gcl_au",
                    provider: "Google",
                    expire: "1 mes",
                    info: "Utilizada por Google para prestar sus servicios de publicidad."
                }, {
                    name: "_gcl_aw",
                    provider: "Google",
                    expire: "1 mes",
                    info: "Utilizada por Google para prestar sus servicios de publicidad."
                },
                // PINTEREST
                {
                    name: "_pinterest_cm",
                    provider: "Pinterest",
                    expire: "",
                    info: ""
                },
                {
                    name: "_pinterest_ct_rt",
                    provider: "Pinterest",
                    expire: "",
                    info: ""
                },
                {
                    name: "_pinteres_sess",
                    provider: "Pinterest",
                    expire: "",
                    info: ""
                },

                // FACEBOOK
                {
                    name: "fr",
                    provider: "Facebook",
                    info: "Utilizada por Facebook para proporcionar una serie de productos publicitarios como pujas en tiempo real de terceros anunciantes.",
                    expire: "3 meses"
                },
                {
                    name: "c_user",
                    provider: "Facebook",
                    expire: "Depende de si se ha marcado la opción de seguir conectado de Facebook",
                    info: "Identifica a un usuario de Facebook"
                },
                {
                    name: "datr",
                    provider: "Facebook",
                    expire: "1 año",
                    info: "Utilizada por Facebook para proporcionar una serie de productos publicitarios como pujas en tiempo real de terceros anunciantes."
                },
                {
                    name: "sb",
                    provider: "Facebook",
                    expire: "2 años",
                    info: "Utilizada por Facebook para proporcionar una serie de productos publicitarios como pujas en tiempo real de terceros anunciantes."
                },
                {
                    name: "xs",
                    provider: "Facebook",
                    expire: "3 meses",
                    info: "Utilizada por Facebook para proporcionar una serie de productos publicitarios como pujas en tiempo real de terceros anunciantes."
                },

                // MICROSOFT | BING
                {
                    name: "_uetsid",
                    provider: "Bing",
                    info: "Utilizada por Bing para mostrar información relevante en función de las páginas visitadas y hábitos del usuario",
                    expire: "24 horas"
                },
                {
                    name: "_uetvid",
                    provider: "Bing",
                    info: "Utilizada por Bing para mostrar información relevante en función de las páginas visitadas y hábitos del usuario",
                    expire: "24 horas"
                },
                {
                    name: "MUID",
                    provider: "Microsoft",
                    info: "Utilizada ampliamente por Microsoft como identificación única de usuario. La cookie permite el seguimiento del usuario sincronizando la identificación a lo largo de muchos dominios de Microsoft.",
                    expire: "1 año"
                },
                {
                    name: "MUIDB",
                    provider: "Microsoft",
                    expire: "1 año",
                    info: "Contiene información sobre como un usuario utiliza la web y los anuncios que ha visto antes de visitar la web."
                }

            ],

            others: []

        }

    }

    return {
        get: get
    }

})(jQuery);

export default CookiesList;