        <div class="header">
           <ul class="menu1">
               <li> +7 (909) 506-09-36 </li>
               <li>avtovokzal22@gmail.com</li>
           </ul>
           <ul class="menu22">
               <li><?php echo $_SESSION['logged_user']->email;
                   $head_email = $_SESSION['logged_user']->email;?></li>
           </ul>
           <ul class="menu2">
               <li><a href="logout.php">Выйти</a></li>
           </ul>
            
        </div>
        <div class="body">
     <a href="index.php"><img class="logo1" src="img/1.png"></a>  
        
        <ul class="menu3">     
             
            <li><a href="index.php">Автовокзал</a></li>
             <li><a href="news.php">Новости</a></li>
              <li><a href="about.php">О предприятии</a></li>
               <li><a href="uslugi.php">Услуги</a></li>
        </ul>
        <div class="clear"></div>
        
       