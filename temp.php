<?php
add_shortcode( 'augcat_form', 'augcat_form_print' );

function augcat_form_mailer( $atts ) {
    $data = shortcode_atts( [
        name => 'deafault'
    ], 
    $atts );
    $data = 'dfdsfsd';
}
?>