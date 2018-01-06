<?php
include "../config.php";
include "../common.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $accountIn = checkInput($_POST["account"]);
    $passwordIn = checkInput($_POST["password"]);

    $conn = new mysqli($servername, $username, $password, $dbname);
    $conn->set_charset("utf8"); //avoid the chinese characters to be mistaken
    if ($conn->connect_errno)
        die("连接失败: " . $conn->connect_error);

    $sql = "SELECT * FROM tbl_others WHERE Othe_Name = 'account'";
    $result = $conn->query($sql);
    $account = $result->fetch_assoc()["Othe_Value"];

    $sql = "SELECT * FROM tbl_others WHERE Othe_Name = 'password'";
    $result = $conn->query($sql);
    $password = $result->fetch_assoc()["Othe_Value"];

    $conn->close();

    if ($account != $accountIn) {
        echo '<script>alert("账号不存在");</script>';
    } else if ($password != $passwordIn) {
        echo '<script>alert("密码错误");</script>';
    } else {
        session_start();
        //这里要在session上作文章，防止非法登陆
        $_SESSION['timeout'] = time(); //将当前登陆时间存入session中
        $_SESSION["license"] = true;
        jump("index.php", null, 0);
        //header("Location:index.php");
        //echo '<script>location.href = "index.php";</script>';
        //session_destroy();
    }

    /*
    if($account != "admin") {
        echo '<script>alert("账号不存在");</script>';
    }
    else if($password != "123456") {
        echo '<script>alert("密码错误");</script>';
    }
    else {
        //这里要在session上作文章，防止非法登陆
        $_SESSION["account"] = $account;
        $_SESSION["password"] = $password;
        echo '<script>location.href = "index.php";</script>';
    }
    */
}

function checkInput($data)
{
    $data = htmlspecialchars($data);
    return $data;
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
    <title>Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
    <meta name="description" content="hust optimization and innovation team"/>
    <meta name="keywords" content="optimization"/>
    <meta name="keywords" content="innovation"/>
    <meta name="author" content="HXW"/>

    <link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">
</head>

<body>
<div class="container">
    <div class="row" style="margin-top: 200px;">
        <div class="col-md-4 col-md-offset-4">
            <form class="form-horizontal" role="form" id="myForm" method="post"
                  action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <div class="form-group">
                    <label for="account" class="col-sm-3 control-label">用户名：</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="account" id="account" placeholder="请输入管理员账号">
                    </div>
                </div>
                <div class="form-group">
                    <label for="password" class="col-sm-3 control-label">密码：</label>
                    <div class="col-sm-9">
                        <input type="password" class="form-control" name="password" id="password"
                               placeholder="请输入管理员密码">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-3 col-sm-10">
                        <button type="submit" id="submit" class="btn btn-default">登录</button>
                        <a id="clear" class="btn btn-default">清空</a>
                        <!--<a id="index" class="btn btn-default">跳转</a>-->
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- jQuery -->
<script src="../js/jquery-1.10.2.min.js"></script>
<!--Myself JS-->
<script>
    $(function () {
        $('#clear').click(function () {
            $('#account').val("");
            $('#password').val("");
        })
    })
</script>
</body>
</html>