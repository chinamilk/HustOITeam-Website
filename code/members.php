<?php
include "config.php";

$conn = new mysqli($servername, $username, $password, $dbname);
$conn->set_charset("utf8"); //avoid the chinese characters to be mistaken
if($conn->connect_errno)
    die("连接失败: " . $conn->connect_error);
//echo "连接成功";

$member = array("老师"=>array(), "博士生"=>array(), "硕士生"=>array(), "本科生"=>array(), "毕业生"=>array()); //save the members information
//$infoLink = "memberIntroduction?ID=";
//$infoLink = array("teacher" => "members/teacher?ID=", "student" => "members/student?ID=", "studentGraduated" => "members/studentGraduated?ID=");
$infoLink = array("teacher" => "members/teacher.php?ID=", "student" => "members/student.php?ID=");

$sql = "SELECT GrMe_ID, GrMe_Name, GrMe_Type, GrMe_Title, GrMe_EnrolDate, GrMe_Education, GrMe_IsGraduated, GrMe_Path FROM tbl_groupmember";
$result = $conn->query($sql);
if($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $memberInfo = array("ID" => $row["GrMe_ID"], "Name" => $row["GrMe_Name"], "Title" => $row["GrMe_Title"], "Date" => $row["GrMe_EnrolDate"], "Education" => $row["GrMe_Education"], "Path" => $row["GrMe_Path"]);
        if($row["GrMe_Type"] == "老师")
            array_push($member["老师"], $memberInfo);
        else if($row["GrMe_Type"] == "学生") {
            if($row["GrMe_IsGraduated"] == "是")
                array_push($member["毕业生"], $memberInfo);
            else if($row["GrMe_IsGraduated"] == "否") {
                if($row["GrMe_Education"] == "博士")
                    array_push($member["博士生"], $memberInfo);
                else if($row["GrMe_Education"] == "硕士")
                    array_push($member["硕士生"], $memberInfo);
                else if($row["GrMe_Education"] == "本科")
                    array_push($member["本科生"], $memberInfo);
            }
        }
    }
}
//print_r($member);
$conn->close();

function sortByEnrolDate($memberOne, $memberTwo) {
    if($memberOne["Date"] > $memberTwo["Date"])
        return 1;
    else if($memberOne["Date"] < $memberTwo["Date"])
        return -1;
    else
        return 0;
}
?>
<!DOCTYPE html>
<!--[if lt IE 7]>
<html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>
<html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>
<html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js"> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>OI Members</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="hust optimization and innovation team"/>
    <meta name="keywords" content="optimization"/>
    <meta name="keywords" content="innovation"/>
    <meta name="author" content="HXW"/>


    <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
    <link rel="shortcut icon" href="./css/favicon.ico">

    <!-- Themify Icons -->
    <link rel="stylesheet" href="./css/themify-icons.css">
    <!-- Icomoon Icons -->
    <link rel="stylesheet" href="../css/icomoon-icons.css">
    <!-- Bootstrap -->
    <link rel="stylesheet" href="./css/bootstrap.css">
    <!-- Owl Carousel -->
    <link rel="stylesheet" href="./css/owl.carousel.min.css">
    <link rel="stylesheet" href="./css/owl.theme.default.min.css">
    <!-- Magnific Popup -->
    <link rel="stylesheet" href="./css/magnific-popup.css">
    <!-- Easy Responsive Tabs -->
    <link rel="stylesheet" href="./css/easy-responsive-tabs.css">
    <!-- Theme Style -->
    <link rel="stylesheet" href="./css/style.css">
    <link rel="stylesheet" href="./css/user.css">

    <link rel="stylesheet" href="css/stylesHxw.css">

    <style>
        .thumbnail img{ height: 200px;}
    </style>

    <!-- FOR IE9 below -->
    <!--[if lte IE 9]>
    <script src="js/modernizr-2.6.2.min.js"></script>
    <script src="js/respond.min.js"></script>
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
                <a class="navbar-brand" href="index.php">
                    <!--Hust OI-->
                    <img src="images/teamLogoBlackC.png" alt="team logo" style="width:110px;height: 40px;">
                </a>
            </div>
            <div id="fh5co-navbar" class="navbar-collapse collapse">
                <ul class="nav navbar-nav navDefined">
                    <!--<ul class="nav nav-pills">-->
                    <li><a href="news.html"><strong class="navTitle">团队新闻</strong></a></li>
                    <li><a href="achievement.html"><strong class="navTitle">科研成果</strong></a></li>
                    <li><a href="members.php"><strong class="navTitle">团队成员</strong></a></li>
                    <li><a href="awards.php"><strong class="navTitle">团队荣誉</strong></a></li>
                    <li><a href="albums.php"><strong class="navTitle">团队相册</strong></a></li>
                    <li><a href="resources.php"><strong class="navTitle">资源链接</strong></a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <!--<li><a href="intro.html#contact" class="btn btn-calltoaction btn-primary">联系我们</a></li>-->
                    <!--<li><a href="#" class="btn btn-calltoaction btn-primary">联系我们</a></li>-->
                </ul>
            </div>
        </div>
    </nav>

