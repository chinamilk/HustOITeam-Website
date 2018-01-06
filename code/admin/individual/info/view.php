<?php

include "../../../config.php";
include "../../../common.php";

session_start();
$backPath = "../../../"; //backPath是返回顶层目录需要的层数，path为存储目录（从顶层开始）
licenseJudge($backPath);

$conn = new mysqli($servername, $username, $password, $dbname);
$conn->set_charset("utf8"); //avoid the chinese characters to be mistaken
if ($conn->connect_errno)
    die("连接失败: " . $conn->connect_error);
//echo "连接成功";

if($_SERVER["REQUEST_METHOD"] == "POST") {
    //需要重新新建一份链接
    $conn2 = new mysqli($servername, $username, $password, $dbname);
    $conn2->set_charset("utf8"); //avoid the chinese characters to be mistaken
    if ($conn2->connect_errno)
        die("连接失败: " . $conn2->connect_error);
    //echo "连接成功";

    $id = checkInput($_POST["id"]);
    $type = checkInput($_POST["type"]);
    $prePhotoPath = checkInput($_POST["path"]);

    $name = checkInput($_POST["name"]);
    $education = checkInput($_POST["education"]);
    $school = checkInput($_POST["school"]);
    $major = checkInput($_POST["major"]);
    $phone = checkInput($_POST["phone"]);
    $email = checkInput($_POST["email"]);

    $sql = "UPDATE tbl_groupmember SET GrMe_Name = '$name', GrMe_Education = '$education', GrMe_School = '$school', GrMe_Major = '$major', GrMe_Phone = '$phone', GrMe_Email = '$email'";
    if($type == "老师") {
        $title = checkInput($_POST["title"]);
        $class = checkInput($_POST["class"]);
        $requirement = checkInput($_POST["requirement"]);
        $sql = $sql . ", GrMe_Title = '$title', GrMe_Class = '$class', GrMe_Requirement = '$requirement'";

        $path = "images/members/teachers/";
    } else if ($type == "学生") {
        $enrolDate = checkInput($_POST["enrolDate"]);
        $skill = checkInput($_POST["skill"]);
        $sql = $sql . ", GrMe_EnrolDate = '$enrolDate', GrMe_Skill = '$skill'";

        $isGraduated = checkInput($_POST["isGraduated"]);
        $job = checkInput($_POST["job"]);
        if($isGraduated == "是") {
            $sql = $sql . ", GrMe_IsGraduated = '$isGraduated', GrMe_Job = '$job'";
        } else if($isGraduated == "否") {
            $sql = $sql . ", GrMe_IsGraduated = '$isGraduated', GrMe_Job = ''";
        }

        $path = "images/members/students/";
    }

    //更换照片
    $isChangePhoto = checkInput($_POST["isChangePhoto"]);
    if($isChangePhoto == "是") {
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
            //删除先前的照片
            unlink("../../../" . $prePhotoPath);
            //添加新的照片
            move_uploaded_file($_FILES["photo"]["tmp_name"], $backPath . $path . $id . "." . $extension);
            $photoPath = checkInput($path . $id . "." . $extension);
            $sql = $sql . ", GrMe_Path = '$photoPath'";
        } else {
            die("照片仅支持2MB一下，格式为gif/jpg/jpeg/png");
        }
    }

    $sql = $sql . " WHERE GrMe_ID = '$id'";
    $conn2->query($sql);
    $conn2->close();


}

