(function( $ ) {
    'use strict';

    $(document.body).ready(function () {
        $('.widgets-holder-wrap').on( 'focus', '.cbfcdatepicker', function(e) {
            $( this ).datepicker({ dateFormat: 'mm/dd/yy' });
        });
    });

})( jQuery );