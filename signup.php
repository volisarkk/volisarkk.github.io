<?php
    require "bd.php";
    if( isset($_SESSION['logged_user'])){
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
    if( isset($data['do_signup']))
        {
            $errors = array();
            if(trim($data['sname']) == '')
            {
               $errors[] = 'Введите фамилию!'; 
            }
             if(trim($data['name']) == '')
            {
               $errors[] = 'Введите имя!'; 
            }
            if(trim($data['tname']) == '')
            {
               $errors[] = 'Введите отчество!'; 
            }
            if(trim($data['email']) == '')
            {
               $errors[] = 'Введите почту!'; 
            }
            if($data['birth'] == '')
            {
               $errors[] = 'Введите дату рождения!'; 
            }
            if($data['pass'] == '')
            {
               $errors[] = 'Введите пароль!'; 
            }
            if($data['pass2'] != $data['pass'])
            {
               $errors[] = 'Введенные пароли не совпадают!'; 
            }
            if ( R::count('users', "email = ?", array($data['email'])) >0 )
            {
                $errors[] = 'Пользователь с такой почтой уже существует!';
            }
            
            if (empty($errors))
            {   
                $sname = $data['sname'];
                $name = $data['name'];
                $tname = $data['tname'];
                $email = $data['email'];
                $birth = $data['birth'];
                $pass = $data['pass'];
                  
                mysql_query ("INSERT INTO users (sname, name, tname, email, birth, pass) VALUES ('$sname','$name', '$tname', '$email', '$birth', '$pass')");
            {
            echo '<div style="font: 20px sans-serif; color: #00ff00; text-align: center;">Вы успешно зарегистрированы!</div>';
            }
            }else 
            {
            echo '<div style="font: 20px sans-serif; color: #f44336; text-align: center;">'.array_shift($errors).'</div>';
            }
        }

?>
  
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
           
            <div class="reg">
               <div class="reg_title">
                   <a>Регистрация</a>
               </div>
                <div class="reg_par"> 
                    <b>Фамилия</b>
                    <input type="text" size="15" class="reg_data" name="sname" value="<?php echo @$data['sname']; ?>">
                </div>
                <div class="reg_par">
                    <b>Имя</b>
                    <input type="text" size="15" class="reg_data" name="name" value="<?php echo @$data['name']; ?>">
                </div>
                <div class="reg_par" >
                    <b>Отчество</b>
                    <input type="text" size="15" class="reg_data" name="tname" value="<?php echo @$data['tname']; ?>">
                </div>
                <div class="reg_par">
                    <b>Почта</b>
                    <input type="text" size="15" class="reg_data" name="email" value="<?php echo @$data['email']; ?>">
                </div>
                <div class="reg_par2">
                    <b>Дата рождения</b>
                    <input type="date" class="reg_data2" name="birth" value="<?php echo @$data['birth']; ?>">
                </div>
                <div class="reg_par">
                    <b>Пароль</b>
                    <input type="password" size="15" class="reg_data" name="pass" value="<?php echo @$data['pass']; ?>">
                </div>
                <div class="reg_par">
                    <b>Пароль еще раз</b>
                    <input type="password" size="15" class="reg_data" name="pass2" value="<?php echo @$data['pass2']; ?>">
                </div>
               <div class="go1">
                   <input type="submit" value="Зарегистрироваться" class="go1_but" name="do_signup">
               </div>
            </div> 
        </form>
      
<?php
include ("blocks/footer.php");    
?>

</body>
</html>