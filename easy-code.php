<?php
/*
Plugin Name: Easy Code
Description: Creates shortcodes needed
Version: 1.0
*/

// Avoid direct launch of this file
if ( ! defined( 'ABSPATH' ) ) {
        die("Can't load this file directly" );
}
        

class Easy_Shortcodes {
    /**
     * Instanciates class : just hook to the admin_head hook
     */
    function __construct() {
        add_action( 'admin_head', array( $this, 'action_admin_init' ) );
        if( is_admin() ){
            add_action('admin_head', array( $this, 'add_head_shortcode' ) );
        }
    }

    /**
     * Register to add stuff on second line of WYSIWYG
     * Register to load external TinyMCE plugins
     */
    function action_admin_init() {            
        // Styles
        add_filter( 'mce_buttons_2', array( $this, 'filter_mce_button' ) );
        add_filter( 'mce_external_plugins', array( $this, 'filter_mce_plugin' ) );
    }

    function add_head_shortcode(){
        $forges = Easy_Code_Class::get_all_forge();
        foreach ($forges as $forge) {
            $list_shortcodes[] = $forge->get_title();

            $res[$forge->get_title()] = array(
                    'name'  => $forge->get_name(),
                    'is_immediat' => $forge->is_immediat(),
                    'shortcode' => $forge->get_shortcode(),
                    'fields' => $forge->get_fields()
                );
        }
        $res = json_encode($res);
        $list = json_encode($list_shortcodes);

        ?>
            <script type="text/javascript">
                var list_easy_shortcodes = <?php echo $list; ?>;
                var easy_shortcodes = <?php echo $res; ?>;
            </script>
        <?php
    }

    /**
     * Add ou bouton to the TinyMCE editor
     * @param array $buttons the TinyMCE  button collection
     * @return array the buttons array updated
     */
    function filter_mce_button( $buttons ) {                
            array_push( $buttons, 'custom_styles' );
            return $buttons;
    }

    /**
     * Physically load the external plugin js file
     * @param array $plugins all external plugins
     * @return array the external plugin array updated with our plugin
     */
    function filter_mce_plugin( $plugins ) {                
            $plugins['easy_custom_styles'] = plugin_dir_url(__FILE__) . 'buttons/custom_buttons.js';
            return $plugins;
    }
}

if ( ! function_exists('create_easy_code')) :
    function create_easy_code($name, $title, $fields = null, $callback) {   
        Easy_Code_Class::forge($name, $title, $fields, $callback);
    }
endif;

require_once( __DIR__.'/class/easy-code.class.php' );

// Instanciates plugin
$easy_shortcodes = new Easy_Shortcodes();



function avis($atts, $content = null ) {
   
     $html = "---------------------<br>";
     $html .= $content;
    $html .= "--------------------<br>";

    return $html;
}

function avis_popup($atts, $content = null ) {
    
     extract(shortcode_atts(array(
                    "exemple_field" => '640',
                    "exemple_field2" => '480',
                    "exemple_field3" => ''
                    ), $atts));

     $html = '<br>'.$exemple_field.'<br>';
     $html .= $exemple_field2.'<br>';
     $html .= $exemple_field3.'<br>';

    return $html;
}

create_easy_code('avis_expert', "avis d'expert", null, 'avis');

$fields_lol[] = array(
        "type" => 'textbox',
        "name" => 'text',
        "label" => 'Texte',
        "value" => ''
    );

$fields_lol[] = array(
        "type" => 'textbox',
        "name" => 'textlol',
        "label" => 'Texte second',
        "value" => ''
    );
create_easy_code('azerty', 'fdkdflf fdazerty', $fields_lol, 'avis');