</header>


<div id="fh5co-page-title" class="imagePartten">
    <div class="overlay"></div>
    <div class="container">
        <div class="text">
            <h1>团队成员</h1>
        </div>
    </div>
</div>

<main role="main" id="fh5co-main">
    <div class="container">
        <div class="row">
            <div class="col-md-12" id="fh5co-content">
                <div class="col-md-3 col-xs-12" style="padding-left: 0">
                    <!--<nav id="membersType">-->
                    <ul class="nav nav-pills nav-stacked nav-left">
                        <li class="active left-li-title"><a href="#"><span class="glyphicon glyphicon-th-list"></span>&nbsp;类别</a></li>
                        <li class="active"><a href="#professor"><span class="glyphicon glyphicon-heart"></span>&nbsp;教授</a></li>
                        <li><a href="#doctor"><span class="glyphicon glyphicon-heart-empty"></span>&nbsp;博士生</a></li>
                        <li><a href="#master"><span class="glyphicon glyphicon-heart-empty"></span>&nbsp;硕士生</a></li>
                        <li><a href="#undergraduate"><span class="glyphicon glyphicon-heart-empty"></span>&nbsp;本科生</a></li>
                        <li><a href="#graduate"><span class="glyphicon glyphicon-heart-empty"></span>&nbsp;毕业生</a></li>
                    </ul>
                    <!--</nav>-->
                </div>
                <div class="col-md-9 col-xs-12">
                    <div id="professor">
                        <h2>教授</h2>
                        <div class="row">
                            <?php
                            foreach($member["老师"] as $teacher) {
                                echo '<div class="col-xs-12 col-sm-6 col-md-4"><div class="thumbnail">';
                                echo '<img src="' . $teacher["Path"] . '" alt="' . $teacher["Name"] . '">';
                                echo '<div class="caption text-center"><h3>' . $teacher["Name"] . '<small>' . $teacher["Title"] . '</small></h3><hr>';
                                echo '<a href="' . $infoLink["teacher"] . $teacher["ID"] . '" class="btn btn-primary" role="button">views more</a></div>';
                                echo '</div></div>';
                            }
                            ?>
                        </div>
                        <hr>
                    </div>
                    <div id="doctor">
                        <h2>博士生</h2>
                        <div class="row">
                            <?php
                            //sorting members according to EnrolDate
                            uasort($member["博士生"], "sortByEnrolDate");
                            foreach($member["博士生"] as $doctor) {
                                echo '<div class="col-xs-12 col-sm-6 col-md-4"><div class="thumbnail">';
                                echo '<img src="' . $doctor["Path"] . '" alt="' . $doctor["Name"] . '">';
                                echo '<div class="caption text-center"><h3>' . $doctor["Name"] . '<small>' . $doctor["Date"] . '级' . $doctor["Education"] . '</small></h3><hr>';
                                echo '<a href="' . $infoLink["student"] . $doctor["ID"] . '" class="btn btn-primary" role="button">views more</a></div>';
                                echo '</div></div>';
                            }
                            ?>
                        </div>
                        <br>
                        <hr>
                    </div>
                    <div id="master">
                        <h2>硕士生</h2>
                        <div class="row">
                            <?php
                            //sorting members according to EnrolDate
                            uasort($member["硕士生"], "sortByEnrolDate");
                            foreach($member["硕士生"] as $master) {
                                echo '<div class="col-xs-12 col-sm-6 col-md-4"><div class="thumbnail">';
                                echo '<img src="' . $master["Path"] . '" alt="' . $master["Name"] . '">';
                                echo '<div class="caption text-center"><h3>' . $master["Name"] . '<small>' . $master["Date"] . '级' . $master["Education"] . '</small></h3><hr>';
                                echo '<a href="' . $infoLink["student"] . $master["ID"] . '" class="btn btn-primary" role="button">views more</a></div>';
                                echo '</div></div>';
                            }
                            ?>
                        </div>
                        <br>
                        <hr>
                    </div>
                    <div id="undergraduate">
                        <h2>本科生</h2>
                        <div class="row">
                            <?php
                            //sorting members according to EnrolDate
                            uasort($member["本科生"], "sortByEnrolDate");
                            foreach($member["本科生"] as $undergraduate) {
                                echo '<div class="col-xs-12 col-sm-6 col-md-4"><div class="thumbnail">';
                                echo '<img src="' . $undergraduate["Path"] . '" alt="' . $undergraduate["Name"] . '">';
                                echo '<div class="caption text-center"><h3>' . $undergraduate["Name"] . '<small>' . $undergraduate["Date"] . '级' . $undergraduate["Education"] . '</small></h3><hr>';
                                echo '<a href="' . $infoLink["student"] . $undergraduate["ID"] . '" class="btn btn-primary" role="button">views more</a></div>';
                                echo '</div></div>';
                            }
                            ?>
                        </div>
                        <br>
                        <hr>
                    </div>
                    <div id="graduate">
                        <h2>毕业生</h2>
                        <div class="row">
                            <?php
                            //sorting members according to EnrolDate
                            uasort($member["毕业生"], "sortByEnrolDate");
                            foreach($member["毕业生"] as $graduate) {
                                echo '<div class="col-xs-12 col-sm-6 col-md-4"><div class="thumbnail">';
                                echo '<img src="' . $graduate["Path"] . '" alt="' . $graduate["Name"] . '">';
                                echo '<div class="caption text-center"><h3>' . $graduate["Name"] . '<small>' . $graduate["Date"] . '级' . $graduate["Education"] . '</small></h3><hr>';
                                echo '<a href="' . $infoLink["student"] . $graduate["ID"] . '" class="btn btn-primary" role="button">views more</a></div>';
                                echo '</div></div>';
                            }
                            ?>
                        </div>
                        <br>
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
<a href="index.php" class="fh5co-gotop back-index" title="返回主页"><i class="ti-home"></i></a>


