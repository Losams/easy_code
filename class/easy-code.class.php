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
            $output_fields = null;
            foreach ($fields as $fieldname => $field) {
                $output_fields .= $fieldname."={{".$fieldname."}} ";
            }
            $this->_shortcode = "[".$name." ".$output_fields."]";
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
}

?>