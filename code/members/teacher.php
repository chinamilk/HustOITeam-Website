<?php
include "../config.php";

//judge whether the getInfo is none
if(!(is_array($_GET) && count($_GET)))
    die("error : has no get information");
//judge whether the getInfo has ID parameter
if(!isset($_GET["ID"]))
    die("error : ID message don't exist in get information");

$ID = htmlspecialchars($_GET["ID"]); //avoid XSS destroy
$conn = new mysqli($servername, $username, $password, $dbname);
$conn->set_charset("utf8"); //avoid the chinese characters to be mistaken
$sql = "SELECT * FROM tbl_groupmember WHERE GrMe_ID ='" . $ID . "'";
$result = $conn->query($sql);

if($result->num_rows == 0) {
    die("error : page not found");
} else if($result->num_rows > 1) {
    die("database message error : has multiply information for the ID");
}
$info = $result->fetch_assoc();
//print_r($info);
?>

<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Introduction About <?php $info["GrMe_Name"] ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
    <meta name="description" content="hust optimization and innovation team" />
    <meta name="keywords" content="optimization" />
    <meta name="keywords" content="innovation" />
    <meta name="author" content="HXW" />

    <!-- Themify Icons -->
    <link rel="stylesheet" href="../css/themify-icons.css">
    <!-- Icomoon Icons -->
    <link rel="stylesheet" href="../css/icomoon-icons.css">
    <!-- Bootstrap -->
    <link rel="stylesheet" href="../css/bootstrap.css">
    <!-- Owl Carousel -->
    <link rel="stylesheet" href="../css/owl.carousel.min.css">
    <link rel="stylesheet" href="../css/owl.theme.default.min.css">
    <!-- Magnific Popup -->
    <link rel="stylesheet" href="../css/magnific-popup.css">
    <!-- Easy Responsive Tabs -->
    <link rel="stylesheet" href="../css/easy-responsive-tabs.css">
    <!-- Theme Style -->
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/user.css">
    <!--Fix the same style in all browsers-->
    <!--<link rel="stylesheet" href="css/bootstrap/normalize.css">-->

    <link rel="stylesheet" href="../css/stylesHxw.css">

    <style>
        .panel-body p { margin: 5px; }
    </style>

    <!-- FOR IE9 below -->
    <!--[if lte IE 9]>
    <script src="../js/modernizr-2.6.2.min.js"></script>
    <script src="../js/respond.min.js"></script>
    <![endif]-->

</head>
<body class="fh5co-outer">
<header id="fh5co-header" role="banner">
    <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
        <div class="container">
            <!--container会提供一个margin-->
            <div class="navbar-header" style="margin-top: -5px;">
                <!--navbar-header & navbar-brand 会让字体看起来更大一号-->
                <!-- Mobile Toggle Menu Button -->
                <a href="#" class="js-fh5co-nav-toggle fh5co-nav-toggle" data-toggle="collapse"
                   data-target="#fh5co-navbar" aria-expanded="false" aria-controls="navbar"><i></i></a>
                <a class="navbar-brand" href="../index.php">
                    <!--Hust OI-->
                    <img src="../images/teamLogoBlackC.png" alt="team logo" style="width:110px;height: 40px;">
                </a>
            </div>
            <div id="fh5co-navbar" class="navbar-collapse collapse">
                <ul class="nav navbar-nav navDefined">
                    <!--<ul class="nav nav-pills">-->
                    <li><a href="../news.html"><strong class="navTitle">团队新闻</strong></a></li>
                    <li><a href="../achievement.html"><strong class="navTitle">科研成果</strong></a></li>
                    <li><a href="../members.php"><strong class="navTitle">团队成员</strong></a></li>
                    <li><a href="../awards.php"><strong class="navTitle">团队荣誉</strong></a></li>
                    <li><a href="../albums.php"><strong class="navTitle">团队相册</strong></a></li>
                    <li><a href="../resources.php"><strong class="navTitle">资源链接</strong></a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <!--<li><a href="intro.html#contact" class="btn btn-calltoaction btn-primary">联系我们</a></li>-->
                    <!--<li><a href="#" class="btn btn-calltoaction btn-primary">联系我们</a></li>-->
                </ul>
            </div>
        </div>
    </nav>
</header>

