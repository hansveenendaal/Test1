<?php
include($_SERVER['DOCUMENT_ROOT']."/config.php");
global $db,$log;

$nu = time();
$week_terug = $nu - (60*60*24*7);

$label = $_GET['label'];


//let op onderstaande query is niet goed, omdat records dubbel worden meegerekend.
// wie is daar zo druk bezig?? 
// kan je niet dit neerzetten?: select  count( distinct d.id) as open
// ***

$sql2 = "select  count(*) as open
        from data d,
                 data_label dl
        where d.id = dl.data_id
        AND d.time > $week_terug
        AND   labelExtraInfo like '%".$label."%'
        ";

//ook groepering niet juist dus
$sql2 = "select  count(*) as responded
        from data d,
                 data_label dl
        where d.id = dl.data_id
        AND d.time > $week_terug
        AND   labelExtraInfo like '%".$label."%'
        AND response != ''
        ";

//ook groepering niet juist dus
$sql3 = "select  count(*) as tweedelijnsopen
        from data d,
                 data_label dl
        where d.id = dl.data_id
        AND   labelExtraInfo like '%".$label."%'
        AND response != ''
        AND kana_status = '2'
        ";


header('Content-Type: application/json');
$a = $db->query($sql1)->fetchAll();
$b = $db->query($sql2)->fetchAll();
$c = $db->query($sql3)->fetchAll();
$res[data][stats] = array_merge($a, $b, $c);

echo json_encode($res);

?>
