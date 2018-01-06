<?php

include "../../../common.php";
include "../../../config.php";

session_start();
$backPath = "../../../"; //backPath是返回顶层目录需要的层数，path为存储目录（从顶层开始）
licenseJudge($backPath);

$conn = new mysqli($servername, $username, $password, $dbname);
$conn->set_charset("utf8"); //avoid the chinese characters to be mistaken
if ($conn->connect_errno)
    die("连接失败: " . $conn->connect_error);
//echo "连接成功";
$reflection = memberId2name($conn);
$conn->close();

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn = new mysqli($servername, $username, $password, $dbname);
    $conn->set_charset("utf8"); //avoid the chinese characters to be mistaken
    if ($conn->connect_errno)
        die("连接失败: " . $conn->connect_error);
    //echo "连接成功";

    $stmt = $conn->prepare("INSERT INTO tbl_workexperience VALUES(?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $id, $date, $location, $position, $introduction, $memberId);

    $id = createGuid();
    $date = checkInput($_POST["date"]);
    $location = checkInput($_POST["location"]);
    $position = checkInput($_POST["position"]);
    $introduction = checkInput($_POST["introduction"]);
    $memberId = checkInput($_POST["member"]);

    $stmt->execute();

    $stmt->close();
    $conn->close();
}

function checkInput($data) {
    $data = htmlspecialchars($data);
    return $data;
}
?>

