<?php
header('Content-type:application/json');
include "config.php";

$type = isset($_POST['type']) ? htmlspecialchars($_POST["type"]) : "";
$strWhere = "";
switch ($type) {
    case "paper":
        $strWhere = " WHERE Achi_Type = '论文'";
        break;
    case "academic":
        $strWhere = " WHERE Achi_Type = '纵向项目'";
        break;
    case "enterprise":
        $strWhere = " WHERE Achi_Type = '横向项目'";
        break;
    default:
        $strWhere = "nothing";
}
$news = array();
if($strWhere != "nothing") {
    $conn = new mysqli($servername, $username, $password, $dbname);
    $conn->set_charset("utf8"); //avoid the chinese characters to be mistaken
    if($conn->connect_errno)
        die("连接失败: " . $conn->connect_error);
    //echo "连接成功";

    //$sql = "SELECT Achi_ID, Achi_Date, Achi_Name, Achi_DetailPath FROM tbl_achievement" . $strWhere . " ORDER BY Achi_Date DESC";
    $sql = "SELECT DISTINCT Achi_Date, Achi_Name, Achi_DetailPath FROM tbl_achievement" . $strWhere . " ORDER BY Achi_Date DESC";
    $result = $conn->query($sql);

    if($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            array_push($news, $row);
        }
    }
}
echo json_encode($news);
$conn->close();
?>