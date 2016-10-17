<?php
    $host = "localhost";
    $user = "root";
    $password = "";
    $database_name = "comment";
    $pdo = new PDO("mysql:host=$host;dbname=$database_name", $user, $password, array(
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ));
    try{
    $query = $pdo->prepare("insert into test (name,comment)
    values (:name,:comment)");
    $data = array(
    ':name' => 'Robby',
    ':comment' => 'Like it'
    );
    $query->execute($data);
    echo "Data successfully inserted into the database table ...";
    }catch(PDOException $e){
    echo "Error! failed to insert into the database table :".$e->getMessage();
}
?>