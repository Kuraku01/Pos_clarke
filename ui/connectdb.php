<?php

try {

    $pdo = new PDO('mysql:host=localhost;dbname=pos_clarke_db','root','');

    //echo'yes';

} catch (PDOexception $error) {

    echo $error->getMessage();

}

?>