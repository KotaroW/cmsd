<?php
if (!defined('ALEXANDER_THE_GREAT')) exit;

abstract class Template {
    private static $template =<<<KOTAROW
<!DOCTYPE html>
<html>


<head>%s</head>


<body>
%s    
</body>


</html>
KOTAROW;

     public static function get_template($template_name) {
         return self::$$template_name;
     }
}
?>
