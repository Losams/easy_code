<?php



class Easy_Code_Class 
{
    protected $_name;

    private $_shortcode;
    private $_fields;
    private $_title;
    private $_callback;

    public $output;
    
    protected static $_easycode = array();

    public static function get_all_forge() {
        return static::$_easycode;
    }

    public static function forge($name, $title = null, $fields = null, $callback = null) {
        if (isset(static::$_easycode[$name])) {
            return static::$_easycode[$name];
        }
        static::$_easycode[$name] = new static($name, $title, $fields, $callback);
        return static::$_easycode[$name];
    }

    public function __construct($name, $title, $fields = null, $callback =null) {
        $this->_title       = $title;
        $this->_fields      = $fields;
        $this->_name        = $name;
        $this->_callback    = $callback;

        if (empty($fields)) {
            $this->_shortcode = "[".$name."][/".$name."]";
        } else {
            $this->_shortcode = null;
            // $output_fields = null;
            // foreach ($fields as $fieldname => $field) {
            //     $output_fields .= $fieldname."={{".$fieldname."}} ";
            // }
            // $this->_shortcode = "[".$name." ".$output_fields."]";
        }

        add_shortcode($name, $callback);
    }

    public function is_immediat() {
        if ($this->_fields == null) {
            return true;
        }
        return false;
    }

    public function get_name() {
        return $this->_name;
    }

    public function get_title() {
        return $this->_title;
    }

    public function get_shortcode() {
        return $this->_shortcode;
    }

    public function get_fields() {
        return $this->_fields;
    }

    public function check_fields_files() {
        foreach ((array) $this->_fields as $key => $field) {
            if ($field['type'] == 'filepicker') {
                $field['type'] = 'textbox';
                $field['id'] = $field['name'];
                $field['style'] = '';
                $field['disabled'] = 'disabled';

                $this->_fields[$key] = $field;

                $filepicker = array(
                    'type' => 'button',
                    'name' => 'select-image-'.$field['name'],
                    'text' => 'Pick file',
                    'onclick' => "__ function() { window.mb = window.mb || {}; window.mb.frame = wp.media({ frame: 'post', state: 'insert', library : { type : 'image' }, multiple: false }); window.mb.frame.on('insert', function() { var json = window.mb.frame.state().get('selection').first().toJSON(); if (0 > json.url.length) { return; } document.getElementById('".$field['id']."').value = json.id; }); window.mb.frame.open(); } __"
                );
                
                // Add filepicker field after
                array_splice( $this->_fields, $key+1, 0, array($filepicker) );
            }
        }
    }
}

?>