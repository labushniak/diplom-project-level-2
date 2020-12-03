<?php
require_once 'init.php';

$user = new User;

if(!$user->isLoggedIn()){
    Redirect::to('login.php');
} else {
    if ($user->hasPermissions('admin')){
        
        $anotherUser = new User(Input::get('id'));
        
        $anotherUser->delete();

        Session::flash('success', 'Профиль удален');
        Redirect::to('/users/index.php');
    } else {
        Session::flash('danger', 'Ошибка при удалении профиля');
        Redirect::to('/users/index.php');
    }
}
?>