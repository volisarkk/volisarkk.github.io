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
        <div class="uslugi">

<p><b class="uslugi_tile">Справочная</b><br>
<br>
Первый этаж, напротив билетных касс.<br>
<br>
Устные справки бесплатно.<br>
<br>
Предоставление письменной справки о стоимости проезда. Услуга платная — стоимость 50 руб.<br>
<br>
<b class="uslugi_tile">Комната матери и ребенка</b><br>
<br>
Второй этаж<br>
<br>
<b class="uslugi_tile">Камера хранения</b><br>
<br>
Первый этаж, справа от билетных касс<br>
<br>
<b class="uslugi_tile">Передача писем и посылок</b><br>
<br>
Первый этаж, в центре зала, отдел «Тавио»<br>
<br>
<b class="uslugi_tile">Парковка</b><br>
<br>
Перед автовокзалом организована стоянка автомобилей на 60 мест<br>
<br>
Стоимость стоянки:<br>
<br>
120 рублей в сутки<br>
<br>
50 рублей в час<br>
<br>
Стоянка до 10 минут бесплатно<br>
<br>
Вся территория стоянки находится под круглосуточным видеонаблюдением.<br>
<br>
Сохранность автомобиля гарантирована.</p>

           </div>
        </div>
                      
<?php
include ("blocks/footer.php");    
?>

</body>
</html>