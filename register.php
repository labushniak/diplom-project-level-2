<?php
require_once 'init.php';

//проверка формы
if (Input::exists()){
    if(Token::check(Input::get('token'))){

        $validate = new Validate;
        
        $validation = $validate->check($_POST, [
            'username' => [
                'required' => true,
                'min' => 2,
                'max' => 15                
            ],
            'email' => [
                'required' => true,
                'email' => true,
                'unique' => 'users'
            ],
            'password' => [
                'required' => true,
                'min' => 3
            ],
            'password_again' => [
                'required' => true,
                'matches' => 'password'
            ],
            'rules_agreement' => [
                'agreement' => true
            ]
            
        ]);

       
        if($validation->passed()){
            
            $user = new User;

            $user->create ([
                'email' => Input::get('email'),
                'username' => Input::get('username'),
                'password' => password_hash(Input::get('password'), PASSWORD_DEFAULT)
            ]);

            Session::flash('success', 'register success');
            Redirect::to('login.php');
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
    <title>Register</title>
	
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <!-- Bootstrap core CSS -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Custom styles for this template -->
    <link href="css/style.css" rel="stylesheet">
  </head>

  <body class="text-center">
    <form class="form-signin" action="" method="post">
    	  <img class="mb-4" src="images/apple-touch-icon.png" alt="" width="72" height="72">
    	  <h1 class="h3 mb-3 font-weight-normal">Регистрация</h1>
<? echo $errors; ?>
        
        

    	  <div class="form-group">
          <input type="email" class="form-control" id="email" placeholder="Email" name = "email" value="<?php echo Input::get('email')?>">
        </div>
        <div class="form-group">
          <input type="text" class="form-control" id="email" placeholder="Ваше имя" name="username" value="<?php echo Input::get('username')?>">
        </div>
        <div class="form-group">
          <input type="password" class="form-control" id="password" placeholder="Пароль" name="password">
        </div>
        
        <div class="form-group">
          <input type="password" class="form-control" id="password" placeholder="Повторите пароль" name="password_again">
        </div>

        <div class="form-group">
          <input type="hidden" class="form-control" id="hidden" name="token" value="<? echo Token::generate(); ?>">
        </div>

    	  <div class="checkbox mb-3">
    	    <label>
    	      <input type="checkbox" name="rules_agreement" <? echo Input::get('rules_agreement') ?>> Согласен со всеми правилами
    	    </label>
    	  </div>
    	  <button class="btn btn-lg btn-primary btn-block" type="submit" name="submit" value="submit">Зарегистрироваться</button>
    	  <p class="mt-5 mb-3 text-muted">&copy; 2017-2020</p>
    </form>
</body>
</html>