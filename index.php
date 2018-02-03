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
?>
        <div class="reisi">
          <form  method="POST">
           <div class="reisi_par">
               <?php echo "Укажите пункт отправления";?>
               <select name="otpr" id="otpr">
                <?php
                   $sql = mysql_query("SELECT * FROM stancii", $db);
                   while ($myrow1 = mysql_fetch_array($sql)){
                    ?>
                      <option value='<?php echo $myrow1['id']?>'><?php echo $myrow1['nazvanie']; ?></option>
                      <?php                  
                   }    
                ?>
               </select>      
           </div>
           
           <div class="reisi_par">
               <?php echo "Укажите пункт прибытия";?>
               <select name="prib" id="prib">
                <?php
                   $sql = mysql_query("SELECT * FROM stancii", $db);
                   while ($myrow1 = mysql_fetch_array($sql)){
                       
                    ?>
                      <option value='<?php echo $myrow1['id']?>'><?php echo $myrow1['nazvanie']; ?></option>
                      <?php
                       
                   }    
                ?>
               </select> 
           </div>
           
           <div class="reisi_par">
               Укажите дату
               <input type="date" name="data_reisa" value="<?php echo $_POST['data_reisa']; ?>">
           </div>
           
           <div class="find">
               <input type="submit" value="Найти" class="find_but" name="do_find">
           </div>
           </form>
          <?php
          // print_r($_POST)
               
            ?>
          
          
           <div class="result">
              <?php
               
              if( isset($_POST['do_find']) ){
                  $sqll = mysql_query("SELECT reisi.id, kolvo_mest, tip_mesta, id_punkt_A, id_punkt_B, id_stancii, cena_reisa, stoimost_proezda, data_viezda, DATE_FORMAT(time_viezda, '%H:%i') as time_viezda1  FROM reisi 
                    INNER JOIN marshruti ON reisi.id_marshruta = marshruti.id
                    INNER JOIN stancii_na_marsh ON reisi.id_stancii_na_marsh = stancii_na_marsh.id
                    INNER JOIN stancii ON stancii_na_marsh.id_stancii = stancii.id
                    INNER JOIN avtobusi ON reisi.id_avtobusa = avtobusi.id
                    INNER JOIN klass_avtobusa ON avtobusi.id_klassa_avtobusa = klass_avtobusa.id

                    WHERE marshruti.id_punkt_A = ".$_POST['otpr']." AND (marshruti.id_punkt_B = ".$_POST['prib']." OR stancii_na_marsh.id_stancii = ".$_POST['prib'].") AND reisi.data_viezda = '".$_POST['data_reisa']."' ", $db);
               
               while ($myrow = mysql_fetch_assoc($sqll)){
                  // print_r($myrow);
                   $prib = $_POST['prib'];
                  
                ?>
                <div class="result_win" method="post">
                
                        <ul class="result_par">
                    <li>
                        <?php 
                        $city1 = R::findOne('stancii', 'id = ?', array($myrow['id_punkt_A']));
                            echo $city1->nazvanie;
                        ?>
                    </li>
                    <li>
                        <?php 
                        $city2 = R::findOne('stancii', 'id = ?', array($myrow['id_punkt_B']));
                            echo $city2->nazvanie;
                        ?>
                    </li>
                    <li>
                        <?php echo $myrow['time_viezda1']; ?>
                    </li>
                    <li style="margin-top:9px;">
                        <?php echo $myrow['tip_mesta']; ?><br>
                        
                        <?php 
                   $sqlll = mysql_query("SELECT COUNT(mesto) AS mesta FROM kupl_bileti 
                                        WHERE id_reisa = '".$myrow['id']."' ");
                   $myroww = mysql_fetch_array($sqlll);
                   echo "(".($myrow['kolvo_mest']-$myroww['mesta'])." мест)"; ?>
                   
                    </li> 
                    <li>
                        <?php
                        if($myrow['id_punkt_B'] == $prib){
                            echo $myrow['cena_reisa']." руб."; 
                        }
                        else{ 
                            echo $myrow['stoimost_proezda']." руб.";
                        }
                        ?>
                    </li>
                        <?php
                   $date_now = date("Y-m-d"); 
                   $time_now = date("H:i");
                   
                 /* echo $time_now;?><br><?
                   echo $date_now;*/
                        if( isset($_SESSION['logged_user']) && $date_now<$myrow['data_viezda'] /*&& $time_now<$myrow['time_viezda1']*/){ ?>
                            <div class="buy_par">
                                <a href="buy.php?id_punkt_A=<?php echo $myrow['id_punkt_A']?>&id_punkt_B=<?php echo $myrow['id_punkt_B']?>&id_stancii=<?php echo $myrow['id_stancii']?>&data_viezda=<?php echo $myrow['data_viezda']?>&cena_reisa=<?php echo $myrow['cena_reisa']?>&stoimost_proezda=<?php echo $myrow['stoimost_proezda']?>&prib=<?php echo $prib?>&id_reisa=<?php echo $myrow['id']?>&kolvo_mest=<?php echo $myrow['kolvo_mest']?>&tip_mesta=<?php echo $myrow['tip_mesta']?>&time_viezda1=<?php echo $myrow['time_viezda1']?>" value="Купить" class="buy_but" name="do_buy1">Купить</a>
                            </div>   
                            <?php  
                        }
                        ?>         
                            </ul>
                    </div>
                <?php      
               }
               
              }
               ?>
           </div>
        </div>   
                        
        </div>
        <?php/*
                                if( isset($_SESSION['logged_user'])){
                                ?>
                                   <div>
                                      
                                      <a href="buy.php?id=<?=$myrow[id]?>"><input type="submit" value="Купить" class="buy_but" name="do_buy1"></a> 
                                      
                                   </div>
                                <?php
                                    if ( isset($_GET['do_buy1']) ){
                                        $id_punkt_A = $myrow['id_punkt_A'];
                                        $id_punkt_B = $myrow['id_punkt_B'];
                                        $id_stancii = $myrow['id_stancii'];
                                        $cena = $myrow['cena'];
                                        $stoimost_proezda = $myrow['stoimost_proezda'];
                                        $eurodate = $myrow['eurodate'];
                       
                                            $sqlll = "INSERT INTO vrem_buy (id_punkt_A1, id_punkt_B1, id_stancii1, cena1, stoimost_proezda1, eurodate1) VALUES ('$id_punkt_A','$id_punkt_B', '$id_stancii', '$cena', '$stoimost_proezda', '$eurodate')";
                                            $res = mysql_query($sqlll) or trigger_error(mysql_error()." in ".$sqlll);
                                                echo 'ye';
                                            }else{
                                                echo 'no';
                                            }
                                }
                                */?>
<?php
    
  //  print_r($myrow);
    
include ("blocks/footer.php");    
?>
</body>
</html>