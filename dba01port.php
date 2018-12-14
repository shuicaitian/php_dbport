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
    select rq,rcyl1 rye,
        rcsl rs,
        rcyl ry,
        hs,
        bz 
      from DBA01
      where
        jh=:pjh
        and rq BETWEEN :pminDate AND :pmaxDate
      order by rq
SQL;
$stmt=$pdo->prepare($sql);
$stmt->bindValue(':pjh',$_POST["wellname"]);
$qsrq=$_POST["minDate"];//起始日期
$zzrq=$_POST["maxDate"];//终止日期
if(empty($qsrq)){
    $qsrq=date("Y-m-d",strtotime("-30 day"));
}
if(empty($zzrq)){
    $zzrq=date("Y-m-d",time());
}
$stmt->bindValue(':pminDate',$qsrq);
$stmt->bindValue(':pmaxDate',$zzrq);
//$stmt = $pdo->query($sql);
$stmt->execute();
//$stmt->debugDumpParams();


//返回一个PDOStatement对象

//$row = $stmt->fetch(); //从结果集中获取下一行，用于while循环
$rows = $stmt->fetchAll(); //获取所有

$row_count = $stmt->rowCount(); //记录数

//print_r($rows);
//echo('<br/>');
//var_dump(json_encode($rows));

if ($row_count==0) {
    echo "没有查到数据。";
  } else {
    echo (json_encode($rows));
  }


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