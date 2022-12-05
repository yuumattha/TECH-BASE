<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>m5-02</title>
    <link rel="stylesheet"href="style-m5-01.css">
</head>
<body>
<h1>■■□―――――――投稿フォーム――――――□■■</h1>
    <?php
    $dsn = 'データベース名';
    $user = 'ユーザー名';
    $password = 'パスワード';
    $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
    $sql = "CREATE TABLE IF NOT EXISTS Mission5"
    ." ("
    . "id INT AUTO_INCREMENT PRIMARY KEY,"
    . "name char(32),"
    . "comment TEXT,"
    . "date DATETIME,"
    . "pass TEXT"
    .");";
    $stmt = $pdo->query($sql);

    $filename = "Mission5";
    if(!empty($_POST["str"])){
        if(!empty($_POST["txt"]))
         $sql = $pdo -> prepare("INSERT INTO Mission5 (name, comment,date,pass) VALUES (:name, :comment,:date,:pass)");
         $sql -> bindParam(':name', $name, PDO::PARAM_STR);
         $sql -> bindParam(':comment', $comment, PDO::PARAM_STR);
         $sql -> bindParam(':date', $date, PDO::PARAM_STR);
         $sql -> bindParam(':pass', $pass, PDO::PARAM_STR);
         $name = $_POST["str"];
         $comment = $_POST["txt"];
         $date = date("Y/m/d H:i:s");
         $pass = $_POST["pass"];
     
         if(is_numeric($_POST["num3"])){
             $id = $_POST["num3"];
             $name = $_POST["str"];
             $comment = $_POST["txt"];
             $date = date("Y/m/d H:i:s");
             $sql = 'UPDATE Mission5 SET name=:name,comment=:comment,date=:date WHERE id=:id';
             $stmt = $pdo->prepare($sql);
             $stmt->bindParam(':name', $name, PDO::PARAM_STR);
             $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
             $stmt->bindParam(':date', $date, PDO::PARAM_STR);
             $stmt->bindParam(':id', $id, PDO::PARAM_INT);
             $stmt->execute();
    }else{
         $sql -> execute();
     }
    }
    if(!empty($_POST["num"])){
        if(!empty($_POST["pass1"]))
            $sql = 'SELECT * FROM Mission5';
            $stmt = $pdo->query($sql);
            $results = $stmt->fetchAll();
           foreach ($results as $row){
             if($_POST["pass1"] == $row['pass']){
                $id = $_POST["num"];
                $sql = 'delete from Mission5 where id=:id';
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                $stmt->execute();
             }
           }
        }
    if(!empty($_POST["num2"])){
        if(!empty($_POST["pass2"]))
         $sql = 'SELECT * FROM Mission5';
         $stmt = $pdo->query($sql);
         $results = $stmt->fetchAll();
           foreach ($results as $row){
             if(($row['id'] == $_POST["num2"]) && ($row['pass'] == $_POST["pass2"])){
             $tt = $row;
             echo "<br>"."<br>"."編集中";
             }
           }
    }
    ?>
     <form action="" method="post">
        <br>
        <input type="text" name="str" value="<?php if( !empty($tt)) {echo $tt['name']; }?>" placeholder="名前"><br>
        <input type="text" name="txt" value="<?php if( !empty($tt)) {echo $tt['comment']; }?>" placeholder="コメント"><br>
        <input type="hidden" name="num3" value="<?php echo $tt['id'] ?>">
        <input type="password" name="pass" placeholder="パスワード">
        <input type="submit" name="submit">
    </form></form>
    <form action="" method="post">
        <input type="number" name="num" placeholder="削除対象番号"><br>
        <input type="password" name="pass1" placeholder="パスワード">
        <input type="submit" name="submit" value="削除">
    </form>
    <form action="" method="post">
        <input type="number" name="num2" placeholder="編集対象番号"><br>
        <input type="password" name="pass2" placeholder="パスワード">
        <input type="submit" name="submit" value="編集">
        <br><br><br>
        </form>
    <h1>■■□―――――――投稿一覧――――――□■■</h1>
    <?php
    echo "<br>"."<br>";
    $sql = 'SELECT * FROM Mission5';
    $stmt = $pdo->query($sql);
    $results = $stmt->fetchAll();
    foreach ($results as $row){
        echo "<p>";
        echo $row['id'].' ';
        echo $row['name'].' ';
        echo $row['comment'].' ';
        echo $row['date'].'<br>';
        echo "</p>";
    echo "<hr>";
    }
    ?>
</body>
</html>