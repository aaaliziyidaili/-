<?php
// 告知浏览器我们是html，解码用utf-8，header()表示向客户端发送一个原始的http包头
 header('Content-type:text/html; charset=utf-8');
 // 开启Session，返回一个bool值
 // Session表示存储关于用户会话（session）的信息
 session_start();
 
 // 处理用户登录信息
 // $_POST[]的变量应该是请求的html页面中，通过‘name’被复制的变量
 if (isset($_POST['login'])) {
    # 接受用户的登录消息，trim去掉字符串中的空格
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    // 判断提交的登录信息
    if (($username == '') || ($password == '')) {
        // 若为空，视为未填写，提示错误，并3秒后返回登录界面
        header('refresh:3; url=http://localhost/--main/%e7%99%bb%e5%bd%95%e4%b8%8e%e6%b3%a8%e5%86%8c/%e7%99%bb%e5%bd%95/%e7%99%bb%e5%bd%95%e7%95%8c%e9%9d%a2.html');
        echo "各字段不能为空，请重新填写";
        exit;
    } 
    // 连接数据库
    $con = mysqli_connect('localhost', 'root','','2024') ;
    // 验证数据库的连接状态
    if (mysqli_errno($con)) {
        echo "连接失败，请重试".mysqli_error($con);
        exit;
    }
    // 设置解码方式
    mysqli_set_charset($con, 'utf-8');
    // 设置数据库
    mysqli_select_db($con, '2024');
    // 查看输入的用户名用户密码与数据库中的值是否相同
    $stmt = mysqli_prepare($con, "SELECT * FROM login WHERE username = ? AND password = ?");
    if ($stmt === false) {
        echo "准备语句失败: " . mysqli_error($con);
        exit;
    }
    // 绑定参数
    mysqli_stmt_bind_param($stmt, 'ss', $username, $password);
    // 执行查询
    mysqli_stmt_execute($stmt);
    // 获取结果
    $result = mysqli_stmt_get_result($stmt);

    // 检查查询是否成功
    if ($result === false) {
        echo "数据库查询失败: " . mysqli_error($con);
        exit;
    }

    // 获取行数
    $num = mysqli_num_rows($result);
    if ($num==0) {
        header('refresh:3; url=http://localhost/--main/%e7%99%bb%e5%bd%95%e4%b8%8e%e6%b3%a8%e5%86%8c/%e7%99%bb%e5%bd%95/%e7%99%bb%e5%bd%95%e7%95%8c%e9%9d%a2.html');
        echo "用户名或密码错误，系统将在3秒后跳转到登录界面，请重新填写登录信息！";
        exit;
    } 
    else {
        header('refresh:3; url=http://localhost/--main/--main/%e4%b8%bb%e7%95%8c%e9%9d%a2/');
        echo "登录成功！";
        mysqli_close($con);
    }
}
?>