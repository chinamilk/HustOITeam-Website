<?php
header('Content-type:application/json');
include "../config.php";
include "../common.php";

$id = isset($_POST['id']) ? htmlspecialchars($_POST["id"]) : "";
$tableName = isset($_POST['tableName']) ? htmlspecialchars($_POST["tableName"]) : "";
$attribute = isset($_POST['attribute']) ? htmlspecialchars($_POST["attribute"]) : "";

if($id != "" && $tableName != "" && $attribute != "") {
    $prefix = getPrefix($tableName);
    $attribute = $prefix . $attribute;
    $table = "tbl_" . $tableName;

    $conn = new mysqli($servername, $username, $password, $dbname);
    $conn->set_charset("utf8"); //avoid the chinese characters to be mistaken
    if($conn->connect_errno)
        die("连接失败: " . $conn->connect_error);
    //echo "连接成功";

    $sql = "UPDATE $table SET $attribute = $attribute + 1 WHERE " . $prefix . "ID = '" . $id . "'";
    $conn->query($sql);

    $conn->close();
}

?>