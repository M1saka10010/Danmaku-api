<?php
// pdo连接数据库
$db_host = DB_HOST;
$db_user = DB_USER;
$db_pass = DB_PASS;
$db_name = DB_NAME;
$pdo = 'mysql:host=' . $db_host . ';' . 'dbname=' . $db_name;
try {
    $pdo = new PDO($pdo, $db_user, $db_pass);
    // echo '连接成功';
} catch (PDOException $e) {
    // echo $e;
    echo '数据库连接失敗';
}
function add_danmaku($author, $color, $vid, $text, $time, $token, $type)
{
    global $pdo;
    $sql = "INSERT INTO `danmakus` (`author`,`color`,`vid`,`text`,`time`,`token`,`type`) VALUES ('" . $author . "','" . $color . "','" . $vid . "','" . $text . "','" . $time . "','" . $token . "','" . $type . "')";
    $pdo->exec($sql);
}
function search_danmaku($vid)
{
    global $pdo;
    $sqlco = "SELECT * FROM `danmakus` WHERE `vid` = '" . $vid . "'";
    $result = $pdo->query($sqlco);
    $result = $result->fetchAll();
    return $result;
}
