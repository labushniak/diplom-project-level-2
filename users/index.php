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

  
  } else {
    Redirect::to('../index.php');
  }
}
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Users</title>
	
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <!-- Bootstrap core CSS -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Custom styles for this template -->
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
          
        </ul>

        <ul class="navbar-nav">
        <? echo $link; ?>
        </ul>
      </div>
  </nav>

    <div class="container">
      <div class="col-md-12">
        <h1>Пользователи</h1>
        <table class="table">
          <thead>
            <tr>
              <th>ID</th>
              <th>Имя</th>
              <th>Email</th>
              <th>Действия</th>
            </tr>
          </thead>

          <tbody>
              <?php echo Output::users_list($user->list(), true); ?>
          </tbody>
        </table>
      </div>
    </div>  
  </body>
</html>
