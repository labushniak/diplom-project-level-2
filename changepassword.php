<?php
require_once 'init.php';

$user = new User;


if(!$user->isLoggedIn()){
    Redirect::to('login.php');

} else {
  
  //если id страницы и id залогиненого пользователя равны или админ
  if (Input::get('id') == $user->data()->id || $user->hasPermissions('admin')){
    
    $anotherUser = new User(Input::get('id'));
    
    $link = Output::links(['/users/edit.php', '/logout.php'], $user->data()->id);

    if (Input::exists()){
      if(Token::check(Input::get('token'))){
        
        $validate = new Validate;
        
        $validation = $validate->check($_POST, [
            'current_password' => [ 'required' => true ],
            'new_password' => [ 'required' => true, 'min' => 6],
            'new_password_again' => [ 'required' => true,'min' => 6, 'matches' => 'new_password']
        ]);
          
        if($validation->passed()){
            
            if(password_verify(Input::get('current_password'), $anotherUser->data()->password)){
                $anotherUser->update(['password' => password_hash(Input::get('new_password'), PASSWORD_DEFAULT)], Input::get('id'));
                Session::flash('success', 'Пароль обновлен');
                Redirect::to("changepassword.php?id=" . Input::get("id"));
                exit;
            }
         Session::flash('danger', 'Пароль введен неверно');
            
        } else {
          $errors = Output::errors($validation->errors());

        }
      } 
    }   
  } else {
    Redirect::to('../index.php');
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Profile</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
  <script
  src="https://code.jquery.com/jquery-3.4.1.min.js"
  integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
  crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</head>
<body>
  
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <a class="navbar-brand" href="#">User Management</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item">
            <a class="nav-link" href="/">Главная</a>
          </li>
          <?php if($user->hasPermissions('admin')): ?>
            <li class="nav-item">
              <a class="nav-link" href="/users/index.php">Управление пользователями</a>
            </li>
            <?php endif; ?>
        </ul>

        <ul class="navbar-nav">
        <? echo $link; ?>
        </ul>
      </div>
    </nav>

   <div class="container">
     <div class="row">
       <div class="col-md-8">
         <h1>Изменить пароль</h1>
         <?php echo $errors; ?>
         <? echo Output::message(Session::flash('success'), 'success');?>
         <? echo Output::message(Session::flash('danger'), 'danger');?>

         <ul>
           <li><a href="user_profile.php?id=<?php echo Input::get('id') ?>">Изменить профиль</a></li>
         </ul>
         <form action="" class="form" method="post">
           <div class="form-group">
             <label for="current_password">Текущий пароль</label>
             <input type="password" id="current_password" class="form-control" name="current_password">
           </div>
           <div class="form-group">
             <label for="current_password">Новый пароль</label>
             <input type="password" id="current_password" class="form-control" name="new_password">
           </div>
           <div class="form-group">
             <label for="current_password">Повторите новый пароль</label>
             <input type="password" id="current_password" class="form-control" name="new_password_again">
           </div>
           <input type="hidden" class="form-control" id="hidden" name="token" value="<?php echo Token::generate(); ?>">
           <div class="form-group">
             <button class="btn btn-warning">Изменить</button>
           </div>
         </form>


       </div>
     </div>
   </div>
</body>
</html>