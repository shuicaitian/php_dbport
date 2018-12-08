<?php
// 指定允许其他域名访问 
header('Access-Control-Allow-Origin:*'); 
// 响应类型 
header('Access-Control-Allow-Methods','PUT,POST,GET,DELETE,OPTIONS'); 
// 响应头设置 
header('Access-Control-Allow-Headers','Content-Type, Content-Length, Authorization, Accept, X-Requested-With, Token');

$db = array(
    'dsn' => 'mysql:host=localhost;dbname=test;port=3306;charset=utf8',
    'host' => 'localhost',
    'port' => '3306',
    'dbname' => 'test',
    'username' => 'root',
    'password' => 'root',
    'charset' => 'utf8',
);

//连接
$options = array(
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, //默认是PDO::ERRMODE_SILENT, 0, (忽略错误模式)
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // 默认是PDO::FETCH_BOTH, 4
);

try{
    $pdo = new PDO($db['dsn'], $db['username'], $db['password'], $options);
}catch(PDOException $e){
    die('数据库连接失败:' . $e->getMessage());
}

//或者更通用的设置属性方式:
//$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);    //设置异常处理方式
//$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);   //设置默认关联索引遍历

//echo '<pre/>';

//1 查询

//1)使用query
$sql=<<<SQL
    select rq,rye,
        round(rye-ry,2) rs,
        ry,
        round((rye-ry)*100/rye,1) hs,
        bz 
      from daa01
      where
        jh=:pjh
      order by rq
SQL;
$stmt=$pdo->prepare($sql);
$stmt->bindValue(':pjh','DXY1X1');
//$stmt = $pdo->query($sql);
$stmt->execute();
//返回一个PDOStatement对象

//$row = $stmt->fetch(); //从结果集中获取下一行，用于while循环
$rows = $stmt->fetchAll(); //获取所有

$row_count = $stmt->rowCount(); //记录数

//print_r($rows);
//echo('<br/>');
//var_dump(json_encode($rows));

echo (json_encode($rows));

/*$data = array( 
'tid' => 100, 
'name' => $date, 
'site' => 'www.huangyibiao.com',
'post' =>$cars,
);

$response = array( 
'code' => 200, 
'message' => 'success for request', 
'data' => $data,

);

echo json_encode($response);
exit;*/
?>