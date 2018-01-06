<?php

include "../../../common.php";
include "../../../config.php";

session_start();
$backPath = "../../../"; //backPath是返回顶层目录需要的层数，path为存储目录（从顶层开始）
licenseJudge($backPath);

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn = new mysqli($servername, $username, $password, $dbname);
    $conn->set_charset("utf8"); //avoid the chinese characters to be mistaken
    if ($conn->connect_errno)
        die("连接失败: " . $conn->connect_error);
    //echo "连接成功";

    $stmt = $conn->prepare("INSERT INTO tbl_groupmember VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssssssssssss", $id, $name, $type, $title, $enrolDate, $education, $school, $isGraduated, $job, $major, $phone, $email, $skill, $class, $requirement, $photoPath);

    $id = createGuid();
    $name = checkInput($_POST["name"]);
    $type = checkInput($_POST["type"]);
    $title = checkInput($_POST["title"]);
    $enrolDate = checkInput($_POST["enrolDate"]);
    $education = checkInput($_POST["education"]);
    $school = checkInput($_POST["school"]);
    $isGraduated = checkInput($_POST["isGraduated"]);
    $job = checkInput($_POST["job"]);
    $major = checkInput($_POST["major"]);
    $phone = checkInput($_POST["phone"]);
    $email = checkInput($_POST["email"]);
    $skill = checkInput($_POST["skill"]);
    $class = checkInput($_POST["class"]);
    $requirement = checkInput($_POST["requirement"]);

    //照片上传操作
    if($type == "老师") {
        $path = "images/members/teachers/";
    } else if($type == "学生") {
        $path = "images/members/students/";
    }

    $allowedExts = array("gif", "jpeg", "jpg", "png");
    $temp = explode(".", $_FILES["photo"]["name"]);
    $extension = end($temp);     // 获取文件后缀名
    if ((($_FILES["photo"]["type"] == "image/gif") || ($_FILES["photo"]["type"] == "image/jpeg") || ($_FILES["photo"]["type"] == "image/jpg")
            || ($_FILES["photo"]["type"] == "image/pjpeg") || ($_FILES["photo"]["type"] == "image/x-png") || ($_FILES["photo"]["type"] == "image/png"))
        && ($_FILES["photo"]["size"] < 2048000)   // 小于 2mb
        && in_array(strtolower($extension), $allowedExts))  //是gif, jpeg, jpg, png ...这几种格式时
    {
        if ($_FILES["photo"]["error"] > 0) {
            die("update photo error:" . $_FILES["photo"]["error"]);
        }
        if (file_exists($path . $_FILES["photo"]["name"]))
        {
            die($_FILES["photo"]["name"] . " 文件已经存在。 ");
        } else {
            //move_uploaded_file($_FILES["photo"]["tmp_name"], $path . $_FILES["photo"]["name"]);
            move_uploaded_file($_FILES["photo"]["tmp_name"], $backPath . $path . $id . "." . $extension);
        }
    } else {
        die("照片仅支持2MB以下，格式为gif/jpg/jpeg/png");
    }
    $photoPath = checkInput($path . $id . "." . $extension);

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

    <title>Add Member</title>

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
                                    <li><a href="view.php"><i class="fa fa-search fa-fw"></i> 查询</a></li>
                                    <li><a href="add.php"><i class="fa fa-edit fa-fw"></i> 添加</a></li>
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
                                    <li><a href="../workexperience/view.php"><i class="fa fa-search fa-fw"></i> 查询</a></li>
                                    <li><a href="../workexperience/add.php"><i class="fa fa-plus-circle fa-fw"></i> 添加</a></li>
                                </ul>
                            </li>
                        </ul>
                        <!-- /.nav-second-level -->
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-star fa-fw"></i> 团队荣誉<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li><a href="../../group/honour/view.php"><i class="fa fa-search fa-fw"></i> 查询<span
                                            class="fa arrow"></span></a></li>
                            <li><a href="../../group/honour/add.php"><i class="fa fa-plus-circle fa-fw"></i> 添加<span
                                            class="fa arrow"></span></a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-photo fa-fw"></i> 团队相册<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li><a href="../../group/album/view.php"><i class="fa fa-search fa-fw"></i> 查询<span
                                            class="fa arrow"></span></a></li>
                            <li><a href="../../group/album/add.php"><i class="fa fa-plus-circle fa-fw"></i> 添加<span
                                            class="fa arrow"></span></a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-edit fa-fw"></i> 团队新闻<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li><a href="../../group/news/view.php"><i class="fa fa-search fa-fw"></i> 查询<span
                                            class="fa arrow"></span></a></li>
                            <li><a href="../../group/news/add.php"><i class="fa fa-plus-circle fa-fw"></i> 添加<span
                                            class="fa arrow"></span></a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-link fa-fw"></i> 团队资源<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li><a href="../../group/resource/view.php"><i class="fa fa-search fa-fw"></i> 查询<span
                                            class="fa arrow"></span></a></li>
                            <li><a href="../../group/resource/add.php"><i class="fa fa-plus-circle fa-fw"></i> 添加<span
                                            class="fa arrow"></span></a>
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
                <h1 class="page-header">添加成员信息</h1>
                <form role="form" id="myForm" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype="multipart/form-data">
                    <div class="form-group">
                        <label>姓名*</label>
                        <input class="form-control" name="name" id="name">
                        <p class="help-block"></p>
                    </div>
                    <div class="form-group">
                        <label>类别*</label>
                        <div class="radio">
                            <label class="radio-inline">
                                <input type="radio" name="type" id="rTypeTeacher" value="老师" checked>老师
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="type" id="rTypeStudent" value="学生">学生
                            </label>
                        </div>
                        <p class="help-block"></p>
                    </div>
                    <div class="form-group">
                        <label>职称</label>
                        <input class="form-control" name="title" id="title">
                        <p class="help-block"></p>
                    </div>
                    <div class="form-group">
                        <label>入学年份</label>
                        <input class="form-control" name="enrolDate" id="enrolDate" readonly>
                        <p class="help-block"></p>
                    </div>
                    <div class="form-group">
                        <label>最高学历*</label>
                        <input class="form-control" name="education" id="education" placeholder="博士/硕士/本科">
                        <p class="help-block"></p>
                    </div>
                    <div class="form-group">
                        <label>所在高校</label>
                        <input class="form-control" name="school" id="school">
                        <p class="help-block"></p>
                    </div>
                    <div class="form-group">
                        <label>是否毕业</label>
                        <div class="radio">
                            <label class="radio-inline">
                                <input type="radio" name="isGraduated" id="rGradYes" value="是">是
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="isGraduated" id="rGradNo" value="否">否
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="isGraduated" id="rGradNone" value="" checked>不填
                            </label>
                        </div>
                        <p class="help-block"></p>
                    </div>
                    <div class="form-group">
                        <label>毕业去向</label>
                        <input class="form-control" name="job" id="job" readonly>
                        <p class="help-block"></p>
                    </div>
                    <div class="form-group">
                        <label>研究方向</label>
                        <input class="form-control" name="major" id="major">
                        <p class="help-block"></p>
                    </div>
                    <div class="form-group">
                        <label>联系方式</label>
                        <input class="form-control" name="phone" id="phone">
                        <p class="help-block"></p>
                    </div>
                    <div class="form-group">
                        <label>邮箱</label>
                        <input class="form-control" name="email" id="email">
                        <p class="help-block"></p>
                    </div>
                    <div class="form-group">
                        <label>技能掌握</label>
                        <input class="form-control" name="skill" id="skill" placeholder="50字以内" readonly>
                        <p class="help-block"></p>
                    </div>
                    <div class="form-group">
                        <label>讲授课程</label>
                        <input class="form-control" name="class" id="class" placeholder="50字以内">
                        <p class="help-block"></p>
                    </div>
                    <div class="form-group">
                        <label>招生要求</label>
                        <textarea class="form-control" name="requirement" id="requirement"></textarea>
                        <p class="help-block"></p>
                    </div>
                    <div class="form-group">
                        <label>照片上传*（支持jpg/jpeg/png/gif，大小不超过2MB）</label>
                        <input type="file" name="photo" id="photo">
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
    /*$.validator.setDefaults({
       submitHandler: function () {
           alert("添加成功");
       }
    });*/
    $(function(){
        var validate = $('#myForm').validate({
            errorPlacement: function(error, element) {
                //这里不能用text，用append
                $(element).parent().find(".help-block").html(error);
            },
            errorElement: "span",
            //会重复提交
            /*success: function () {
                alert("添加成功");
            },*/
            rules: {
                name: "required",
                education: "required"
            },
            messages: {
                name: "请输入姓名",
                education: "请输入最高学历"
            }
        });

        /*$("form").submit(function () {
            if($(this).valid()) {
                alert("添加成功");
            }
        });*/

        //这里如果用disabled，则表单上传时会视为未定义，readonly则视为内容为“”
        $('input[name = "isGraduated"]').change(function () {
            var selectedValue = $('input[name = "isGraduated"]:checked').val();
            if(selectedValue == "是") {
                $('#job').attr("readonly", false);
            } else if(selectedValue == "否" || selectedValue == "") {
                $('#job').val("").attr("readonly", true);
            }
        });

        $('input[name = "type"]').change(function() {
            var selectedValue = $('input[name = "type"]:checked').val();
            if(selectedValue == "老师") {
                $('#title').attr("readonly", false);
                $('#class').attr("readonly", false);
                $('#requirement').attr("readonly", false);

                $('#skill').val("").attr("readonly", true);
                $('#enrolDate').val("").attr("readonly", true);

            } else if(selectedValue == "学生") {
                $('#skill').attr("readonly", false);
                $('#enrolDate').attr("readonly", false);

                $('#title').val("").attr("readonly", true);
                $('#class').val("").attr("readonly", true);
                $('#requirement').val("").attr("readonly", true);
            }
        });
    })
</script>

</body>
</html>