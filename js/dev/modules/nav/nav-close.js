const NavClose = function(){

    $('.navbar-collapse').on('click', function(event){

        if(event.target === event.currentTarget){

            $('.navbar-collapse').collapse('hide');

        }

    });

}

export default NavClose;