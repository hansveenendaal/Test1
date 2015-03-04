<?php
include($_SERVER['DOCUMENT_ROOT']."/config.php");
global $db,$log;
 
if(is_numeric($_GET['max_id']))
    $max_id = $_GET['max_id'];
else
    $max_id = 0;
// test 2.....
$label = $_GET['label'];

switch ($label) {
    case "BROOD": 
            $sql = "select d.*,d.time tijd
                    from data d,
                             data_label dl
                    where d.id = dl.data_id
                    AND   d.id  > ".$max_id."
                    AND   labelExtraInfo like '%brood%'
                    group by d.id
                    order by d.id desc limit 10";
        break;
    default:
        break;
}

header('Content-Type: application/json');
$res[data][results] = $db->query($sql)->fetchAll();
echo json_encode($res);

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

