<?php
require_once 'init.php';

$user = new User;

if($user->isLoggedIn()){
    
    $link = Output::links(['/users/edit.php','/logout.php'], $user->data()->id);

} else {
    $link = Output::links(['login.php', 'register.php']);
}

$anotherUser = new User(Input::get('id'));

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
            <a class="nav-link" href="index.php">Главная</a>
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
       <div class="col-md-12">
         <h1>Данные пользователя</h1>
         <table class="table">
           <thead>
             <th>ID</th>
             <th>Имя</th>
             <th>Дата регистрации</th>
             <th>Статус</th>
           </thead>

           <tbody>
             <tr>
               <td><? echo $anotherUser->data()->id ?></td>
               <td><? echo $anotherUser->data()->username; ?></td>
               <td><? echo $anotherUser->date(); ?></td>
               <td><? echo $anotherUser->data()->status; ?></td>
             </tr>
           </tbody>
         </table>


       </div>
     </div>
   </div>
</body>
</html>