<script type="text/javascript">

    var jsToLoad = ['js/dist/generica.bundle.js?v={js_version}'];

    function attachJsOnLoad() {
        for (var i = 0; i < jsToLoad.length; i++) {
            var element = document.createElement("script");
            element.src = jsToLoad[i];
            document.body.appendChild(element);
        }
    }

    function initScripts() {
        if (window.addEventListener) {
            window.addEventListener("load", attachJsOnLoad, false);
        } else if (window.attachEvent) {
            window.attachEvent("onload", attachJsOnLoad);
        } else {
            window.onload = attachJsOnLoad;
        }
    }

    initScripts();
</script>
