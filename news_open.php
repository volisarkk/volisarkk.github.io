<?php
    require "bd.php";
    if( isset($_SESSION['logged_user'])){
        include ("blocks/top2.php"); 
        include ("blocks/right2.php");
    } else
    {
        include ("blocks/top.php"); 
        include ("blocks/right.php");
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
            if (isset($_GET['id'])) {
                    $id = $_GET['id'];
                }
            $sql = mysql_query("SELECT * FROM news WHERE id='$id'", $db); 
            $myrow = mysql_fetch_array($sql)
        ?>

            <div class="news">
                <div class="news_item">
                    <ul class="menu5">
                        <li>
                        <span><?php echo $myrow['date']?></span> 
                        <a><?php echo $myrow['title']?></a>
                        <p><?php echo $myrow['text']?></p>
                        </li>                                            
                    </ul>  
                </div> 
            </div>  
                         
        </div>   
<?php
include ("blocks/footer.php");    
?>
            
</body>
</html>