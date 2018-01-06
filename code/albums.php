<?php
include "config.php";

$conn = new mysqli($servername, $username, $password, $dbname);
$conn->set_charset("utf8"); //avoid the chinese characters to be mistaken
if($conn->connect_errno)
    die("连接失败: " . $conn->connect_error);

$sql = "SELECT * FROM tbl_album ORDER BY Albu_Date DESC";
$result = $conn->query($sql);
$conn->close();
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
    <title>OI Albums</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="hust optimization and innovation team"/>
    <meta name="keywords" content="optimization"/>
    <meta name="keywords" content="innovation"/>
    <meta name="author" content="HXW"/>


    <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
    <link rel="shortcut icon" href="favicon.ico">

    <!-- Themify Icons -->
    <link rel="stylesheet" href="css/themify-icons.css">
    <!-- Icomoon Icons -->
    <link rel="stylesheet" href="css/icomoon-icons.css">
    <!-- Bootstrap -->
    <link rel="stylesheet" href="css/bootstrap.css">
    <!-- Owl Carousel -->
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="css/owl.theme.default.min.css">
    <!-- Magnific Popup -->
    <link rel="stylesheet" href="css/magnific-popup.css">
    <!-- Easy Responsive Tabs -->
    <link rel="stylesheet" href="css/easy-responsive-tabs.css">
    <!-- Theme Style -->
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/user.css">

    <link rel="stylesheet" href="css/stylesHxw.css">

    <style>
        .thumbnail img{width: 100%; height: 100%; min-height: 200px;}
        /*h4{display: inline-block;}*/
        h4{margin-bottom: 0;}
        .caption{font-size: 14px; height: 150px;}
        @media screen and (min-width: 768px) {
            .thumbnail img{max-height: 160px;}
        }
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


<div id="fh5co-page-title" style="margin-bottom: 0;" class="imagePartten">
    <div class="overlay"></div>
    <div class="container">
        <div class="text">
            <h1>团队相册</h1>
        </div>
    </div>
</div>

<main role="main" id="fh5co-main">
    <div class="container">
        <div class="row">
            <?php
            if($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo '<div class="col-sm-6 col-md-3"><div class="thumbnail">';
                    echo '<img src="' . $row["Albu_Path"] . '"alt="' . $row["Albu_Title"] . '">';
                    echo '<div class="caption"><h4>' . $row["Albu_Title"] . '</h4><span class="pull-right">[' . $row["Albu_Date"] . ']</span><br><p>';
                    echo $row["Albu_Introduction"] . '</p></div></div></div>';
                }
            }
            ?>
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

</body>
</html>