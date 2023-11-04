<?php
require_once 'SimpleXLSX.php';
require_once 'DbConnector.php';

$path = 'C:\Users\Дима\Documents\1e.xlsx'; // нужно установить путь до вайла xsl
$content='';

$insert=[];
const lenght_phone=12;// длинна номера телефона ставим в зависимости от страны

if ( $xlsx = SimpleXLSX::parse($path) ) {
    $content=$xlsx->rows();
} else {
    echo SimpleXLSX::parseError();
}

foreach ($content as $value){
    $pattern_phone = "/(\+?\d*)?[\s\-\.]?((\(\d+\)|\d+)[\s\-\.]?)?(\d[\s\-\.]?){6,7}/";
    $pattern_email="/[a-z0-9_\-\+\.]+@[a-z0-9\-]+\.([a-z]{2,4})(?:\.[a-z]{2})?/i";
   foreach ($value as $item){
       $number='';
       $email='';
       preg_match($pattern_phone, $item, $number_phone);
       preg_match($pattern_email, $item, $emails);
       preg_match_all( "/[0-9]/", $number_phone[0],$count);

       if(!empty($number_phone[0])) {
           if (count($count[0]) < lenght_phone) {
               $number = $number_phone[0];
           }
       }
       if(!empty($emails[0])){
           $email=$emails[0];
       }
       $insert[]= '("'.$email.'", "'.$number.'")';

   }
}

$db = DbConnector::getConnection();

$result=$db->query('INSERT INTO `test_xsl`
 (`email`, `phone`) VALUES '.implode(',', $insert));

echo $result;




