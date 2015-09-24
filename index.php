<?php
header('Content-Type:text/html;charset=UTF-8');
function unicode_decode($name) {

	// 转换编码，将Unicode编码转换成可以浏览的utf-8编码
	$pattern = '/([\w]+)|(\\\u([\w]{4}))/i';
	preg_match_all($pattern, $name, $matches);
	if (!empty($matches)) {
		$name = '';
		for ($j = 0; $j < count($matches[0]); $j++) {
			$str = $matches[0][$j];
			if (strpos($str, '\\u') === 0) {
				$code = base_convert(substr($str, 2, 2), 16, 10);
				$code2 = base_convert(substr($str, 4), 16, 10);
				$c = chr($code) . chr($code2);
				// $c = iconv('ISO-8859-1', 'GBK', $c);
				$name .= $c;
			} else {
				$name .= $str;
			}
		}
	}
	return $name;
}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>JSON Generator</title>
		<style>
		pre { margin:0;}
					.clearfix:before, .clearfix:after { content: ""; display: table; }
					.clearfix:after { clear: both; }
					.clearfix { *zoom: 1;/*IE/7/6*/ }
					.one-api+div{ margin: 0 0 10px;}
					.one-api+div>div{ float: left;}
					.one-api+div input,.one-api+div span{ display: block;}
		</style>
		<!-- <link rel="shortcut icon" href="https://pandao.github.io/editor.md/favicon.ico" type="image/x-icon" /> -->
	</head>
	<body>
		<?php
// header('content-type:application/json;charset=utf8');
// header('content-type:text/html;charset=utf8');

echo '<h1 style="font-family: Tahoma, Verdana, Arial, sans-serif;font-size:2em;">JSON Generator</h1>';
$json_content = json_decode(file_get_contents("./data/get.json"), true);
// echo '<pre>' . json_encode($json_content, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) . '</pre>';
echo '<h1 style="font-family: Tahoma, Verdana, Arial, sans-serif;font-size:1.1em;">Settings<small> < required parameters only > </small></h1>';
echo '<p>U大写 L小写 C中文汉字 N数字 R任意 <b>数组字符串请转义否则报错</b></p>';
echo '<form action="post.php" method="post" target="">';
echo '<input type="submit" value="提交和刷新" />';
// 判定用户配置文件是否存在
$user_setting = false;
if (file_exists('./data/user.setting') == true) {
	$user_setting = true;
	$user_object = json_decode(file_get_contents('./data/user.setting'), true);
} else {
	$user_object;
}
foreach ($json_content as $key => $value) {
	# code...
	$count = 0;
	$html = '';
	$object = '';
	// $object['timne'] = '12';
	// var_dump($object);
	if (isset($value['parameters']) && $value['modules'] == '7881接口') {
		// 生成子项目
		foreach ($value['parameters'] as $key2 => $value2) {
			# code...
			if (isset($value2['required']) && $value2['required'] == true) {
				$count++;
				if (isset($value2['subpara'])) {
					// $html .= '<div><span>' . $value2['name'] . '</span><input placeholder="' . $value2['type'] . '"></input></div>';
					// 有二级
					// $object[$value2['name']]['312'] = '12';
					foreach ($value2['subpara'] as $key3 => $value3) {
						# code...
						if (isset($value3['required']) && $value3['required'] == true) {
							$object[$value2['name']][$value3['name']] = $value3['type'];
						}
					}
				} else {
					$object[$value2['name']] = $value2['type'];
				}
			}
		}
		echo '<div class="one-api">' . $value['title'] . '【' . $count . '】</div>';
		// echo '<div class="clearfix">' . $html;
		echo '<div class="clearfix">';
		// 原始数据
		echo '<pre style="width:250px;padding:5px;float:left">' . json_encode($object, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) . '</pre>';
		// 读取用户定义的数据
		$nameID = explode("-", $value['title'])[0];
		// var_dump($nameID);
		// 判定文件是否存在
		if ($user_setting) {
			echo '<textarea name="BLOCK-' . $nameID . '" style="height:250px;width:250px;border:1px solid #000;padding:5px;float:left">' . json_encode($user_object[$nameID], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) . '</textarea>';
			if (file_exists('./data/' . $nameID . '.setting') == true) {
				//已存在，读取文件，显示
				echo '<pre style="width:250px;padding:5px;float:left">' . file_get_contents('./data/' . $nameID . '.setting') . '</pre>';
			} else {
				// 不存在，创建之，初始化。
				$handle = fopen('./data/' . $nameID . '.setting', "w");
				fwrite($handle, json_encode($object, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
				fclose($handle);
				echo '<pre style="width:250px;padding:5px;float:left">' . json_encode($object, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) . '</pre>';
			}
		} else {
			// 不存在用户配置
			$user_object[$nameID] = $object;
			echo '<textarea name="BLOCK-' . $nameID . '" style="height:100%;width:250px;border:1px solid #000;padding:5px;float:left">' . json_encode($object, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) . '</textarea>';
		}
		echo '</div>';
		// 生成子项目
		// echo '<div>' . $value['title'] . '【' . var_dump(array_count_values($value['parameters'])) . '】</div>';
		// var_dump(array_values($value['parameters']));
	} else if (!isset($value['parameters']) && $value['modules'] == '7881接口') {
		echo '<div class="one-api">' . $value['title'] . '【无参数或无必要参数】</div>';
		echo '<div class="clearfix">';
		$nameID = explode("-", $value['title'])[0];
		var_dump($nameID);
		echo '</div>';
	}
	if ($key >= 90000) {
		break;
	}
}
if (!$user_setting) {
	$handle1 = fopen('./data/user.setting', "w");
	fwrite($handle1, json_encode($user_object, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
	fclose($handle1);
}
// var_dump($json_content);
// echo '<h1 style="font-family: Tahoma, Verdana, Arial, sans-serif;font-size:1.1em;">Result</h1>';
// echo '<pre>' . json_encode($json_content, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) . '</pre>';
?>
<input type="submit" value="提交和刷新" />
</form>
</body>
</html>