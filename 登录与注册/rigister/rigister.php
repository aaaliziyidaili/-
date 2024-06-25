<?php
// 开启Session
session_start();

// 数据库连接信息
$host = 'localhost'; // 数据库服务器地址
$dbname = '2024';    // 数据库名
$username = 'root';  // 数据库用户名
$password = '';      // 数据库密码

// 创建PDO实例
$dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

try {
    $pdo = new PDO($dsn, $username, $password, $options);
} catch (\PDOException $e) {
    die("数据库连接失败: " . $e->getMessage());
}

// 检查表单是否已提交
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    // 获取用户输入
    $username = !empty($_POST['useremail']) ? trim($_POST['useremail']) : null;
    $password = !empty($_POST['password']) ? trim($_POST['password']) : null;

    // 输入验证
    if (empty($username) || empty($password)) {
        header('refresh:3; url=http://localhost/--main/%e7%99%bb%e5%bd%95%e4%b8%8e%e6%b3%a8%e5%86%8c/rigister/%E7%99%BB%E5%BD%95%E7%95%8C%E9%9D%A2.html');
        echo "各字段不能为空，请重新填写";
        exit;
    }

    // 准备SQL语句
    $stmt = $pdo->prepare("INSERT INTO login (username, password) VALUES (?, ?)");

    // 绑定参数
    $stmt->bindParam(1, $username, PDO::PARAM_STR);
    // 这里我们不使用密码加密，实际生产中不推荐
    $stmt->bindParam(2, $password, PDO::PARAM_STR);

    // 执行SQL语句
    if ($stmt->execute()) {
        // 注册成功后的逻辑，例如重定向到登录页面
        header('refresh:3; url=http://localhost/--main/%e7%99%bb%e5%bd%95%e4%b8%8e%e6%b3%a8%e5%86%8c/%e7%99%bb%e5%bd%95/%e7%99%bb%e5%bd%95%e7%95%8c%e9%9d%a2.html');
        echo"注册成功！前往登录！";
        exit;
    } else {
        // 重定向回注册页面，并显示错误信息
        $redirectUrl = 'http://localhost/--main/%e7%99%bb%e5%bd%95%e4%b8%8e%e6%b3%a8%e5%86%8c/rigister/%E7%99%BB%E5%BD%95%E7%95%8C%E9%9D%A2.html'; // 替换为实际的注册界面URL
        header("Location: $redirectUrl?error=registerfail");
        exit;
    }
} else {
    // 如果请求不是POST请求或者没有提交注册按钮，则重定向回注册页面
    $redirectUrl = 'http://localhost/--main/%e7%99%bb%e5%bd%95%e4%b8%8e%e6%b3%a8%e5%86%8c/rigister/%E7%99%BB%E5%BD%95%E7%95%8C%E9%9D%A2.html'; // 替换为实际的注册界面URL
    header("Location: $redirectUrl");
    exit;
}
?>