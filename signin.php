<?php
require "db.php";
$data = $_POST;
$showError = False;

if(isset($data['signin'])){
    $errors = array();
    $showError = True;

    if(trim($data['email']) == ''){
        $errors[] = 'Input Email!';
    }
    if(trim($data['password']) == ''){
        $errors[] = 'Input password!';
    }

    $user = R::findOne('users', 'email = ?', array($data['email']));
    if($user){
        if(password_verify($data['password'], $user->password)){
            $_SESSION['user'] = $user;
            header('Location: /');
        }else{
            $errors[] = 'Incorrect password!';
        }
    }else{
        $errors[] = 'The user is not found!';
    }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CodeWriter Account</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="content" align="center">
        <form action="/signin.php" method="post" class="auth_form">
            <p>Login</p>
            <input type="email" name="email" placeholder="Email"><br>
            <input type="password" name="password" placeholder="Password"><br>
            <button type="submit" name="signin">Login</button>
        </form>
        <p><?php if($showError) { echo showError($errors); } ?></p>
       <div class="login">
            <a href="/logout.php">Back to menu</a>
        </div>
    </div>
    
</body>
</html>