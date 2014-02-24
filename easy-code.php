<?php
/*
Plugin Name: Easy Codes
Description: Manager to create and use shortcodes easily
Version: 1.0.0
*/

function easycode_register_js() {
	// wp_register_script( 'tinymceEasyCode', plugins_url('/js/tinymce.lchshortcodes.js', __FILE__));
	// wp_enqueue_script('tinymceEasyCode');
}
add_action( 'admin_init','easycode_register_js');

/* Init TinyMCE Button */
if ( ! function_exists('add_lch_rich_plugin')) :
    function add_lch_rich_plugin( $plugin_array ) {
        $plugin_array['lchShortcodes'] = plugins_url('easy-code/js/tinymce.lchshortcodes.js');
        return $plugin_array;
    }
endif; 

if ( ! function_exists('register_lch_rich_button')) :
    function register_lch_rich_button( $buttons ) {
        array_push( $buttons, "|", 'easy_code_button' );
        return $buttons;
    }
endif; 

if (function_exists('add_lch_rich_plugin') && function_exists('register_lch_rich_button')) :
    if (!function_exists('lch_shortcode_tinymce')) {
        function lch_shortcode_tinymce() {
            if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') )
                return;

            if ( get_user_option('rich_editing') == 'true' )
            {
                add_filter( 'mce_external_plugins', 'add_lch_rich_plugin' );
                add_filter( 'mce_buttons', 'register_lch_rich_button' );
            }
        }
        add_action('init', 'lch_shortcode_tinymce');
    }
endif;


if ( ! function_exists('get_all_shortcode_forge')) :
function get_all_shortcode_forge(){ 
    require_once( __DIR__.'/class/shortcodes.class.php' );

    $res = null;
    $forges = EasyCode::get_all_forge();
    foreach ($forges as $forge) {
    	$res[] = array(
    			'title' => $forge->get_title(),
    			'name'	=> $forge->get_name(),
    			'is_immediat' => $forge->is_immediat(),
    			'shortcode' => $forge->get_shortcode()
    		);
    }

    $res = json_encode($res);
    header('Content-type: text/json');
    die($res);
}  

// creating Ajax call for WordPress  
add_action( 'wp_ajax_nopriv_get_all_shortcode_forge', 'get_all_shortcode_forge' );  
add_action( 'wp_ajax_get_all_shortcode_forge', 'get_all_shortcode_forge' );  
endif;

if ( ! function_exists('create_easy_code')) :
function create_easy_code($name, $title, $fields = null, $callback) {	
	EasyCode::forge($name, $title, $fields, $callback);
}
endif;

require_once( __DIR__.'/class/shortcodes.class.php' );


// function avis($atts, $content = null ) {
   
//    	$html = "---------------------<br>";
//    	$html .= $content;
//     $html .= "--------------------<br>";

//     return $html;
// }

// function avis_popup($atts, $content = null ) {
   	
//    	extract(shortcode_atts(array(
//                     "exemple_field" => '640',
//                     "exemple_field2" => '480',
//                     "exemple_field3" => ''
//                     ), $atts));

//    	$html = '<br>'.$exemple_field.'<br>';
//    	$html .= $exemple_field2.'<br>';
//    	$html .= $exemple_field3.'<br>';

//     return $html;
// }

// create_easy_code('avis_expert', "avis d'expert", null, 'avis');

// $fields = array(
//         'exemple_field' => array(
//             'type' => 'text',
//             'libelle' => 'libelle exemple',
//             'help' => 'help exemple',
//             'placeholder' => '',
//             'required' => true,
//             'default' => ''),
//         'exemple_field2' => array(
//             'type' => 'text',
//             'libelle' => 'libelle exemple',
//             'help' => 'help exemple',
//             'placeholder' => '',
//             'required' => true,
//             'default' => ''),
//         'exemple_field3' => array(
//             'type' => 'text',
//             'libelle' => 'libelle exemple',
//             'help' => 'help exemple',
//             'placeholder' => '',
//             'required' => true,
//             'default' => ''),
//         );

// create_easy_code('avis_expert_popup', "avis d'expert Popup", $fields, 'avis_popup');
