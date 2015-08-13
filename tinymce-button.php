<?php

/*Hooks your functions into the correct filters*/
function mdc_add_mce_button() {
        if ( !current_user_can( 'edit_posts' ) && !current_user_can( 'edit_pages' ) ) {
                return;
        }
        if ( 'true' == get_user_option( 'rich_editing' ) ) {
                add_filter( 'mce_external_plugins', 'mdc_add_tinymce_plugin' );
                add_filter( 'mce_buttons', 'mdc_register_mce_button' );
        }
}
add_action('admin_head', 'mdc_add_mce_button');
 
/*Declare script for new button*/
function mdc_add_tinymce_plugin( $plugin_array ) {
        $plugin_array['my_mce_button'] = plugins_url('/js/tinymce-plugin.js',__FILE__);
        return $plugin_array;
}
 
/*Register new button in the editor*/
function mdc_register_mce_button( $buttons ) {
        array_push( $buttons, 'my_mce_button' );
        return $buttons;
}
