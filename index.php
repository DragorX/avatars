<?php
require "db.php";
$data = $_POST;
$user = R::findOne('users', 'id = ?', array($_SESSION['user']->id));

function loadAvatar($avatar){
    $type = $avatar['type'];
    $name = md5(microtime()).'.'.substr($type, strlen("image/"));
    $dir = 'uploads/avatars/';
    $uploadfile = $dir.$name;

    if(move_uploaded_file($avatar['tmp_name'], $uploadfile)){
        $user = R::findOne('users', 'id = ?', array($_SESSION['user']->id));
        $user->avatar = $name;
        R::store($user);
    }else{
        return false;
    }

    return true;
}

if(isset($data['set_avatar'])){
    $avatar = $_FILES['avatar'];

    if(avatarSecurity($avatar)) loadAvatar($avatar);

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
    <div class="content">
    <?php if($user) : ?>
        <img src="uploads/avatars/<?php echo $user->avatar; ?>" class="avatar">

        <form action="/" method="post" enctype="multipart/form-data">
            <input type="file" name="avatar">
            <button type="submit" name="set_avatar">Chenge avatar</button>
            
        </form>
        
        <div class="username">
            <div class="none" onclick="this.className = (this.className == 'block' ? 'none' : 'block')">></div>
            <p>Hello, <?php echo $user->firstname.' '. $user->lastname;?>!</p>
        </div>
        

        <div class="block-list" >
            <div id="block" class="list-item" onclick="this.className = (this.className == 'list-item' ? 'block' : 'list-item'), alert('Click for success!')"></div>
            <div id="block" class="list-item" onclick="this.className = (this.className == 'list-item' ? 'block' : 'list-item'), alert('Click for success!')"></div>
            <div id="block" class="list-item" onclick="this.className = (this.className == 'list-item' ? 'block' : 'list-item'), alert('Click for success!')"></div>
            <div id="block" class="list-item" onclick="this.className = (this.className == 'list-item' ? 'block' : 'list-item'), alert('Click for success!')"></div>
            <div id="block" class="list-item" onclick="this.className = (this.className == 'list-item' ? 'block' : 'list-item'), alert('Click for success!')"></div>
        </div>
        <p>It may be needed to press the "Change avatar" button one more time or reload the page.</p>
        <div class="login">
            <a href="/logout.php">Log out</a>
        </div>
    <?php else :?>
        <div class="login">
            <a href="/signin.php">Sign in</a><br>
            <a href="/signup.php">Sign up</a>
        </div>
    <?php endif; ?>
    </div>
</body>
</html>