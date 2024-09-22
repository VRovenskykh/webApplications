<?php
//фраза
echo "Hello world!<br>"; 

//змінні
$bl = TRUE;
$intvar = 10;
$floatvar = 9.5;
$str = "String";

echo $bl,"<br>", $intvar,"<br>", $floatvar,"<br>", $str ,"<br>";

//тип
var_dump($bl); echo "<br>";
var_dump($intvar); echo "<br>";
var_dump($floatvar); echo "<br>";
var_dump($str); echo "<br>";

$str1 = "lab1 ";
$str2 = "v processe";

//з'єднання
echo $str1 .= $str2;echo "<br>";

$vybor = TRUE;

//if цикл
if($vybor == TRUE){
    echo "Вірно";echo "<br>";
}else{
    echo "Невірно";echo "<br>";
}
?>


<?
//for цикл
for ($i = 1; $i<=10; $i++) {
    echo $i, "\n";
}
echo "<br>";
?> 

<?
$i = 10;
//while цикл
while($i > 0 ){
    echo $i, "\n"; $i--;
}
echo "<br>";
?>

<?
//ассоціативний массив students
$students["name"] = "Viktor";
$students["surname"] = "Rovenskykh";
$students["age"] = "19";
$students["speciality"] = "122";

print_r($students);echo "<br>";
$students["Середній бал"] = "100";
print_r($students);echo "<br>";


?>
