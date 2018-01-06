<?php
header('Content-type:application/json');
include "config.php";

$type = isset($_POST['type']) ? htmlspecialchars($_POST["type"]) : "";
$strWhere = "";
switch ($type) {
    case "all":
        $strWhere = "";
        break;
    case "communication":
        $strWhere = " WHERE News_Type = '访问交流'";
        break;
    case "notice":
        $strWhere = " WHERE News_Type = '新闻通知'";
        break;
    case "activity":
        $strWhere = " WHERE News_Type = '团队活动'";
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

    $sql = "SELECT News_ID, News_Type, News_Title, News_Date, News_ReleaseDate, News_Introduction FROM tbl_news" . $strWhere . " ORDER BY News_ReleaseDate";
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