<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
 
class MY_Form_validation extends CI_Form_validation
{
    /**
     * Add error
     *
     * Adds a custom error to the form validation array
     *
     * @return  array
     */
    function add_to_error_array($field = '', $message = '')
    {
        if ( ! isset($this->_error_array[$field]))
        {
            $this->_error_array[$field] = $message;
        }
 
        return;
    }
 
    /**
     * Error Array
     *
     * Returns the error messages as an array
     *
     * @return  array
     */
    function error_array()
    {
        if (count($this->_error_array) === 0)
            return FALSE;
        else
            return $this->_error_array;
    }
}
 
/* End of file MY_Form_validation.php */
/* Location: ./application/libraries/MY_Form_validation.php */