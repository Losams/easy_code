<?php



class EasyCode 
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

    /**
     * [preparePopup description]
     * @return [type] [description]
     */
    private function preparePopup()
    {

        $this->output = '';

        foreach ($this->_fields as $name => $field) {

            switch ($field['type']) {
                case 'image' : 
                    $this->output .= $this->fieldImage($name, $field);
                    break;
                case 'select':
                    $this->output .= $this->fieldSelect($name, $field);
                    break;
                case 'textarea':
                    $this->output .= $this->fieldTextarea($name, $field);
                    break;
                case 'email':
                    $this->output .= $this->fieldEmail($name, $field);
                    break;
                case 'checkbox':
                    $this->output .= $this->fieldCheckbox($name, $field);
                    break;
                case 'radio':
                    $this->output .= $this->fieldRadio($name, $field);
                    break;
                case 'text':
                default:
                    $this->output .= $this->fieldText($name, $field);
                    break;
            }

        }

    }

    /**
     * [fieldText description]
     * @param  [type] $name  [description]
     * @param  [type] $field [description]
     * @return [type]        [description]
     */
    private function fieldText($name, $field)
    {
        $text = '';
        
        if (isset($field['required']) && $field['required'] == true) {
            $text .= '<div class="form-field form-required">';
        } else {
            $text .= '<div class="form-field">';
        }

        if (isset($field['libelle'])) {
            $text .= '<label for="' . $name . '">' . $field['libelle'] .'</label>';
        }

        if (isset($field['required']) && ($field['required'] == true)) {
            $text .= '<input class="custom_shortcode" type="text" aria-required="true" required="required" value="' . $field['default'] . '" name="'.$name.'" placeholder="'.$field['placeholder'].'" />';
        } else {
            $text .= '<input class="custom_shortcode" type="text" value="' . $field['default'] . '" name="'.$name.'" placeholder="'.$field['placeholder'].'" />';
        }
            
        if (isset($field['help'])) {
            $text .= '<p>' . $field['help'] . '</p>';
        }
            
        $text .= '</div>';

        return $text;
    }

    /**
     * [fieldTextarea description]
     * @param  [type] $name  [description]
     * @param  [type] $field [description]
     * @return [type]        [description]
     */
    private function fieldTextarea($name, $field)
    {

        $textarea = '';

        if (isset($field['required']) && $field['required'] == true) {
            $textarea .= '<div class="form-field form-required">';
        } else {
            $textarea .= '<div class="form-field">';
        }

        if (isset($field['libelle'])) {
            $textarea .= '<label for="' . $name . '">' . $field['libelle'] .'</label>';
        }

        if (isset($field['required']) && ($field['required'] == true)) {
            $textarea .= '<textarea class="custom_shortcode" cols="40" rows="5" aria-required="true" required="required" name="'.$name.'">' . $field['default'] . '</textarea>';
        } else {
            $textarea .= '<textarea class="custom_shortcode" cols="40" rows="5" name="'.$name.'">' . $field['default'] . '</textarea>';
        }
            
        if (isset($field['help'])) {
            $textarea .= '<p>' . $field['help'] . '</p>';
        }

        $textarea .= '</div>';

        return $textarea;
    }

    /**
     * [fieldSelect description]
     * @param  [type] $name  [description]
     * @param  [type] $field [description]
     * @return [type]        [description]
     */
    private function fieldSelect($name, $field)
    {
        $select = '';


        if (isset($field['required']) && $field['required'] == true) {
            $select .= '<div class="form-field form-required">';
        } else {
            $select .= '<div class="form-field">';
        }

        if (isset($field['libelle'])) {
            $select .= '<label for="' . $name . '">' . $field['libelle'] .'</label>';
        }

        if (isset($field['required']) && ($field['required'] == true)) {
            $select .= '<select class="custom_shortcode" aria-required="true" required="required" name="'.$name.'">';
        } else {
            $select .= '<select class="custom_shortcode" name="'.$name.'">';
        }

        foreach ($field['options'] as $value => $option) {
            $select .= '<option value="' . $value .'">' . $option . '</option>';
        }

        $select .= '</select>';
            
        if (isset($field['help'])) {
            $select .= '<p>' . $field['help'] . '</p>';
        }
            
        $select .= '</div>';


        return $select;
    }

    /**
     * [fieldCheckbox description]
     * @param  [type] $name  [description]
     * @param  [type] $field [description]
     * @return [type]        [description]
     */
    private function fieldCheckbox($name, $field)
    {

        return $checkbox;
    }

    /**
     * [fieldEmail description]
     * @param  [type] $name  [description]
     * @param  [type] $field [description]
     * @return [type]        [description]
     */
    private function fieldEmail($name, $field)
    {

        return $email;
    }

    /**
     * [fieldRadio description]
     * @param  [type] $name  [description]
     * @param  [type] $field [description]
     * @return [type]        [description]
     */
    private function fieldRadio($name, $field)
    {   

        return $radio;
    }

    /**
     * [showPopup description]
     * @return [type] [description]
     */
    public function showFieldsPopup()
    {
        $this->preparePopup();
        echo $this->output;
    }

    /**
     * [showTitle description]
     * @return [type] [description]
     */
    public function showTitle()
    {
        echo $this->_title;
    }

    public function showPrototype()
    {
        echo htmlspecialchars($this->_shortcode);
    }

    public function fieldImage($name, $field) 
    {
        
        return $this->output;
    }

}

?>