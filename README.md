#Easy Code Plugin

Advance plugin for wordpress working with tinyMce 4

## Exemple Callback

For immediat : 

    function avis($atts, $content = null ) {
       
        $html = "---------------------<br>";
        $html .= $content;
        $html .= "--------------------<br>";

        return $html;
    }

For popup : 
    
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

## Exemple creation immediat

    create_easy_code('avis_expert', "avis d'expert", null, 'avis');

## Exemple creation popup (with possible fields)

    $fields_lol[] = array(
        'type' => 'label', 
        'text' => 'Just some text.'
    );

    $fields_lol[] = array(
        'type' => 'listbox', 
        'name' => 'align', 
        'label' => 'align', 
        'values' => array(
                array('text' => 'Left', 'value' => 'left'),
                array('text' => 'Right', 'value' => 'right'),
                array('text' => 'Center', 'value' => 'center'),
            )
    );

    $fields_lol[] = array(
        'name' => 'my_image', 
        'type' => 'filepicker', 
        'label' => 'My picture', 
    );

    $fields_lol[] = array(
        'name' => 'input3', 
        'type' => 'checkbox', 
        'label' => 'Checkbox'
    );

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
        
    create_easy_code('azerty', 'fdkdflf fdazerty', $fields_test, 'avis');

The "popup callback" on this exemple don't match with all declared fields, you have to modify some things to make it work !