const NavClose = (function(){

    const init =  function(){

        $('.navbar-collapse').on('click', function(event){

            if(event.target === event.currentTarget){

                $('.navbar-collapse').collapse('hide');

            }

        });

    }

    return {
        init : init
    }

})(jQuery);

export default NavClose;