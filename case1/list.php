<?php 
//获取文件中记录的数据，并展示到表格中，动态生成表格的html标签
$contents = file_get_contents('storage.json');
//吧json格式转换成对象的过程：反序列化
$data = json_decode($contents,true);
// php的价值
// 通过执行php代码取到指定数值，填充到html指定位置
//$json = file_get_contents('');
 ?>

 <!DOCTYPE html>
 <html lang="en">
 <head>
 	<meta charset="UTF-8">
 	<title>音乐列表</title>
 	<link rel="stylesheet" href="bootstrap.css">
 </head>
 <body>
 	<div class="container py-5">
		<h1 class="display-4">音乐列表</h1>
		<hr>
		<div class="mb-3">
			<a href="add.php" class="btn btn-secondary btn-sm">添加</a>
		</div>
		<table class="table table-bordered table-striped table-hover">
			<thead class="thead-dark">
				<tr>
					<th class="text-center">标题</th>
					<th class="text-center">歌手</th>
					<th class="text-center">海报</th>
					<th class="text-center">音乐</th>
					<th class="text-center">操作</th>
				</tr>
			</thead>
			<tbody class="text-center">
				
				<?php foreach ($data as $item): ?>

					<tr>
					<td><?php echo $item['title']; ?></td>
					<td><?php echo $item['artist']; ?></td>
					<td>
						<?php foreach ($item['images'] as $src): ?>
							<img src="<?php echo $src; ?>" alt="" height=30px width=50px>
						<?php endforeach ?>
					</td>
					<td><audio src="<?php echo $item['source']; ?>" controls=""></audio></td>
					<td><a class="btn btn-danger btn-sm" href="delete.php?id=<?php echo $item['id']; ?>">删除</a></td>
					</tr>
				<?php endforeach ?>

				<!-- <tr>
					<td>哈哈</td>
					<td>哈哈</td>
					<td><img src="" alt=""></td>
					<td><audio src="" controls=""></audio></td>
					<td><button class="btn btn-danger btn-sm">删除</button></td>
				</tr> -->

			</tbody>
		</table>
 	</div>
 </body>
 </html>