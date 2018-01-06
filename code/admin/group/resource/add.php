<?php

ini_set('date.timezone','Asia/Shanghai'); //不添加这句话会提示PHP Warning:  date(): It is not safe to rely on the system's timezone settings
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

    $stmt = $conn->prepare("INSERT INTO tbl_resource VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssssss", $id, $type, $name, $date, $introduction, $downlands, $filePath, $password, $memberId);

    $id = createGuid();
    $type = checkInput($_POST["type"]);
    $name = checkInput($_POST["name"]);
    $date = date("Y/m/d");
    $introduction = checkInput($_POST["introduction"]);
    $downlands = 0; //初始下载次数为0
    $password = checkInput($_POST["password"]);
    $memberId = checkInput($_POST["member"]);

    //文件上传操作(仅数据、课件需要上传文件，链接不用)
    //backPath是返回顶层目录需要的层数，path为存储目录（从顶层开始）
    if(isset($_FILES["file"]) == true && $_FILES["file"]["name"] != "") {
        //$backPath = "../../../";
        $path = "resources/";

        $allowedExts = array("pdf", "zip", "rar", "doc", "docx", "ppt", "pptx", "xls", "xlsx", "txt", "mat");
        $temp = explode(".", $_FILES["file"]["name"]);
        $extension = end($temp);     // 获取文件后缀名
        //文件最大仅支持10MB, 类型也存在限制
        if (($_FILES["file"]["size"] < 20480000) && in_array($extension, $allowedExts))
        {
            if ($_FILES["file"]["error"] > 0) {
                die("update file error:" . $_FILES["file"]["error"]);
            }
            if (file_exists($path . $_FILES["file"]["name"])) {
                die($_FILES["file"]["name"] . " 文件已经存在。 ");
            } else {
                //move_uploaded_file($_FILES["file"]["tmp_name"], $path . $_FILES["file"]["name"]);
                move_uploaded_file($_FILES["file"]["tmp_name"], $backPath . $path . $id . "." . $extension);
            }
        } else {
            die("文件仅支持20MB以下，格式为pdf/zip/rar/doc/docx/ppt/pptx/xls/xlsx/txt/mat");
        }
        $filePath = checkInput($path . $id . "." . $extension);
    } else
        $filePath = "";

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

    <title>Add Group Resource</title>

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
                                    <li><a href="../../individual/info/view.php"><i class="fa fa-search fa-fw"></i>
                                            查询</a></li>
                                    <li><a href="../../individual/info/add.php"><i class="fa fa-plus-circle fa-fw"></i>
                                            添加</a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="#"><i class="fa fa-graduation-cap fa-fw"></i> 教育信息<span
                                        class="fa arrow"></span></a>
                                <ul class="nav nav-third-level">
                                    <li><a href="../../individual/education/view.php"><i class="fa fa-search fa-fw"></i>
                                            查询</a></li>
                                    <li><a href="../../individual/education/add.php"><i
                                                class="fa fa-plus-circle fa-fw"></i> 添加</a></li>
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
                                    <li><a href="../../individual/achievement/view.php"><i
                                                class="fa fa-search fa-fw"></i> 查询</a></li>
                                    <li><a href="../../individual/achievement/add.php"><i
                                                class="fa fa-plus-circle fa-fw"></i> 添加</a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="#"><i class="fa fa-group fa-fw"></i> 实践、工作<span class="fa arrow"></span></a>
                                <ul class="nav nav-third-level">
                                    <li><a href="../../individual/workexperience/view.php"><i
                                                class="fa fa-search fa-fw"></i> 查询</a></li>
                                    <li><a href="../../individual/workexperience/add.php"><i
                                                class="fa fa-plus-circle fa-fw"></i> 添加</a></li>
                                </ul>
                            </li>
                        </ul>
                        <!-- /.nav-second-level -->
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-star fa-fw"></i> 团队荣誉<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li><a href="../honour/view.php"><i class="fa fa-search fa-fw"></i> 查询<span class="fa arrow"></span></a></li>
                            <li><a href="../honour/add.php"><i class="fa fa-plus-circle fa-fw"></i> 添加<span class="fa arrow"></span></a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-photo fa-fw"></i> 团队相册<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li><a href="../album/view.php"><i class="fa fa-search fa-fw"></i> 查询<span
                                        class="fa arrow"></span></a></li>
                            <li><a href="../album/add.php"><i class="fa fa-plus-circle fa-fw"></i> 添加<span
                                        class="fa arrow"></span></a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-edit fa-fw"></i> 团队新闻<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li><a href="../news/view.php"><i class="fa fa-search fa-fw"></i> 查询<span class="fa arrow"></span></a></li>
                            <li><a href="../news/add.php"><i class="fa fa-plus-circle fa-fw"></i> 添加<span class="fa arrow"></span></a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-link fa-fw"></i> 团队资源<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li><a href="../resource/view.php"><i class="fa fa-search fa-fw"></i> 查询<span class="fa arrow"></span></a></li>
                            <li><a href="../resource/add.php"><i class="fa fa-plus-circle fa-fw"></i> 添加<span class="fa arrow"></span></a>
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
                <h1 class="page-header">添加团队资源信息</h1>
                <form id="myForm" role="form" id="myForm" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype="multipart/form-data">
                    <div class="form-group">
                        <label>类别*</label>
                        <div class="radio">
                            <label class="radio-inline">
                                <input type="radio" name="type" id="rTypeData" value="数据" checked>数据
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="type" id="rTypeFile" value="课件">课件
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="type" id="rTypeLink" value="链接">链接
                            </label>
                        </div>
                        <p class="help-block"></p>
                    </div>
                    <div class="form-group">
                        <label>资源名称*</label>
                        <input class="form-control" name="name" id="name">
                        <p class="help-block"></p>
                    </div>
                    <div class="form-group">
                        <label>资源简介*</label>
                        <input class="form-control" name="introduction" id="introduction">
                        <p class="help-block"></p>
                    </div>
                    <div class="form-group">
                        <label>上传成员*</label>
                        <select class="form-control" name="member" id="member">
                            <?php
                            foreach ($reflection as $id => $name) {
                                echo '<option value="' . $id . '">' . $name . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>加密选项*</label>
                        <div class="radio">
                            <label class="radio-inline">
                                <input type="radio" name="isEncrypt" id="isEncrDefault" value="默认" checked>默认
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="isEncrypt" id="isEncrDefine" value="自设">自设
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="isEncrypt" id="isEncrNone" value="公开">公开
                            </label>
                        </div>
                        <p class="help-block"></p>
                    </div>
                    <div class="form-group">
                        <label>资源密码*</label>
                        <input class="form-control" name="password" id="password" value="hustoiteam" readonly>
                        <p class="help-block"></p>
                    </div>
                    <div class="form-group">
                        <label>文件上传</label>
                        <input type="file" name="file" id="file" value="">
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
                name: "required"
            },
            messages: {
                name: "请输入资源名称"
            }
        });

        /*$("form").submit(function () {
            if($(this).valid()) {
                alert("添加成功");
            }
        });*/

        $('input[name = "isEncrypt"]').change(function () {
            var selectedValue = $('input[name = "isEncrypt"]:checked').val();
            if(selectedValue == "默认") {
                $('#password').val("hustoiteam").attr("readonly", true);
            } else if(selectedValue == "自设") {
                $('#password').val("").attr("readonly", false);
            } else if(selectedValue == "公开") {
                $('#password').val("").attr("readonly", true);
            }
        });

        $('input[name = "type"]').change(function () {
            var selectedValue = $('input[name = "type"]:checked').val();
            if(selectedValue == "数据" || selectedValue == "课件") {
                $('#file').attr("disabled", false);
            } else if(selectedValue == "链接") {
                $('#file').val("").attr("disabled", true);
            }
        });
    })
</script>

</body>
</html>