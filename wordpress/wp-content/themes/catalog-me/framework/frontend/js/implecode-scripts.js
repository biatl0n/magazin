var resizeTimer;
jQuery( window ).resize( function () {
    clearTimeout( resizeTimer );
    resizeTimer = setTimeout( function () {
        jQuery( "li.current-menu-item" ).closest( "li.menu-item-has-children" ).addClass( 'current-menu-parent' );
        if ( !is_mobile_theme() ) {
            show_main_menu();
            jQuery( "li.menu-item > a" ).focus( function () {
                if ( !jQuery( this ).parents( 'ul.sub-menu' ).length ) {
                    jQuery( "#site-navigation ul.sub-menu" ).hide();
                } else if ( !jQuery( this ).parent( "li" ).find( 'ul.sub-menu' ).length ) {
                    jQuery( this ).parents( "ul.sub-menu" ).eq( 0 ).find( "ul.sub-menu" ).hide();
                }
                jQuery( this ).parents( "ul.sub-menu" ).show();
                jQuery( this ).parent( "li.menu-item" ).find( "> ul.sub-menu" ).show();
            } );
            jQuery( document ).mouseup( function ( e )
            {
                var container = jQuery( "#site-navigation ul.sub-menu" );

                if ( !container.is( e.target ) // if the target of the click isn't the container...
                    && container.has( e.target ).length === 0 ) // ... nor a descendant of the container
                {
                    container.hide();
                }
            } );
        } else {
            jQuery( "#masthead button.responsive-menu-toggle" ).click( function () {
                toggle_main_menu();
            } );
            jQuery( '.fixed-box' ).bind( 'touch', function () {
                jQuery( 'html' ).css( "overflow", "hidden" );
            } );
            jQuery( "body" ).click( function ( e ) {
                var container = jQuery( "#masthead" );
                if ( !container.is( e.target ) && container.has( e.target ).length === 0 ) {
                    if (is_mobile_theme()) {
                    hide_main_menu();
                }
                }
            } );
            jQuery( "body" ).on( "swiperight", function () {
                show_main_menu();
            } );
            jQuery( "body" ).on( "swipeleft", function () {
                hide_main_menu();
            } );
        }

        /* Drop table */
        jQuery( "h2.drops-name" ).next( "table" ).children( "tbody" ).hide();
        jQuery( "h2.drops-name" ).click( function () {
            jQuery( "h2.drops-name" ).removeClass( "open" );
            jQuery( this ).addClass( "open" );
            jQuery( "table.drops-table" ).removeClass( "open" );
            jQuery( this ).next( "table" ).addClass( "open" );
            jQuery( "h2.drops-name" ).next( "table" ).children( "tbody" ).hide();
            jQuery( this ).next( "table" ).children( "tbody" ).show();
            jQuery( 'html, body' ).animate( {
                scrollTop: jQuery( this ).offset().top
            }, 1000 );
        } );
    }, 250 );
} ).trigger( 'resize' );

function toggle_main_menu() {
    jQuery( "#masthead .menu" ).toggle( "slide",
        function () {
            if ( jQuery( "#masthead .menu" ).is( ":hidden" ) ) {
                jQuery( 'html' ).css( "overflow", "auto" );
                jQuery( "#ic_overlay" ).hide();
            } else {
                jQuery( 'html' ).css( "overflow", "hidden" );
                jQuery( "#ic_overlay" ).show();
            }
        } );
}

function show_main_menu() {
    jQuery( "#masthead .menu" ).show( "slide", function () {
        if ( is_mobile_theme() ) {
            jQuery( 'html' ).css( "overflow", "hidden" );
            jQuery( "#ic_overlay" ).show();
        }
    } );
}

function hide_main_menu() {
    jQuery( "#masthead .menu" ).hide( "slide", function () {
        jQuery( 'html' ).css( "overflow", "auto" );
        jQuery( "#ic_overlay" ).hide();
    } );
}

function is_mobile_theme() {
    if ( jQuery( "#masthead" ).css( "position" ) === "fixed" ) {
        return true;
    }
    return false;
}