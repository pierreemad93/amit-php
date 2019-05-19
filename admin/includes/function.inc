<?php
function countItem($item , $table){
    global $con ;
    $stmt2=$con->prepare("SELECT COUNT($item) FROM $table WHERE groupid!=1");
    $stmt2->execute();
    return $stmt2->fetchColumn();
}