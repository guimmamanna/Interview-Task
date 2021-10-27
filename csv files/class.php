<?php
class CropCodeName{
    public $crop_code;
    public $crop_name;
    function __construct ($code,$code_name)
    {
        $this -> crop_code = $code;
        $this -> crop_name = $code_name;
    }
}
?>