<main role="main" id="fh5co-main" style="margin-top: 60px;">
    <div class="container">
        <div class="row">
            <div class="col-md-12" id="fh5co-content">
                <div class="row">
                    <div class="col-md-offset-1 col-md-4 text-center" style="padding-bottom: 10px;">
                        <div class="row" style="margin-top: 40px;">
                            <img src="../<?php echo $info["GrMe_Path"] ?>" style="width: 40%;">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">基本信息</h3>
                            </div>
                            <div class="panel-body">
                                <p><strong>姓名：</strong><?php echo $info["GrMe_Name"] ?></p>
                                <p><strong>职称：</strong><?php echo $info["GrMe_Title"] ?></p>
                                <p><strong>所在高校：</strong><?php echo $info["GrMe_School"] ?></p>
                                <p><strong>研究方向：</strong><?php echo $info["GrMe_Major"] ?></p>
                                <p><strong>电话：</strong><?php echo $info["GrMe_Phone"] ?></p>
                                <p><strong>邮箱：</strong><?php echo $info["GrMe_Email"] ?></p>
                                <p><strong>讲授课程：</strong><?php echo $info["GrMe_Class"] ?></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-offset-1 col-md-10">
                        <div class="panel panel-default">
                            <!--<div class="panel-heading text-center">-->
                            <div class="panel-heading">
                                <h3 class="panel-title">教育背景</h3>
                            </div>
                            <ul class="list-group">
                                <?php
                                $sql = "SELECT * FROM tbl_education WHERE Educ_GrMe_ID='" . $ID . "' ORDER BY Educ_Date";
                                $result = $conn->query($sql);
                                $index = 1; //bootstrap中list-group样式会忽略list-style， 固通过php脚本实现编号
                                if($result->num_rows > 0) {
                                    while($row = $result->fetch_assoc()) {
                                        echo '<li class="list-group-item">[' . $index . ']&nbsp;' . $row["Educ_Date"] . '&nbsp;' . $row["Educ_School"] . '&nbsp;';
                                        echo $row["Educ_Major"] . '&nbsp;' . $row["Educ_Degree"] . '</li>';
                                        $index++;
                                    }
                                }
                                ?>
                            </ul>
                            <!--<div class="panel-body"></div>-->
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-offset-1 col-md-10">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">代表性成果</h3>
                            </div>
                            <ul class="list-group">
                                <?php
                                $sql = "SELECT * FROM tbl_achievement WHERE Achi_GrMe_ID='" . $ID . "'AND Achi_Type='论文' ORDER BY Achi_Date";
                                $result = $conn->query($sql);
                                $index = 1;
                                if($result->num_rows > 0) {
                                    while($row = $result->fetch_assoc()) {
                                        echo '<li class="list-group-item">[' . $index . ']&nbsp;' . $row["Achi_Name"] . '</li>';
                                        $index++;
                                    }
                                }
                                ?>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-offset-1 col-md-10">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">所获荣誉</h3>
                            </div>
                            <ul class="list-group">
                                <?php
                                $sql = "SELECT * FROM tbl_honour WHERE Hono_GrMe_ID='" . $ID . "' ORDER BY Hono_Date";
                                $result = $conn->query($sql);
                                $index = 1;
                                if($result->num_rows > 0) {
                                    while($row = $result->fetch_assoc()) {
                                        echo '<li class="list-group-item">[' . $index . ']&nbsp;' . $row["Hono_Date"] . '&nbsp' . $row["Hono_Name"] . '</li>';
                                        $index++;
                                    }
                                }
                                ?>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-offset-1 col-md-10">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">科研项目</h3>
                            </div>
                            <ul class="list-group">
                                <?php
                                $sql = "SELECT * FROM tbl_achievement WHERE Achi_GrMe_ID='" . $ID . "'AND Achi_Type='纵向项目' ORDER BY Achi_Date";
                                $result = $conn->query($sql);
                                $index = 1;
                                if($result->num_rows > 0) {
                                    while($row = $result->fetch_assoc()) {
                                        echo '<li class="list-group-item">[' . $index . ']&nbsp;' . $row["Achi_Name"] . $row["Achi_Identity"] .  '&nbsp;》纵向</li>';
                                        $index++;
                                    }
                                }

                                $sql = "SELECT * FROM tbl_achievement WHERE Achi_GrMe_ID='" . $ID . "'AND Achi_Type='横向项目' ORDER BY Achi_Date";
                                $result = $conn->query($sql);
                                if($result->num_rows > 0) {
                                    while($row = $result->fetch_assoc()) {
                                        echo '<li class="list-group-item">[' . $index . ']&nbsp;' . $row["Achi_Name"]  . $row["Achi_Identity"] . '&nbsp;》横向</li>';
                                        $index++;
                                    }
                                }
                                ?>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-offset-1 col-md-10">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">招生要求</h3>
                            </div>
                            <ul class="list-group">
                                <li class="list-group-item">
                                <?php echo $info["GrMe_Requirement"] ?>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-offset-1 col-md-10">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">行业经验</h3>
                            </div>
                            <ul class="list-group">
                                <?php
                                $sql = "SELECT * FROM tbl_workexperience WHERE WoEx_GrMe_ID='" . $ID . "' ORDER BY WoEx_Date";
                                $result = $conn->query($sql);
                                $index = 1; //bootstrap中list-group样式会忽略list-style， 固通过php脚本实现编号
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo '<li class="list-group-item">[' . $index . ']&nbsp;' . $row["WoEx_Date"] . '&nbsp' . $row["WoEx_Location"];
                                        echo '&nbsp' . $row["WoEx_Position"] . '&nbsp' . $row["WoEx_Introduction"] . '</li>';
                                        $index++;
                                    }
                                }
                                ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>


<footer role="contentinfo" id="fh5co-footer">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="copyright">
                    <p class="text-center">
                        <small>
                            华中科技大学优化与创新团队
                            <br>地址：华中科技大学管理学院&nbsp;&nbsp;邮编：430070
                            <br>技术支持：韩雄威 联系方式：M201673508@hust.edu.cn
                            <br> &copy; 2016 Edited. All Rights Reserved.
                        </small>
                    </p>
                </div>
            </div>
        </div>
    </div>
</footer>

<!-- Go To Top -->
<a href="#" class="fh5co-gotop fh5co-gotop-c"><i class="ti-shift-left"></i></a>
<a href="../index.php" class="fh5co-gotop back-index" title="返回主页"><i class="ti-home"></i></a>


<!-- jQuery -->
<script src="../js/jquery-1.10.2.min.js"></script>
<!-- jQuery Easing -->
<script src="../js/jquery.easing.1.3.js"></script>
<!-- Bootstrap -->
<script src="../js/bootstrap.js"></script>
<!-- Owl carousel -->
<script src="../js/owl.carousel.min.js"></script>
<!-- Magnific Popup -->
<script src="../js/jquery.magnific-popup.min.js"></script>
<!-- Easy Responsive Tabs -->
<script src="../js/easyResponsiveTabs.js"></script>
<!-- FastClick for Mobile/Tablets -->
<script src="../js/fastclick.js"></script>

<!-- Main JS -->
<script src="../js/main.js"></script>

<?php
$conn->close();
?>
</body>
</html>