<?php
include "config.php";
$conn = new mysqli($servername, $username, $password, $dbname);
$conn->set_charset("utf8"); //avoid the chinese characters to be mistaken
if($conn->connect_errno)
    die("连接失败: " . $conn->connect_error);
//echo "连接成功";

$resource = array("课件" => array(), "数据" => array(), "链接" => array());
//$link = array("data" => "resources/datas/", "file" => "resources/files/");

$sql = "SELECT * FROM tbl_resource ORDER BY Reso_Date";
$result = $conn->query($sql);
//fetch_assoc() 是以array()的形式返回结果，故不需要单独再创建一个array()，可直接存储
if($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        if($row["Reso_Type"] == "课件")
            array_push($resource["课件"], $row);
        else if($row["Reso_Type"] == "数据")
            array_push($resource["数据"], $row);
        else
            array_push($resource["链接"], $row);
    }
}

//预处理——查询上转者姓名
$stmt = $conn->prepare("SELECT GrMe_Name FROM tbl_groupmember WHERE GrMe_ID = ?");
$stmt->bind_param("s", $memberId);
$stmt->bind_result($memberName);
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
    <title>OI Resources</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="big data and algorithm laboratory"/>
    <meta name="keywords" content="laboratory"/>
    <meta name="author" content="ZZZ&WY"/>


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
        body{ word-break: break-all;}
        .downLoad { height: 24px;padding: 0; line-height: 24px; }
        .enrol { font-size: 14px; text-indent: 25px; }
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
            <h1>资源共享</h1>
        </div>
    </div>
</div>

<main role="main" id="fh5co-main">
    <div class="container" id="content-col-2">

        <div class="col-md-4 content-list">
            <ul class="fh5co-links">
                <h3><strong>数据分享</strong></h3>
                <?php
                foreach ($resource["数据"] as $data) {
                    //根据ID，查询上传者姓名
                    $memberId = $data["Reso_GrMe_ID"];
                    $stmt->execute();
                    $stmt->fetch();//memberId 唯一，故只存在一条数据
                    echo '<li><p style="margin: 0;"><strong>' . $data["Reso_Name"] . '</strong><br><small>上传者：<span>' . $memberName;
                    echo '</span>&nbsp;<span>，上传时间：' . $data["Reso_Date"] . '</span></small></p>';
                    echo '<p class="enrol">' . $data["Reso_Introduction"] . '</p>';
                    //echo '<a class="download" href="' . $link["data"] . $data["Reso_ID"] . '.' . $data["Reso_Extension"] . '">Download</a>';
                    echo '<a class="download" id="' . $data["Reso_ID"] . '" href="' . $data["Reso_Path"] . '">Download</a>';
                    echo '<small class="pull-right">下载次数：' . $data["Reso_Downlands"] . '</small></li>';
                }
                ?>
            </ul>
        </div>

        <div class="col-md-4 content-list">
            <ul class="fh5co-links">
                <h3><strong>课件分享</strong></h3>
                <?php
                foreach ($resource["课件"] as $file) {
                    //根据ID，查询上传者姓名
                    $memberId = $file["Reso_GrMe_ID"];
                    $stmt->execute();
                    $stmt->fetch();//memberId 唯一，故只存在一条数据
                    echo '<li><p style="margin: 0;"><strong>' . $file["Reso_Name"] . '</strong><br><small>上传者：<span>' . $memberName;
                    echo '</span>&nbsp;<span>，上传时间：' . $file["Reso_Date"] . '</span></small></p>';
                    echo '<p class="enrol">' . $file["Reso_Introduction"] . '</p>';
                    //echo '<a class="download" href="' . $link["file"] . $file["Reso_ID"] . '.' . $file["Reso_Extension"] . '">Download</a>';
                    echo '<a class="download" id="' . $file["Reso_ID"] . '" href="' . $file["Reso_Path"] . '">Download</a>';
                    echo '<small class="pull-right">下载次数：' . $file["Reso_Downlands"] . '</small></li>';
                }
                ?>
            </ul>
        </div>

        <div class="col-md-4 content-list">
            <ul class="fh5co-links">
                <h3><strong>链接分享</strong></h3>
<!--                <li>-->
<!--                    <p style="margin: 0;"><a herf="#">VRP数据</a>-->
<!--                        <small class="pull-right"><span>韩雄威</span>&nbsp;<span>2016/01/01</span></small>-->
<!--                    </p>-->
<!--                    <p>这里是介绍，这里是介绍，这里是介绍，这里是介绍这里是介绍这里是介绍这里是介绍这里是介绍。</p>-->
<!--                </li>-->
                <?php
                foreach ($resource["链接"] as $link) {
                    //根据ID，查询上传者姓名
                    $memberId = $link["Reso_GrMe_ID"];
                    $stmt->execute();
                    $stmt->fetch();//memberId 唯一，故只存在一条数据
                    echo '<li><p style="margin: 0;"><strong>' . $link["Reso_Name"] . '</strong><br><small>上传者：<span>' . $memberName;
                    echo '</span>&nbsp;<span>，上传时间：' . $link["Reso_Date"] . '</span></small></p>';
                    echo '<p class="enrol">' . $link["Reso_Introduction"] . '</p></li>';
                }
                ?>
                <li></li>
            </ul>
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

<!--Myself JS-->
<script>
    $(function () {
        $('.download').click(function () {
            var resourceId = $(this).attr("id");
            $.ajax({
                url: "operations/addCount.php",
                type: "POST",
                data: {id: resourceId, tableName: "resource", attribute: "Downlands"},
                dataType: "html",
                error: function() {
                    //alert('Error loading PHP document');
                },
                success: function(result) {
                    //window.location.reload();
                }
            });
        });
    })
</script>
<?php
//不要将关闭数据库连接的code放在/html后，页面会加载不出来
$stmt->close();
$conn->close();
?>
</body>
</html>