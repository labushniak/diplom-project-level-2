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

    public static function links($links =[], $id = null)
    {
        $result = '';
        foreach ($links as $link){
            switch($link){
                case ('logout.php'):
                    $result .= "<li class=\"nav-item\"><a href=\"{$link}\" class=\"nav-link\">Выйти</a></li>";
                break;

                case ('/users/edit.php'):
                    $result .= "<li class=\"nav-item\"><a href=\"{$link}?id={$id}\" class=\"nav-link\">Изменить профиль</a></li>";
                break;

                case ('login.php'):
                    $result .= "<li class=\"nav-item\"><a href=\"{$link}\" class=\"nav-link\">Войти</a></li>";
                break;

                case ('register.php'):
                    $result .= "<li class=\"nav-item\"><a href=\"{$link}\" class=\"nav-link\">Регистрация</a></li>";
                break;
            }
        }

        return $result;
    }

    public static function users_list($users =[])
    {
        if($users){
            $list = "";
            foreach($users as $user){
                $list .= "<tr>
                        <td>{$user[0]}</td>
                        <td><a href=\"user_profile.php?id={$user[0]}\">{$user[1]}</a></td>
                        <td>{$user[2]}</td>
                        <td>{$user[3]}</td>
                    </tr>";
                        
            }
        }

        return $list;
    }

}