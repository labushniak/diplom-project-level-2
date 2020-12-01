<?php
require_once 'init.php';

//проверка формы
if (Input::exists()){
    if(Token::check(Input::get('token'))){

        $validate = new Validate;
        
        $validation = $validate->check($_POST, [
            'email' => [
                'required' => true,
                'email' => true
            ],
            'password' => [
                'required' => true
            ]            
        ]);

        if($validation->passed()){
            
            $user = new User;
            
            $remember = (Input::get('remember')) == 'checked' ? true : false;
            
            $login = $user->login(Input::get('email'), Input::get('password'), $remember);
            
            if($login){
                Session::flash('success', 'login success');
                Redirect::to("user_profile.php?id=" . Input::get('id'));
            }else{
                Session::flash('info', 'Логин или пароль неверны');
            }
            
        } else {
            $errors = Output::errors($validation->errors());
        }
        
    }
}

?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Login</title>
	
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <!-- Bootstrap core CSS -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Custom styles for this template -->
    <link href="css/style.css" rel="stylesheet">
  </head>

  <body class="text-center">
    <form class="form-signin" action="" method="post">
    	  <img class="mb-4" src="images/apple-touch-icon.png" alt="" width="72" height="72">
    	  <h1 class="h3 mb-3 font-weight-normal">Авторизация</h1>

        <? echo $errors; ?>
        <? echo Output::message(Session::flash('success'), 'success');?>
        <? echo Output::message(Session::flash('info'), 'info');?>
        

    	  <div class="form-group">
          <input type="email" class="form-control" id="email" placeholder="Email" name = "email" value ="<?php echo Input::get('email')?>">
        </div>
        <div class="form-group">
          <input type="password" class="form-control" id="password" placeholder="Пароль" name = "password">
        </div>

    	  <div class="checkbox mb-3">
    	    <label>
    	      <input type="checkbox" name="remember" <? echo Input::get('remember') ?>> Запомнить меня
    	    </label>
          </div>
          
          <input type="hidden" class="form-control" id="hidden" name="token" value="<? echo Token::generate(); ?>">

    	  <button class="btn btn-lg btn-primary btn-block" type="submit">Войти</button>
    	  <p class="mt-5 mb-3 text-muted">&copy; 2017-2020</p>
    </form>
</body>
</html>
