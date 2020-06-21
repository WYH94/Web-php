<?php 

//找到要删除的数据，从原有数组中移除
// echo "delete";
//如何知道客户端想要删除哪一个,通过URL地址中的参数
// echo $_GET['id'];
//接收URL中的id
if(empty($_GET['id'])){
	exit('<h1>必须指定参数</h1>');
}
$id = $_GET['id'];

//找到要删除的数据
$data = json_decode(file_get_contents('storage.json'),true);
foreach ($data as $item) {
	if($item['id']!==$id)continue;
	// $item=>要删除的数据
	$index = array_search($item,$data);
	array_splice($data, $index,1);

//从原数据中删除
//保存删除后的数据
$json = json_encode($data);
file_put_contents('storage.json',$json);
//跳转回列表页
header('Location:list.php');

}
 ?>