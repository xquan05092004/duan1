<?php 
    try {
        $db = new PDO("mysql:host=localhost;dbname=clothing_store","root","");
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }catch(PDOException $e){
        die("Ket noi that bai". $e->getMessage());
    }
?>