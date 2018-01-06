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
    if($conn->connect_errno)
        die("连接失败: " . $conn->connect_error);
    //echo "连接成功";

    //删除照片
    $sql = "SELECT * FROM $table WHERE " . $prefix . "ID = '" . $id . "'";
    $result = $conn->query($sql);
    //如果有照片，就将之删除
    $info = $result->fetch_assoc();
    if($info[$prefix . "Path"] != "")
        unlink("../../" . $info[$prefix . "Path"]);

    //删除信息
    $sql = "DELETE FROM $table WHERE " . $prefix . "ID = '" . $id . "'";
    $conn->query($sql);

    //如果是删除成员信息，需要进行级联删除
    if($tableName == "groupmember") {
        //删除教育信息
        $sql = "DELETE FROM tbl_education WHERE Educ_GrMe_ID = '" . $id . "'";
        $conn->query($sql);
        //删除荣誉信息
        $sql = "DELETE FROM tbl_honour WHERE Hono_GrMe_ID = '" . $id . "'";
        $conn->query($sql);
        //删除工作信息
        $sql = "DELETE FROM tbl_workexperience WHERE WoEx_GrMe_ID = '" . $id . "'";
        $conn->query($sql);
        //删除成果信息
        $sql = "DELETE FROM tbl_achievement WHERE Achi_GrMe_ID = '" . $id . "'";
        $conn->query($sql);
    }

    $conn->close();
    return true;
} else {
    return false;
}
?>