<?php
    require "bd.php";
    include ("blocks/top2.php"); 
    $db = mysql_connect("localhost","timur","1234");
    mysql_select_db("vok" ,$db);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Avtovokzal</title>
    <link rel="stylesheet" href="style.css">
    <script src="lib/jquery.min.js"></script>
</head>
<body>
<?php
   // print_r($_POST);
    $id_punkt_A = $_GET['id_punkt_A'];
    $id_punkt_B = $_GET['id_punkt_B'];
    $id_stancii = $_GET['id_stancii'];
    $data_viezda = $_GET['data_viezda'];
    $time_viezda1 = $_GET['time_viezda1'];
    $cena = $_GET['cena_reisa'];
    $stoimost_proezda = $_GET['stoimost_proezda'];
    $prib = $_GET['prib'];
    $id_reisa = $_GET['id_reisa'];
    $kolvo_mest = $_GET['kolvo_mest'];
    $tip_mesta = $_GET['tip_mesta'];
    
    $city11 = R::findOne('stancii', 'id = ?', array($id_punkt_A));
    $city22 = R::findOne('stancii', 'id = ?', array($id_punkt_B));
    $city33 = R::findOne('stancii', 'id = ?', array($id_stancii));
    
    $city1 = $city11->nazvanie;
    $city2 = $city22->nazvanie;
    $city3 = $city33->nazvanie;
    
    $id_usera = $_SESSION['logged_user']->id;
    
    $mesto = $_POST['place'];
    //print_r($_POST);
    
    if( isset($_POST['do_buy']) ){
        
        $price_to_db = $_POST['price2'];
        
        if( $id_punkt_B == $prib ){
            mysql_query ("INSERT INTO kupl_bileti (id_usera, id_reisa, otpr, prib, data_reisa, time_reisa, mesto, price) VALUES ('$id_usera','$id_reisa', '$city1', '$city2', '$data_viezda', '$time_viezda1','$mesto', '$price_to_db')");
            echo '<div style="font: 20px sans-serif; color: #00ff00; text-align: center;">Билет на прямой рейс куплен</div>';
        }else{
            mysql_query ("INSERT INTO kupl_bileti (id_usera, id_reisa, otpr, prib, data_reisa, time_reisa, mesto, price) VALUES ('$id_usera','$id_reisa', '$city1', '$city3', '$data_viezda', '$time_viezda1','$mesto', '$price_to_db')");
            echo '<div style="font: 20px sans-serif; color: #00ff00; text-align: center;">Билет на транзитный рейс куплен</div>';
        }
    } /*else{
        echo '<div style="font: 20px sans-serif; color: #f44336; text-align: center;">Билет не куплен</div>';
    }*/
    
    ?>
