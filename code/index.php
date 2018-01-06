<?php
include "config.php";
include "common.php";

$viewCount = countLog();
//有用户访问时，可以将ip记录在$GLOBALS中，如果当前用户的ip已存在，则pass，否则访问量加一，GLOBALS没隔一段时间（10mins）清空一次

//$conn = new mysqli($servername, $username, $password, $dbname);
//$conn->set_charset("utf8"); //avoid the chinese characters to be mistaken
//if($conn->connect_errno)
//    die("连接失败: " . $conn->connect_error);
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
    <title>OI Index</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
    <meta name="description" content="hust optimization and innovation team"/>
    <meta name="keywords" content="optimization"/>
    <meta name="keywords" content="innovation"/>
    <meta name="author" content="HXW"/>

    <!--百度搜索验证-->
    <meta name="baidu-site-verification" content="MP1MZ1lGcJ" />

    <!--清除访问缓存-->
    <META HTTP-EQUIV="Pragma" CONTENT="no-cache">
    <META HTTP-EQUIV="Cache-Control" CONTENT="no-cache">
    <META HTTP-EQUIV="Expires" CONTENT="0">


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
    <!--Fix the same style in all browsers-->
    <!--<link rel="stylesheet" href="css/bootstrap/normalize.css">-->

    <link rel="stylesheet" href="css/stylesHxw.css">

    <style>
        .introduction { margin: 50px auto;}
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

<div id="fh5co-hero" class="imagePartten">
    <a href="#fh5co-main" class="smoothscroll animated bounce fh5co-arrow"><i class="ti-angle-down"></i></a>
    <div class="overlay" style="opacity: 0.75;"></div>
    <div class="container">
        <div class="col-md-8 col-md-offset-2">
            <div class="text">
                <h1>
                    <strong>优化与创新实验室</strong>
                    <!--<em>来自</em>-->
                    <br><strong>华中科技大学管理学院</strong></h1>
            </div>
        </div>
    </div>
</div>

<main role="main" id="fh5co-main">
    <section class="introduction">
        <div class="container">

            <div class="row">
                <div class="col-md-6 col-md-offset-3 text-center">
                    <h2>团队简介</h2>
                </div>
                <div class="fh5co-spacer fh5co-spacer-sm"></div>
                <div class="col-md-12 col-lg-12">
                    <p style="text-indent: 25px;">华中科技大学优化与创新实验室创立于2016年，由华中科技大学管理学院管理科学与工程系秦虎教授、吴庆华教授共同组建。团队发展至今，已发展为一只成熟的团队。团队现拥有博士5名、硕士10名、本科生近20名，与法国昂热大学、香港理工大学、香港城市大学、新加坡国立大学、南京大学、华南理工大学、武汉大学等众多国内外知名高校的学者拥有密切合作。</p>
                    <p style="text-indent: 25px;">团队现横向项目有顺丰航班调度优化、深圳市城市管理监督指挥中心大数据分析等项目。在Management Science、Operations Research、JOC、EJOR等核心期刊上发表论文100余篇。</p>
                </div>
            </div>
            <!--<div class="row">-->
            <!--<div class="col-md-6 col-md-offset-3">-->
            <!--<h2 class="section-heading">Galleries</h2>-->
            <!--</div>-->
            <!--</div>-->
            <!--<div class="row">-->
                <!--<div class="col-md-12 text-center">-->
                    <!--<div><a href="#" class="btn btn-primary">View Full Gallery</a></div>-->
                <!--</div>-->
            <!--</div>-->
        </div>
    </section>

    <section class="feature" style="margin-bottom: 0;">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="icon ti-car"></i>
                        </div>
                        <div class="feature-text">
                            <h3>车辆路径优化</h3>
                            <p>安排运输车辆的行驶路线，使运输车辆依照最短的行驶路径或最短的时间费用，依次服务于每个客户后返回起点，总的运输成本实现最小。</p>
                        </div>
                        <!--作为教授照片展示时使用-->
                        <!--<div class="row">-->
                        <!--<div class="col-md-4 text-center">-->
                        <!--<img src="images/imgTest.png" class="img-thumbnail" style="width: 100%;">-->
                        <!--</div>-->
                        <!--<div class="col-md-8">-->
                        <!--<p>姓名</p>-->
                        <!--<p>简要介绍简要介绍简要介绍简要介绍简要介绍简要介绍简要介绍简要介绍简要介绍简要介绍简要介绍简要介绍简要介绍简要介绍简要介绍简要介绍简要介绍简要介绍</p>-->
                        <!--</div>-->
                        <!--</div>-->
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="icon ti-vector"></i>
                        </div>
                        <div class="feature-text">
                            <h3>算法设计</h3>
                            <p>启发式算法（禁忌搜索、蚁群、遗传）<br>
                                精确算法（分支定界、分支定价）
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="icon ti-reddit"></i>
                        </div>
                        <div class="feature-text">
                            <h3>数据挖掘</h3>
                            <p>从大量的数据中通过算法搜索隐藏于其中信息的过程，通常与计算机科学有关，并通过统计、在线分析处理、情报检索、机器学习、专家系统和模式识别等诸多方法来实现上述目标。</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- END .feature -->

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
                            <br> &copy; 2016 Edited. All Rights Reserved. 页面访问次数：
                            <span id="traffic">
                            <?php
                            //从DB中获取访问量
                            /*$sql = "SELECT * FROM tbl_others WHERE Othe_Name = 'traffic'";
                            $result = $conn->query($sql);
                            echo $result->fetch_assoc()["Othe_Value"];*/
                            echo $viewCount;
                            ?>
                            </span>
                            <a href="admin/login.php">&nbsp;&nbsp;管理员登陆</a>
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

<?php
//$conn->close();
?>
</body>
</html>