<!DOCTYPE html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
    <meta name="description" content="hust optimization and innovation team"/>
    <meta name="keywords" content="optimization"/>
    <meta name="keywords" content="innovation"/>
    <meta name="author" content="HXW"/>

    <title>Add Member Work Experience Info</title>

    <!-- Bootstrap Core CSS -->
    <link href="../../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- MetisMenu CSS -->
    <link href="../../vendor/metisMenu/metisMenu.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="../../dist/css/sb-admin-2.css" rel="stylesheet">
    <!-- Morris Charts CSS -->
    <!--<link href="vendor/morrisjs/morris.css" rel="stylesheet">-->
    <!-- Custom Fonts -->
    <link href="../../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <link href="../../css/styleBehindHxw.css" rel="stylesheet" type="text/css">

    <style>
        .form-group p{ color: #ff2e0e;}
    </style>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>

<div id="wrapper">

    <!-- Navigation -->
    <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="../../../index.php">
                <img src="../../../images/teamLogoBlackC.png" alt="team logo" style="width:90px;height: 30px;">
            </a>
            <a class="navbar-brand" href="../../../index.php" style="font-size: 24px;"><strong>Hust优化与创新团队</strong></a>
        </div>

        <div class="navbar-default sidebar" role="navigation">
            <div class="sidebar-nav navbar-collapse">
                <ul class="nav" id="side-menu">
                    <li>
                        <!--fa是一种font图标格式，到时候换取-->
                        <a href="../../index.php"><i class="fa fa-home fa-fw"></i> 主页</a>
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-male fa-fw"></i> 成员信息<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a href="#"><i class="fa fa-info fa-fw"></i> 基本信息<span class="fa arrow"></span></a>
                                <ul class="nav nav-third-level">
                                    <li><a href="../info/view.php"><i class="fa fa-search fa-fw"></i> 查询</a></li>
                                    <li><a href="../info/add.php"><i class="fa fa-plus-circle fa-fw"></i> 添加</a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="#"><i class="fa fa-graduation-cap fa-fw"></i> 教育信息<span
                                        class="fa arrow"></span></a>
                                <ul class="nav nav-third-level">
                                    <li><a href="../education/view.php"><i class="fa fa-search fa-fw"></i> 查询</a></li>
                                    <li><a href="../education/add.php"><i class="fa fa-plus-circle fa-fw"></i> 添加</a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="#"><i class="fa fa-gittip fa-fw"></i> 荣誉信息<span class="fa arrow"></span></a>
                                <ul class="nav nav-third-level">
                                    <li><a href="../honour/view.php"><i class="fa fa-search fa-fw"></i> 查询</a></li>
                                    <li><a href="../honour/add.php"><i class="fa fa-plus-circle fa-fw"></i> 添加</a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="#"><i class="fa fa-list fa-fw"></i> 项目成果<span class="fa arrow"></span></a>
                                <ul class="nav nav-third-level">
                                    <li><a href="../achievement/view.php"><i class="fa fa-search fa-fw"></i> 查询</a></li>
                                    <li><a href="../achievement/add.php"><i class="fa fa-plus-circle fa-fw"></i> 添加</a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="#"><i class="fa fa-group fa-fw"></i> 实践、工作<span class="fa arrow"></span></a>
                                <ul class="nav nav-third-level">
                                    <li><a href="view.php"><i class="fa fa-search fa-fw"></i> 查询</a></li>
                                    <li><a href="add.php"><i class="fa fa-plus-circle fa-fw"></i> 添加</a></li>
                                </ul>
                            </li>
                        </ul>
                        <!-- /.nav-second-level -->
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-star fa-fw"></i> 团队荣誉<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li><a href="../../group/honour/view.php"><i class="fa fa-search fa-fw"></i> 查询<span class="fa arrow"></span></a></li>
                            <li><a href="../../group/honour/add.php"><i class="fa fa-plus-circle fa-fw"></i> 添加<span class="fa arrow"></span></a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-photo fa-fw"></i> 团队相册<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li><a href="../../group/album/view.php"><i class="fa fa-search fa-fw"></i> 查询<span class="fa arrow"></span></a></li>
                            <li><a href="../../group/album/add.php"><i class="fa fa-plus-circle fa-fw"></i> 添加<span class="fa arrow"></span></a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-edit fa-fw"></i> 团队新闻<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li><a href="../../group/news/view.php"><i class="fa fa-search fa-fw"></i> 查询<span class="fa arrow"></span></a></li>
                            <li><a href="../../group/news/add.php"><i class="fa fa-plus-circle fa-fw"></i> 添加<span class="fa arrow"></span></a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-link fa-fw"></i> 团队资源<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li><a href="../../group/resource/view.php"><i class="fa fa-search fa-fw"></i> 查询<span class="fa arrow"></span></a></li>
                            <li><a href="../../group/resource/add.php"><i class="fa fa-plus-circle fa-fw"></i> 添加<span class="fa arrow"></span></a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
            <!-- /.sidebar-collapse -->
        </div>
    </nav>

    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">添加成员实践、实习、工作经历信息</h1>
                <form id="myForm" role="form" id="myForm" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype="multipart/form-data">
                    <div class="form-group">
                        <label>成员姓名*</label>
                        <select class="form-control" name="member" id="member">
                            <?php
                            foreach ($reflection as $id => $name) {
                                echo '<option value="' . $id . '">' . $name . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>时间*</label>
                        <input class="form-control" name="date" id="date" placeholder="格式：YYYY.MM-YYYY.MM">
                        <p class="help-block"></p>
                    </div>
                    <div class="form-group">
                        <label>地点</label>
                        <input class="form-control" name="location" id="location">
                        <p class="help-block"></p>
                    </div>
                    <div class="form-group">
                        <label>岗位</label>
                        <input class="form-control" name="position" id="position">
                        <p class="help-block"></p>
                    </div>
                    <div class="form-group">
                        <label>简介</label>
                        <textarea class="form-control" name="introduction" id="introduction"></textarea>
                        <p class="help-block"></p>
                    </div>
                    <hr>
                    <button type="submit" class="btn btn-primary">添加</button>
                    <button type="reset" class="btn btn-primary">清空</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- jQuery -->
<script src="../../vendor/jquery/jquery.min.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="../../vendor/bootstrap/js/bootstrap.min.js"></script>

<!-- Metis Menu Plugin JavaScript -->
<script src="../../vendor/metisMenu/metisMenu.min.js"></script>

<!-- Custom Theme JavaScript -->
<script src="../../dist/js/sb-admin-2.js"></script>

<!--Validate JavaScript-->
<script src="../../vendor/validate/jquery.validate.min.js"></script>
<script src="../../vendor/validate/messages_zh.min.js"></script>

<!--Myself Js-->
<script>
    $(function(){
        var validate = $('#myForm').validate({
            errorPlacement: function(error, element) {
                //这里不能用text，用append
                $(element).parent().find(".help-block").html(error);
            },
            errorElement: "span",
            rules: {
                date: "required"
                //,location: "required"
                //,position: "required"
            },
            messages: {
                date: "请输入时间"
                //,location: "请输入工作地点"
                //,position: "请输入岗位"
            }
        });

        /*$("form").submit(function () {
            if($(this).valid()) {
                alert("添加成功");
            }
        });*/
    })
</script>

</body>
</html>