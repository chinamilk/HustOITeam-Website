<?php
header('Content-type:application/json');
include "../../config.php";
include "../../common.php";

$id = isset($_POST['id']) ? htmlspecialchars($_POST["id"]) : "";
$tableName = isset($_POST['tableName']) ? htmlspecialchars($_POST["tableName"]) : "";

if($id != "" && $tableName != "") {
    $prefix = getPrefix($tableName);
    $table = "tbl_" . $tableName;

    $conn = new mysqli($servername, $username, $password, $dbname);
    $conn->set_charset("utf8"); //avoid the chinese characters to be mistaken
    if ($conn->connect_errno)
        die("连接失败: " . $conn->connect_error);
    //echo "连接成功";

    $info = array();
    $sql = "SELECT * FROM $table WHERE " . $prefix . "ID = '" . $id . "'";
    $result = $conn->query($sql);
    if($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            //array_push($info, $row);
            echo json_encode($row);
        }
    }

    //echo json_encode($info);
    $conn->close();
    return true;
} else {
    return false;
}

?>