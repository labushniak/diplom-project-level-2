<?php
class Output
{
    public static function errors($errors =[])
    {
        $output = '';
        if($errors){
            foreach ($errors as $error){
                $output .= "<li>" . $error . "</li>";
            }
            $output = '<div class="alert alert-danger"><ul>' . $output . '</ul></div>';
            
            return $output;
        }

        return '';
    }

    public static function message ($session, $type)
    {
        if($session){
            $session = "<div class=\"alert alert-{$type}\">" . $session . "</div>";
            return $session;
        }

        return '';
    }

}