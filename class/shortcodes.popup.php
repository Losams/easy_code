<?php 
$absolute_path = __FILE__;
$path_to_file = explode( 'wp-content', $absolute_path );
$path_to_wp = $path_to_file[0];

// Access WordPress
require_once( $path_to_wp . '/wp-load.php' );

$popup = trim( $_GET['popup'] );

$shortcode = EasyCode::forge($popup);

?>
<div class="form-wrap" id="custom_form_shortcode">
    <h3><?php $shortcode->showTitle(); ?></h3>
    
    <form class="validate" method="post" data-prototype="<?php $shortcode->showPrototype(); ?>" id="form_shortcode">
        
        <?php $shortcode->showFieldsPopup(); ?>
       
        <a href="#" class="button button-large" id="insert_shortcode"><?php _e('Insérer Shortcode'); ?></a>
    </form>
</div>
<script type="text/javascript" src="<?php echo plugins_url('easy-code/js/shortcodes.popup.js'); ?>"></script>
