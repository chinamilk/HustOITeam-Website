<?php
/*use guid to generate uuid*/
function createGuid()
{
    mt_srand((double)microtime() * 10000);//optional for php 4.2.0 and up.
    //$charid = strtoupper(md5(uniqid(rand(), true)));
    $charid = md5(uniqid(rand(), true));
    $hyphen = chr(45);// "-"
    /*$uuid = chr(123)// "{"
        .substr($charid, 0, 8).$hyphen
        .substr($charid, 8, 4).$hyphen
        .substr($charid,12, 4).$hyphen
        .substr($charid,16, 4).$hyphen
        .substr($charid,20,12)
        .chr(125);// "}"*/
    $uuid = substr($charid, 0, 8) . $hyphen
        . substr($charid, 8, 4) . $hyphen
        . substr($charid, 12, 4) . $hyphen
        . substr($charid, 16, 4) . $hyphen
        . substr($charid, 20, 12);
    return $uuid;
}

/*get the table's prefix in db according to tableName*/
function getPrefix($tableName){
    $reflection = array("achievement" => "Achi_", "album" => "Albu_", "education" => "Educ_", "grouphonour" => "GrHo_", "groupmember" => "GrMe_", "honour" => "Hono_", "news" => "News_", "others" => "Othe_", "resource" => "Reso_", "workexperience" => "WoEx_");
    return $reflection[$tableName];
}

/*generate reflection from memberId to name*/
function memberId2name($conn) {
    $sql = "SELECT GrMe_ID, GrMe_Name FROM tbl_groupmember ORDER BY GrMe_Type DESC , GrMe_Name DESC";
    $result = $conn->query($sql);

    $reflection = array();
    if($result->num_rows > 0) {
      while($row = $result->fetch_assoc()) {
          $reflection[$row["GrMe_ID"]] = $row["GrMe_Name"];
          //array_push($reflection, array($row["GrMe_ID"] => $row["GrMe_Name"])); //这句话会将reflection构建成二维数组
      }
    }
    return $reflection;
}

/*页面提示并跳转，jump(跳转url, 提示信息（为null时，表示直接跳转）, 延迟时间（单位：秒）)*/
function jump($url,$info,$sec)
{
    if(is_null($info)){
        header("Location:$url");
    }else{
        // header("Refersh:$sec;URL=$url");
        echo"<meta http-equiv=\"refresh\" content=".$sec.";URL=".$url.">";
        echo $info;
    }
    die;
}

/*登陆超时、非法登陆判断 $backPath指明原页面相对于根目录的相对路径*/
function licenseJudge($backPath) {
    if(!isset($_SESSION["license"]) || $_SESSION["license"] != true){
        session_destroy();
        jump($backPath . "admin/login.php", "非法登陆", 1); //(跳转url, 提示信息, 延迟时间（单位：秒）)

    }
    //设置登陆超时时间（10分钟）
    if ($_SESSION['timeout'] + 10 * 60 < time()){
        session_destroy();
        jump($backPath . "admin/login.php", "登陆超时", 1);
    }
}

/*统计访问量，但不根据id判断*/
function countLog() {
    $datei = fopen("countlog.txt","r");
    $count = fgets($datei,1000);
    fclose($datei);
    $count=$count + 1 ;
    $datei = fopen("countlog.txt","w");
    fwrite($datei, $count);
    fclose($datei);
    return $count;
}

?>