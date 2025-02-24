<?php
class FormSanitizer {
    // clean the string if user goes crazy tyoubg
    public static function sanitizeFormString($inputText) {
        // remove html tags
        $inputText = strip_tags($inputText);
        // remove whitespace
        $inputText = str_replace(" ", "", $inputText); 
        // lowercase all character
        $inputText = strtolower($inputText);
        //upper case first character
        $inputText= ucfirst($inputText);
        return $inputText;
    }

    public static function sanitizeFormUsername($inputText) {
        $inputText = strip_tags($inputText);
        $inputText = str_replace(" ", "", $inputText); 
        return $inputText;
    }

    public static function sanitizeFormPassword($inputText) {
        $inputText = strip_tags($inputText);
        return $inputText;
    }

    public static function sanitizeFormEmail($inputText) {
        $inputText = strip_tags($inputText);
        $inputText = str_replace(" ", "", $inputText); 
        return $inputText;
    }


}
?>