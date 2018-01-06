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

$reflection = memberId2name($conn);
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

    <title>Group Honour Information</title>

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
                                    <li><a href="../../individual/honour/view.php"><i class="fa fa-search fa-fw"></i> 查询</a></li>
                                    <li><a href="../../individual/honour/add.php"><i class="fa fa-plus-circle fa-fw"></i> 添加</a></li>
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
                            <li><a href="view.php"><i class="fa fa-search fa-fw"></i> 查询<span class="fa arrow"></span></a></li>
                            <li><a href="add.php"><i class="fa fa-plus-circle fa-fw"></i> 添加<span class="fa arrow"></span></a>
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
                <h1 class="page-header">查询团队荣誉信息</h1>
                <table width="100%" class="table table-striped table-bordered table-hover" id="myTable">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>标题</th>
                        <th>参与成员</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $sql = "SELECT * FROM tbl_grouphonour";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo '<tr><td>' . $row["GrHo_ID"] . '</td><td>' . $row["GrHo_Title"] . '</td><td>' . $row["GrHo_Member"] . '</td><td class="center">';
                            echo '<button type="button" class="btn btn-primary btnView" data-toggle="modal" data-target="#detail' . $row["GrHo_ID"] . '">查看</button>';
                            echo '<button type="button" class="btn btn-primary btnDelete" id="' . $row["GrHo_ID"] . '">删除</button>';

                            //detail panel
                            echo '<div class="modal fade" id="detail' . $row["GrHo_ID"] . '" tabindex="-1" role="dialog" aria-hidden="true"><div class="modal-dialog"><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button><h4 class="modal-title">详细信息</h4></div>';
                            echo '<div class="modal-body">';
                            if($row["GrHo_Path"] != "") {
                                echo '<p><img height="100%" width="100%" src="../../../' . $row["GrHo_Path"] . '"></p>';
                            }
                            echo '<p class="h3">详细介绍</p>';
                            echo '<p align="left" style="text-indent: 25px;">' . $row["GrHo_Introduction"] . '</p>';
                            echo '</div><div class="modal-footer"><button type="button" class="btn btn-primary" data-dismiss="modal">关闭</button></div></div></div></div></td></tr>';
                        }
                    }
                    ?>
                </table>
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

<!-- Page-Level Demo Scripts - Tables - Use for reference -->
<script>
    $(function () {
        $('#myTable').DataTable({
            responsive: true
        });
    });

    $(".btnDelete").click(function () {
        var infoId = $(this).attr("id");
        if(confirm("确定删除？")) {
            $.ajax({
                url: "../../operations/delete.php",
                type: "POST",
                data: {id: infoId, tableName: "grouphonour"},
                dataType: "html",
                error: function() {
                    alert('Error loading PHP document');
                },
                success: function(result) {
                    alert("删除成功");
                    window.location.reload();
                }
            });
        }
    });
</script>

<?php
$conn->close();
?>

</body>
</html>