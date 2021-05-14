<?php
require "db.php";
$data = $_POST;
$showError = False;

if(isset($data['signup'])){
    $errors = array();
    $showError = True;

    if(trim($data['firstname']) == ''){
        $errors[] = 'Input firstname!';
    }
    if(trim($data['lastname']) == ''){
        $errors[] = 'Input lastname!';
    }
    if(trim($data['email']) == ''){
        $errors[] = 'Input Email!';
    }
    if(trim($data['password']) == ''){
        $errors[] = 'Input password!';
    }
    if(trim($data['password']) != trim($data['password_2'])){
        $errors[] = 'Incorrect password!';
    }

    if(R::count('users', 'email = ?', array($data['email'])) > 0){
        $errors[] = 'The user with this e-mail exist!';
    }

    if(empty($errors)){
        $user = R::dispense('users');
        $user->firstname = $data['firstname'];
        $user->lastname = $data['lastname'];
        $user->email = $data['email'];
        $user->password = password_hash($data['password'], PASSWORD_DEFAULT);
        $user->avatar = 'noavatar.png';
        R::store($user);
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
        <form action="/signup.php" method="post" class="auth_form">
            <p>Registration</p>
            <input type="text" name="firstname" placeholder="First name"><br>
            <input type="text" name="lastname" placeholder="Last name"><br>
            <input type="email" name="email" placeholder="Email"><br>
            <input type="password" name="password" placeholder="Password"><br>
            <input type="password" name="password_2" placeholder="Confirm password"><br>
            <button type="submit" name="signup">Sign up</button>
        </form>
        <p><?php if($showError) { echo showError($errors); } ?></p>
        <div class="login">
            <a href="/logout.php">Back to menu</a>
        </div>
    </div>
    
</body>
</html>