<?php
require_once '../init.php';

$user = new User;


if(!$user->isLoggedIn()){
    Redirect::to('../login.php');

} else {
  
  //если id страницы и id залогиненого пользователя равны или админ
  if (Input::get('id') == $user->data()->id || $user->hasPermissions('admin')){
    
    $anotherUser = new User(Input::get('id'));
    
    $link = Output::links(['/users/edit.php', '/logout.php'], $user->data()->id);

    if (Input::exists()){
      if(Token::check(Input::get('token'))){
        
        $validate = new Validate;
        
        $validation = $validate->check($_POST, [
            'username' => [
                'required' => true,
                'min' => 5,
                'max' => 25    
            ],
            'status' => [
                'max' => 130
            ]
        ]);
          
        if($validation->passed()){
         
            $anotherUser->update(['username' => Input::get('username'), 'status' => Input::get('status')], Input::get('id'));
            
            Session::flash('success', 'Профиль обновлен');
            
            Redirect::to("/users/edit.php?id=" . Input::get("id"));
            exit;
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
         <h1>Профиль пользователя - <?php echo $anotherUser->data()->username ?></h1>
         
         <?php echo $errors; ?>
         
         <? echo Output::message(Session::flash('success'), 'success');?>
         <ul>
           <li><a href="/changepassword.php?id=<?php echo Input::get('id') ?>">Изменить пароль</a></li>
         </ul>
         <form action="" class="form" method="post">
           <div class="form-group">
             <label for="username">Имя</label>
             <input type="text" id="username" class="form-control" value="<?php echo $anotherUser->data()->username ?>" name = "username">
           </div>
           <div class="form-group">
             <label for="status">Статус</label>
             <input type="text" id="status" class="form-control" value="<?php echo $anotherUser->data()->status ?>" name = "status">
           </div>
           <input type="hidden" class="form-control" id="hidden" name="token" value="<?php echo Token::generate(); ?>">
           <div class="form-group">
             <button class="btn btn-warning">Обновить</button>
           </div>
         </form>


       </div>
     </div>
   </div>
</body>
</html>