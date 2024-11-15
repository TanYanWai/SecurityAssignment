<?php
class SecurityUtils {
    public static function sanitize_input($data) {
        $data = trim($data);
        $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
        return $data;
    }
    
    public static function sanitize_output($data) {
        return htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    }
}
?> 