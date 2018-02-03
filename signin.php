<?php
    require "bd.php";
    if( isset($_SESSION['logged_user'])){
        header('Location: /');
        include ("blocks/top2.php"); 
        

    } else
    {
        include ("blocks/top.php"); 
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Avtovokzal</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php
    
$db = mysql_connect("localhost","timur","1234");
mysql_select_db("vok" ,$db);
    $data = $_POST;
    if( isset($data['do_signin']) )
    {
        $errors = array();
        $user = R::findOne('users', 'email = ?', array($data['email']));
        if( $user )
        {
            if ( $data['pass'] == $user->pass)
            {
                $_SESSION['logged_user'] = $user;
                echo '<div style="font: 20px sans-serif; color: #00ff00; text-align: center;">Вы авторизованы!</div>';
            } else
            {
               $errors[] = 'Неверный пароль!';  
            }
            
        }else
        {
           $errors[] = 'Пользователь с такой почтой не найден!'; 
        }
        
        if ( ! empty($errors))
            
            {
            echo '<div style="font: 20px sans-serif; color: #f44336; text-align: center;">'.array_shift($errors).'</div>';
            }
    } 
    
    /*
    if(!isset($_COOKIE['id'])){
        if( isset($_POST['go_signin'])){
            $user_email = mysqli_real_escape_string( $db, trim($_POST['email']));
            $user_pass = mysqli_real_escape_string( $db, trim($_POST['pass']));
        }
        if( !empty($user_email) && !empty($user_pass) ){
            $query = "SELECT 'id', 'email' FROM 'users' WHERE email = '$user_email' AND pass = '$user_pass'";
            $data = mysqli_query($db,$query);
            if( mysqli_num_rows($data) == 1 ){
                $row = mysqli_fetch_assoc($data);
                setcookie('id', $row('id'), time() + (60*60*24*30));
                setcookie('email', $row('email'), time() + (60*60*24*30));
                $home_url = 'http://' . $_SERVER['HTTP_HOST'];
                header('Location: '. $home_url);
            }else
            {
                echo 'Вы должны ввести правильно имя пользователя и пароль';
            }
        }else
        {
            echo 'Вы должны заполнить поля правильно';
        }
    }*/
    
?>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
            <div class="reg2">
               <div class="reg_title">
                   <a>Авторизация</a>
               </div>
                <div class="reg_par">
                    <b>Почта</b>
                    <input type="text" size="15" class="reg_data" name="email" value="<?php echo @$_POST['email']; ?>">
                </div>
                <div class="reg_par">
                    <b>Пароль</b>
                    <input type="password" size="15" class="reg_data" name="pass" value="<?php echo @$_POST['pass']; ?>">
                </div>
               <div class="go2">
                   <input type="submit" value="Войти" class="go2_but" name="do_signin">
               </div>
            </div> 
        </form>
<?php
include ("blocks/footer.php");    
?>
</body>
</html>