function checkInput($data) {
    $data = htmlspecialchars($data);
    if($data == "")
        $data = "";
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

    <title>Member Information</title>

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

    <!-- DataTables CSS -->
    <link href="../../vendor/datatables-plugins/dataTables.bootstrap.css" rel="stylesheet">
    <!-- DataTables Responsive CSS -->
    <link href="../../vendor/datatables-responsive/dataTables.responsive.css" rel="stylesheet">


    <style>
        .form-group p {
            color: #ff2e0e;
            display: inline-block;
        }
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
                                    <li><a href="add.php"><i class="fa fa-plus-circle fa-fw"></i> 添加</a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="#"><i class="fa fa-graduation-cap fa-fw"></i> 教育信息<span
                                            class="fa arrow"></span></a>
                                <ul class="nav nav-third-level">
                                    <li><a href="../education/view.php"><i class="fa fa-search fa-fw"></i> 查询</a></li>
                                    <li><a href="../education/add.php"><i class="fa fa-plus-circle fa-fw"></i> 添加</a>
                                    </li>
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
                                    <li><a href="../achievement/add.php"><i class="fa fa-plus-circle fa-fw"></i> 添加</a>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a href="#"><i class="fa fa-group fa-fw"></i> 实践、工作<span class="fa arrow"></span></a>
                                <ul class="nav nav-third-level">
                                    <li><a href="../workexperience/view.php"><i class="fa fa-search fa-fw"></i> 查询</a>
                                    </li>
                                    <li><a href="../workexperience/add.php"><i class="fa fa-plus-circle fa-fw"></i>
                                            添加</a></li>
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
                <h1 class="page-header">查询成员信息</h1>
                <table width="100%" class="table table-striped table-bordered table-hover" id="myTable">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>姓名</th>
                        <th>类别</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $sql = "SELECT * FROM tbl_groupmember";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo '<tr><td>' . $row["GrMe_ID"] . '</td><td>' . $row["GrMe_Name"] . '</td><td>' . $row["GrMe_Type"] . '</td><td class="center">';
                            //echo '<a class="btn btn-primary btnView" id="VIEW' . $row["GrMe_ID"] . '">查看</a>';
                            //echo '<a class="btn btn-primary btnDelete" id="DELETE' . $row["GrMe_ID"] . '">删除</a></td>';
                            echo '<button type="button" class="btn btn-primary btnView" data-toggle="modal" data-target="#detail' . $row["GrMe_ID"] . '">查看</button>';
                            //echo '<button type="button" class="btn btn-primary btnEdit" data-toggle="modal" data-target="#edit' . $row["GrMe_ID"] . '">修改</button>';
                            echo '<button type="button" class="btn btn-primary btnEdit" data-toggle="modal" data-target="#editPanel" id="EDIT' . $row["GrMe_ID"] . '">修改</button>';
                            echo '<button type="button" class="btn btn-primary btnDelete" id="DELETE' . $row["GrMe_ID"] . '">删除</button>';

                            //detail panel
                            echo '<div class="modal fade" id="detail' . $row["GrMe_ID"] . '" tabindex="-1" role="dialog" aria-hidden="true"><div class="modal-dialog"><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button><h4 class="modal-title">详细信息</h4></div>';
                            echo '<div class="modal-body">';
                            //table version
                            /*echo '<table class="table table-responsive table-hover"><tbody>';
                            echo '<tr><td><strong>ID：</strong></td><td>' . $row["GrMe_ID"] . '</td></tr>';
                            echo '<tr><td><strong>姓名：</strong></td><td>' . $row["GrMe_Name"] . '</td></tr>';
                            echo '<tr><td><strong>招生要求：</strong></td><td>' . $row["GrMe_Requirement"] . '</td></tr>';
                            echo '</tbody></table>';*/
                            echo '<p><strong>ID：</strong>' . $row["GrMe_ID"] . '</p>';
                            echo '<p><strong>姓名：</strong>' . $row["GrMe_Name"] . '</p>';
                            echo '<p><strong>类别：</strong>' . $row["GrMe_Type"] . '</p>';
                            echo '<p><strong>职称：</strong>' . $row["GrMe_Title"] . '</p>';
                            echo '<p><strong>入学年份：</strong>' . $row["GrMe_EnrolDate"] . '</p>';
                            echo '<p><strong>最高学历：</strong>' . $row["GrMe_Education"] . '</p>';
                            echo '<p><strong>所在高校：</strong>' . $row["GrMe_School"] . '</p>';
                            echo '<p><strong>是否毕业：</strong>' . $row["GrMe_IsGraduated"] . '</p>';
                            echo '<p><strong>毕业去向：</strong>' . $row["GrMe_Job"] . '</p>';
                            echo '<p><strong>研究方向：</strong>' . $row["GrMe_Major"] . '</p>';
                            echo '<p><strong>联系方式：</strong>' . $row["GrMe_Phone"] . '</p>';
                            echo '<p><strong>邮箱：</strong>' . $row["GrMe_Email"] . '</p>';
                            echo '<p><strong>技能掌握：</strong>' . $row["GrMe_Skill"] . '</p>';
                            echo '<p><strong>讲授课程：</strong>' . $row["GrMe_Class"] . '</p>';
                            echo '<p><strong>招生要求：</strong>' . $row["GrMe_Requirement"] . '</p>';
                            echo '<p><strong>相片路径：</strong>' . $row["GrMe_Path"] . '</p>';
                            echo '</div><div class="modal-footer"><button type="button" class="btn btn-primary" data-dismiss="modal">关闭</button></div></div></div></div></td></tr>';

                            /*//editing panel
                            echo '<form id="myForm" role="form" id="myForm" method="post" action="' . htmlspecialchars($_SERVER["PHP_SELF"]) . '" enctype="multipart/form-data"><div class="modal fade" id="edit' . $row["GrMe_ID"] . '" tabindex="-1" role="dialog" aria-hidden="true"><div class="modal-dialog"><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button><h4 class="modal-title">修改信息</h4></div>';
                            echo '<div class="modal-body">';
                            //table version
                            echo '<table class="table table-responsive table-hover"><tbody>';
                            //echo '<tr><td><strong>姓名：</strong></td><td><input type="text" name="name" id="name" value="' . $row["GrMe_Name"] .'">';
                            echo '<tr><td><strong>姓名：</strong></td><td><div class="form-group"><input class="form-control" name="name" id="name" value="' . $row["GrMe_Name"] .'"><p class="help-block"></p></div></td></tr>';


                            //echo '<tr><td><strong>姓名：</strong></td><td>' . $row["GrMe_Name"] . '</td></tr>';
                            //echo '<tr><td><strong>招生要求：</strong></td><td>' . $row["GrMe_Requirement"] . '</td></tr>';
                            echo '</tbody></table>';
                            echo '</div><div class="modal-footer"><button type="reset" class="btn btn-primary">重置</button><button type="button" class="btn btn-primary" data-dismiss="modal">关闭</button></div></div></div></div></form>';
                            */
                        }
                    }
                    ?>
                    <div class="modal fade" id="editPanel" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog">
                            <form role="form" id="myForm" method="post"
                                  action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>"
                                  enctype="multipart/form-data">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal"
                                                aria-hidden="true">&times;</button>
                                        <h4 class="modal-title" align="center">修改信息</h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label>姓名*</label>
                                            <input class="form-control" name="name" id="name">
                                            <p class="help-block"></p>
                                        </div>
                                        <!--<div class="form-group">
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
                                        </div>-->
                                        <div class="form-group teacherPart">
                                            <label>职称</label>
                                            <input class="form-control" name="title" id="title">
                                            <p class="help-block"></p>
                                        </div>
                                        <div class="form-group studentPart">
                                            <label>入学年份</label>
                                            <input class="form-control" name="enrolDate" id="enrolDate">
                                            <p class="help-block"></p>
                                        </div>
                                        <div class="form-group">
                                            <label>最高学历*</label>
                                            <input class="form-control" name="education" id="education"
                                                   placeholder="博士/硕士/本科">
                                            <p class="help-block"></p>
                                        </div>
                                        <div class="form-group">
                                            <label>所在高校</label>
                                            <input class="form-control" name="school" id="school">
                                            <p class="help-block"></p>
                                        </div>
                                        <div class="form-group studentPart">
                                            <label>是否毕业</label>
                                            <div class="radio">
                                                <label class="radio-inline">
                                                    <input type="radio" name="isGraduated" id="rGradYes" value="是">是
                                                </label>
                                                <label class="radio-inline">
                                                    <input type="radio" name="isGraduated" id="rGradNo" value="否">否
                                                </label>
                                            </div>
                                            <p class="help-block"></p>
                                        </div>
                                        <div class="form-group studentPart">
                                            <label>毕业去向</label>
                                            <input class="form-control" name="job" id="job">
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
                                        <div class="form-group studentPart">
                                            <label>技能掌握</label>
                                            <input class="form-control" name="skill" id="skill" placeholder="50字以内">
                                            <p class="help-block"></p>
                                        </div>
                                        <div class="form-group teacherPart">
                                            <label>讲授课程</label>
                                            <input class="form-control" name="class" id="class" placeholder="50字以内">
                                            <p class="help-block"></p>
                                        </div>
                                        <div class="form-group teacherPart">
                                            <label>招生要求</label>
                                            <textarea class="form-control" name="requirement"
                                                      id="requirement"></textarea>
                                            <p class="help-block"></p>
                                        </div>
                                        <div class="form-group">
                                            <label>修改照片</label>
                                            <div class="radio">
                                                <label class="radio-inline">
                                                    <input type="radio" name="isChangePhoto" id="rChPhYes" value="是">是
                                                </label>
                                                <label class="radio-inline">
                                                    <input type="radio" name="isChangePhoto" id="rChPhNo" value="否"
                                                           checked>否
                                                </label>
                                            </div>
                                            <p class="help-block"></p>
                                        </div>
                                        <div class="form-group photoPanel" style="display: none;">
                                            <label>照片上传（支持jpg/jpeg/png/gif，大小不超过2MB）</label>
                                            <input type="file" name="photo" id="photo">
                                            <p class="help-block"></p>
                                        </div>
                                        <div class="form-group hidePanel" style="display: none;">
                                            <input type="text" name="id" id="id" readonly>
                                            <input type="text" name="path" id="path" readonly>
                                            <input type="text" name="type" id="type" readonly>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary">保存修改</button>
                                        <button type="button" class="btn btn-primary" data-dismiss="modal">关闭</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    </tbody>
                </table>

                <!--old version-->
                <!--<table class="table table-responsive table-hover table-condensed">-->
                <!--<thead>-->
                <!--<tr>-->
                <!--<th>ID</th>-->
                <!--<th>姓名</th>-->
                <!--<th>类别</th>-->
                <!--<th>操作</th>-->
                <!--</tr>-->
                <!--</thead>-->
                <!--<tbody>-->
                <!--<tr>-->
                <!--<td>dsadsjdgjhad-dwdsd-sdfdfsd</td>-->
                <!--<td>韩雄威</td>-->
                <!--<td>学生</td>-->
                <!--<td>-->
                <!--<a class="btn btn-primary">查看</a>-->
                <!--</td>-->
                <!--</tr>-->
                <!--</tbody>-->
                <!--</table>-->
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