<!-- jQuery -->
<script src="js/jquery-1.10.2.min.js"></script>
<!-- jQuery Easing -->
<script src="js/jquery.easing.1.3.js"></script>
<!-- Bootstrap -->
<script src="js/bootstrap.js"></script>
<!-- Owl carousel -->
<script src="js/owl.carousel.min.js"></script>
<!-- Magnific Popup -->
<script src="js/jquery.magnific-popup.min.js"></script>
<!-- Easy Responsive Tabs -->
<script src="js/easyResponsiveTabs.js"></script>
<!-- FastClick for Mobile/Tablets -->
<script src="js/fastclick.js"></script>

<!-- Main JS -->
<script src="js/main.js"></script>

<!--Custom JS-->
<script>
    $(function() {
        $(".nav-left li").click(function() {
            var index = $(".nav-left li").index(this);
            if(index != 0) {
                $(this).addClass("active");
                $(this).siblings().removeClass("active");
                $(this).find("span").removeClass("glyphicon-heart-empty").addClass("glyphicon-heart");
                $(this).siblings().find("span").removeClass("glyphicon-heart").addClass("glyphicon-heart-empty");
                $(".left-li-title").addClass("active").find("span").removeClass("glyphicon-heart").removeClass("glyphicon-heart-empty").addClass("glyphicon-th-list");

            }
        });
    });
</script>

</body>
</html>