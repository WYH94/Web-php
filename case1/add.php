<?php 
function add_music(){
	//将用户新提交的数据保存到storage。json
	//1.接收并校验
	//2.持久化
	//3.响应
	//
	//校验文本框
	$data = array();
	$data['id'] = uniqid();

	if(empty($_POST['title'])){
		$GLOBALS['error_message'] = '请输入音乐标题';
		return;
	}
	if(empty($_POST['artist'])){
		$GLOBALS['error_message'] = '请输入歌手名称';
		return;
	}
	$data['title'] = $_POST['title'];
	$data['artist'] = $_POST['artist'];
	// 校验文件


//图片文件校验
	if(empty($_FILES['images'])){
		//提交的表单没有source文件域
		$GLOBALS['error_message'] = '正确提交图片文件';
		return;
	}

	//文件类型和大小
	$images = $_FILES['images'];
	$data['images'] = array();
	//判断用户是否选择了文件
for($i = 0; $i < count($images['name']); $i++){

	if($images['error'][$i]!== UPLOAD_ERR_OK){

		$GLOBALS['error_message'] = '上传图片文件失败';
		return;

	}
	//类型
	// $allowed_types = array('image/jpeg','image/png','image/gif');
	if (strpos($images['type'][$i],'image/')!==0) {
			
		$GLOBALS['error_message'] = '上传图片文件类型错误';
		return;
	}
	if ($images['size'][$i]>1*1024*1024) {
		# code...
		$GLOBALS['error_message'] = '图片文件过大';
		return;
		
	}

	
		$dest = '../uploads/' . uniqid() . $images['name'][$i];
		if (!(move_uploaded_file($images['tmp_name'][$i], $dest))) {
			# code...
			$GLOBALS['error_message'] = '上传图片文件失败2';
			return;
		}
	$data['images'][]= substr($dest, 2);

}
		
	//================================
	//
	
		if(empty($_FILES['source'])){
		//提交的表单没有source文件域
		$GLOBALS['error_message'] = '正确提交文件';
		return;
	}
	
	$source = $_FILES['source'];
	//判断用户是否选择了文件
	echo $source['error'];
	var_dump($source);
	if($source['error']!== UPLOAD_ERR_OK){

		$GLOBALS['error_message'] = '上传音乐文件失败1';
		return;

	}
	//文件大小
	if ($source['size']>10*1024*1024) {
		# code...
		$GLOBALS['error_message'] = '音乐文件过大';
		return;
	}
	if ($source['size']<1*1024*1024) {
		# code...
		$GLOBALS['error_message'] = '音乐文件过小';
		return;
	}
	//判断类型
	$source_allowed_types = array('audio/mp3','audio/wma');
	if (!(in_array($source['type'],$source_allowed_types))) {
			
		$GLOBALS['error_message'] = '请上传音乐文件类型';
		return;
	}
		//移动
		$target = '../uploads/'.uniqid().'-'.$source['name'];
		if (!(move_uploaded_file($source['tmp_name'], $target))) {
			# code...
			$GLOBALS['error_message'] = '上传音乐文件失败2';
			return;
		}
		//将数据保存，保存数据的路径一定使用绝对路径
		//
		$data['source']= substr($target, 2);

	//音乐文件已经上传成功，但还在临时目录中

		$json = file_get_contents('storage.json');
		$old = json_decode($json,true);
		array_push($old, $data);
		$new_json = json_encode($old);
		file_put_contents('storage.json', $new_json);

	//响应
	header('Location:list.php');

}
if($_SERVER['REQUEST_METHOD'] === 'POST'){
	add_music();
}
 ?>


<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>添加音乐</title>
	<link rel="stylesheet" href="bootstrap.css">
</head>
<body>
	<div class="container py-5">
		<h1 class="display-4">添加音乐</h1>
		<hr>
			<?php if (isset($error_message)): ?>
				<div class="alert alert-danger" role="alert">
					<?php echo $error_message; ?>
				</div>
			<?php endif ?>
			
			<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
				<div class="form-group">
					<label for="title">标题</label>
					<input type="text" class="form-control" id="title" name="title">
				</div>
				<div class="form-group">
					<label for="artist">歌手</label>

					<input type="text" class="form-control" id="artist" name="artist">
				</div>
				<div class="form-group">
					<label for="images">海报</label>
					<!-- multiple可以让一个文件多选 -->
					<input type="file" class="form-control" id="images" name="images[]" accept="image/*" multiple>
				</div>
				<div class="form-group">
					<label for="source">音乐</label>
					<!-- accept可以设置两种值：MIME Type 和文件扩展名---> 
					<input type="file" class="form-control" id="source" name="source" accept="audio/*"> 
				</div>
				<button class="btn btn-primay btn-block">保存</button>
			</form>
		</hr>
	</div>
</body>
</html>