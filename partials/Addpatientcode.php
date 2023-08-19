<?php
include '_dbconn.php';
if($_SERVER['REQUEST_METHOD']=='POST'){
    
    $post_data=[
        'id'=>$_POST['id'],
        'name'=>$_POST['name'],
        'address'=>$_POST['address'],
        'phone'=>$_POST['phone'],
      ];
      $i=1;
      $ref_table="patients";
      $database->getReference($ref_table)->push($post_data);
      header("location:patient.php");
}
?>