<!-- DataTables JavaScript -->
<script src="../../vendor/datatables/js/jquery.dataTables.min.js"></script>
<script src="../../vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
<script src="../../vendor/datatables-responsive/dataTables.responsive.js"></script>

<!-- Custom Theme JavaScript -->
<script src="../../dist/js/sb-admin-2.js"></script>

<!--Validate JavaScript-->
<script src="../../vendor/validate/jquery.validate.min.js"></script>
<script src="../../vendor/validate/messages_zh.min.js"></script>

<!--Myself Js-->
<script>
    $(function () {
        $('#myTable').DataTable({
            responsive: true
        });

        $('input[name = "isGraduated"]').change(function () {
            var selectedValue = $('input[name = "isGraduated"]:checked').val();
            if (selectedValue == "是") {
                $('#job').attr("readonly", false);
            } else if (selectedValue == "否") {
                $('#job').val("").attr('readonly', true);
            }
        });

        /*$('#submit').click(function () {
            if (confirm("确定修改?")) {
                $('#myForm').submit();
            }
        });*/

        /*$("form").submit(function () {
            if ($(this).valid()) {
                alert("修改成功");
            }
        });*/
    });

    $('input[name = "isChangePhoto"]').change(function () {
        var selectedValue = $('input[name = "isChangePhoto"]:checked').val();
        if (selectedValue == "是") {
            $('.photoPanel').css("display", "block");
        } else if (selectedValue == "否") {
            $('#photo').val("");
            $('.photoPanel').css("display", "none");
        }
    });

    $(".btnDelete").click(function () {
        var infoId = $(this).attr("id").split("DELETE")[1];
        if (confirm("确定删除？")) {
            /*$.post("../../operations/delete.php",
             {
             id: memberId,
             tableName: "groupmember"
             },
             function (data, status) {
             alert("删除成功");
             });*/
            $.ajax({
                url: "../../operations/delete.php",
                type: "POST",
                data: {id: infoId, tableName: "groupmember"},
                dataType: "html",
                error: function () {
                    window.location.reload();
                    //alert('Error loading PHP document');
                },
                success: function (result) {
                    alert("删除成功");
                    window.location.reload();
                }
            });
        }
    });

    $(".btnEdit").click(function () {
        var infoId = $(this).attr("id").split("EDIT")[1];
        //alert(infoId);
        $.ajax({
            url: "../../operations/select.php",
            type: "POST",
            data: {id: infoId, tableName: "groupmember"},
            dataType: "json",
            error: function () {
                alert('Error loading PHP document');
            },
            success: function (result) {
                $('#name').val(result.GrMe_Name);
                $('#education').val(result.GrMe_Education);
                $('#school').val(result.GrMe_School);
                $('#major').val(result.GrMe_Major);
                $('#phone').val(result.GrMe_Phone);
                $('#email').val(result.GrMe_Email);

                $('#id').val(result.GrMe_ID);
                $('#path').val(result.GrMe_Path);
                $('#type').val(result.GrMe_Type);

                var memberType = result.GrMe_Type;
                if (memberType == "老师") {
                    $('.teacherPart').css('display', 'block');
                    $('.studentPart').css('display', 'none');
                    $('#title').val(result.GrMe_Title);
                    $('#class').val(result.GrMe_Class);
                    $('#requirement').val(result.GrMe_Requirement);

                } else if (memberType == "学生") {
                    $('.teacherPart').css('display', 'none');
                    $('.studentPart').css('display', 'block');
                    $('#enrolDate').val(result.GrMe_EnrolDate);
                    $('#skill').val(result.GrMe_Skill);
                    var isGraduated = result.GrMe_IsGraduated;
                    if (isGraduated == "是") {
                        $('#rGradYes').attr('checked', 'true');
                        $('#job').val(result.GrMe_Job);
                    } else if (isGraduated == "否") {
                        $('#rGradNo').attr('checked', 'false');
                        $('#job').attr('readonly', "true");
                    }
                }
            }
        });
    });
</script>

<?php
$conn->close();
?>

</body>
</html>