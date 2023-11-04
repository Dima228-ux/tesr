<?php
require_once 'DbConnector.php';

$data=[
    '/da\s"\"'=>'dsa\d""',
    '\dass'=>'da\dsa"\""\"',
    'ld'=>'"\"',
];

insert($data);
select();

 function insert($data){
    $db = DbConnector::getConnection();
    $json=json_encode($data);

$json="'$json'";
    $result=$db->query('INSERT INTO `test_json`
 (`json_test`) VALUES (JSON_ARRAY('.$json.'))');

echo $result."\n";
}

function select(){
    $db = DbConnector::getConnection();

    $queryResult =  $db->query( "SELECT  json_test  FROM `test_json`");

    $row = $queryResult->fetch_assoc();
    while ($row = $queryResult->fetch_assoc()) {

        echo json_decode($row['json_test'])[0]."\n";
    }


}
