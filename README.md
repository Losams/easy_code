Easy Code Plugin
================

Easy Code is a Wordpress extension to manage shortcode easily.

Usage
-----

Easy code give you one function to generate shortcode, add it to tinyMCE, link it to callback function.

>create\_easy\_code($name, $title, $fields, $callback);

* $name : ref id of your shortcode, this is used to get the shortcode instance. Unique
* $title : Title used on WysiWyg
* $fields : fields ask to user when they add shortcode (see below for formating)
* $callback : Name of the function you want use for displaying your shortcode.

 
### $fields ###

    $fields = array(
        'exemple_field' => array(
            'type' => 'text',
            'libelle' => 'libelle exemple',
            'help' => 'help exemple',
            'placeholder' => '',
            'required' => true,
            'default' => ''),
        'exemple_field2' => array(
            'type' => 'text',
            'libelle' => 'libelle exemple',
            'help' => 'help exemple',
            'placeholder' => '',
            'required' => true,
            'default' => ''),
    );

### $callback ###


function function\_name($atts, $content = null ) {   
    extract(shortcode\_atts(array(
        "exemple\_field" => 'default value on my var',
        "exemple\_field2" => 'default value on my var'
        ), $atts));

    $html = $exemple\_field;
    $html .= $exemple\_field2;

    return $html;
}

Remember to use do_shortcode($content) is you have multi-level imbrication.
