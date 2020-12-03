<?php
require_once 'init.php';

$user = new User;

if(!$user->isLoggedIn() && !$user->hasPermissions('admin')){
    Redirect::to('login.php');
} else {
    $anotherUser = new User(Input::get('id'));
    
    if ($anotherUser->data()->group_id == 1)
    {
        $group_id = 2;
        $message = "Профиль назначен новым администратором";
    } else {
        $group_id = 1;
        $message = "Профиль разжалован";
    }
    $anotherUser->update(['group_id' => $group_id]);

    Session::flash('success', $message);
    Redirect::to('/users/index.php');
}
?>