<div class="buy">
    <div class="reg_title">
        <a>Подтвердите данные</a>
        
    </div>
    <form method="post">
    <div class="reg_par">
        <b>Фамилия</b>
        <input type="text" size="15" class="reg_data" name="sname" value="<?php echo $_SESSION['logged_user']->sname; ?>" disabled>
    </div>
    <div class="reg_par">
        <b>Имя</b>
        <input type="text" size="15" class="reg_data" name="name" value="<?php echo $_SESSION['logged_user']->name; ?>" disabled>
    </div>
    <div class="reg_par">
        <b>Отчество</b>
        <input type="text" size="15" class="reg_data" name="tname" value="<?php echo $_SESSION['logged_user']->tname; ?>" disabled>
    </div>
    <div class="reg_par">
        <b>Откуда</b>
        <input type="text" size="15" class="reg_data" name="otpr" value="<?php echo $city11->nazvanie?>" disabled>
    </div>
    <div class="reg_par">
        <b>Куда</b>
        <input type="text" size="15" class="reg_data" name="prib" value="<?php echo $city22->nazvanie?>" disabled>
    </div>
    <?php
    if( $id_punkt_B != $prib ){
        ?>
        <div class="reg_par">
        <b>Ваша станция</b>
        <input type="text" size="15" class="reg_data" name="stanc" value="<?php echo $city33->nazvanie?>" disabled>
        </div>
        <?php
    }
    ?>
    <div class="reg_par">
        <b>Тип места</b>
        <input type="text" size="15" class="reg_data" name="tip_mesta" value="<?php echo $tip_mesta?>" disabled>
    </div>
    <div class="reg_par2">
        <b>Дата рейса</b>
        <input type="date" size="15" class="reg_data2" name="data_reisa" value="<?php echo $data_viezda?>" disabled>
    </div>
    <div class="reg_par2">
        <b>Время рейса</b>
        
        <input type="time" size="15" class="reg_data2" name="time_reisa" value="<?php echo $time_viezda1?>" disabled>
    </div>
    <div class="reg_par">
        <b>Цена</b>
        <input type="text" size="15" class="reg_data" name="price" value=" <?php
                        if($id_punkt_B == $prib){
                            echo $cena." руб.";
                            } else{ 
                            echo $stoimost_proezda." руб.";
                            }
                        ?> " disabled> 
        <input type="hidden" size="15" class="reg_data" id="hid_price" name="price2" value=" <?php
                        if($id_punkt_B == $prib){
                            echo $cena." руб.";
                            } else{ 
                            echo $stoimost_proezda." руб.";
                            }
                        ?> " >             
    </div>
    <div class="reg_par">
        <b>Выберите место</b>
        <?php
        $sql = mysql_query("SELECT mesto FROM kupl_bileti 
        WHERE kupl_bileti.id_reisa = '$id_reisa' ORDER BY mesto ASC");
    
        while($myrow = mysql_fetch_assoc($sql)){ 
            $rows[] = $myrow['mesto'];
        }
        ?>
        <select name="place" id="place" class="reg_data">
        <?php
        $a = 1;
            while( $a <= $kolvo_mest){ 
              if( in_array("$a", $rows)){
                  
              }else{  
        ?>
            <option value="<?php echo $a; ?>"><?php echo $a; ?></option> 
            <?php
            }
            $a = $a +1;
              
            }
        ?>
        </select>
    </div>
    <div class="reg_par">
        <b>Тип билета</b>
        <?php
        $sql3 = mysql_query("SELECT * FROM lgoti WHERE lgoti.naimenovanie = 'Детcкий' ");
        $myrow3 = mysql_fetch_array($sql3);
        ?>
        <d>Обычный<input type="radio" id="tip" name="tip" value="full" checked style="margin-left:10px;"></d> <br>
        <d title="<?php echo $myrow3['usloviya']; ?>">Детcкий<input type="radio" name="tip" value="kid" style="margin-left:10px;"></d> <br>
        
        
    </div>
    <div class="go2">
       
        <input type="submit" value="Купить" class="go2_but" name="do_buy">
    </div>
    </form>
    
</div>
        
<?php
    /*$sql = mysql_query("SELECT mesto FROM kupl_bileti 
        WHERE kupl_bileti.id_reisa = '$id_reisa' ORDER BY mesto ASC");
    
    for($i = 0; $array[$i] = mysql_fetch_assoc($sql); $i++) ; 
    array_pop($array);
    
    
    $bron = $array['mesto'];
    /*foreach($array as $item){
        echo item->mesto;
    }
        print_r($array['0']);
    
    
    $sql = mysql_query("SELECT mesto FROM kupl_bileti 
        WHERE kupl_bileti.id_reisa = '$id_reisa' ORDER BY mesto ASC");  
    $bron=array(); 
    while($myrow = mysql_fetch_assoc($sql)) { 
        $bron = $myrow['mesto']; 
    print_r($myrow);}*/
        ?>
   
<?php        
include ("blocks/footer.php");    
?>
</body>
</html>


<script>
$('input:radio[name=tip]').on('change', function () {
    if ($(this).val() === 'kid') {

        $("input[name=price]").val('<?php if($id_punkt_B == $prib){
                            echo ($cena/2)." руб.";
                            } else{ 
                            echo ($stoimost_proezda/2)." руб.";
                            } ?>');      
                                   
        $("#hid_price").val('<?php if($id_punkt_B == $prib){
                            echo ($cena/2)." руб.";
                            } else{ 
                            echo ($stoimost_proezda/2)." руб.";
                            } ?>');
                                   
    }                   
     if ($(this).val() === 'full') {
        $("input[name=price]").val('<?php if($id_punkt_B == $prib){
                            echo $cena." руб.";
                            } else{ 
                            echo $stoimost_proezda." руб.";
                            } ?>');
        $("#hid_price").val('<?php if($id_punkt_B == $prib){
                            echo $cena." руб.";
                            } else{ 
                            echo $stoimost_proezda." руб.";
                            } ?>');
    }
});
</script>




<?php/*
echo "<pre>";
print_r($_POST);
echo "</pre>";

*/?>