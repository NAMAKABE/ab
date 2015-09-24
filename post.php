<?php
header('Content-Type:text/html;charset=UTF-8');
// 随机数生成的方法
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

// for ($i = 0; $i < $pass_length; $i++) {
// 	// echo "&#x" . dechex(rand(176, 215) << 8 | rand(161, 254)) . ";";
// 	$str .= "\\u" . dechex(rand(176, 215) << 8 | rand(161, 254));
// }
// $content .= unicode_decode($str);

$arrayNum = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9];
$arrayABC = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'];
$arrayabc = ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z'];

$arrayBoolen = [true, false];

function anaString($value = '') {
	# code...
	global $arrayNum;
	global $arrayABC;
	global $arrayabc;
	global $arrayBoolen;
	$Result = '';
	for ($i = 0; $i < strlen($value); $i++) {
		# code...
		switch ($value[$i]) {
			case 'U':
				# code...
				$Result .= $arrayABC[array_rand($arrayABC)];
				break;
			case 'L':
				# code...
				$Result .= $arrayabc[array_rand($arrayabc)];
				break;
			case 'N':
				# code...
				$Result .= $arrayNum[array_rand($arrayNum)];
				break;
			case 'C':
				# code...
				$Result .= unicode_decode("\\u" . dechex(rand(176, 215) << 8 | rand(161, 254)));
				break;
			case 'R':
				# code...
				$rand = mt_rand(0, 3);
				switch ($rand) {
					case 0:
						# code...
						$Result .= $arrayABC[array_rand($arrayABC)];
						break;
					case 1:
						# code...
						$Result .= $arrayabc[array_rand($arrayabc)];
						break;
					case 2:
						# code...
						$Result .= $arrayNum[array_rand($arrayNum)];
						break;
					case 3:
						# code...
						$Result .= unicode_decode("\\u" . dechex(rand(176, 215) << 8 | rand(161, 254)));
						break;
				}
				// $Result .= unicode_decode("\\u" . dechex(rand(176, 215) << 8 | rand(161, 254)));
				break;
			default:
				# code...
				$Result .= $value[$i];
				break;
		}
	}
	return iconv("GBK", "UTF-8", $Result);
}
// var_dump(anaString('NNNNNNNNNNNNscsc'));

if (isset($_POST) && !empty($_POST)) {
	// var_dump($_POST);
	$object;
	foreach ($_POST as $key => $value) {
		# code...
		$num = explode('-', $key)[1];
		$object[$num] = json_decode($value, true);
	}
	$_object = $object;
	foreach ($object as $key => $value) {
		# code...

		foreach ($value as $key2 => $value2) {
			# code...
			if (is_string($value2) || is_bool($value2)) {
				$object[$key][$key2] = anaString($value2);
				// var_dump($value);
				// exit();
			} else {
				foreach ($value2 as $key3 => $value3) {
					# code...
					$object[$key][$key2][$key3] = anaString($value3);
				}
			}

			// var_dump($value[$key2]);
			// exit();
		}
		// 写入setting
		// var_dump($object[$key]);

		// iconv("GBK", "UTF-8", $str);
		// var_dump(json_encode($object[$key], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
		$handle = fopen('./data/' . $key . '.setting', "w");
		fwrite($handle, json_encode($object[$key], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
		fclose($handle);
		// exit();

	}

	$handle = fopen('./data/user.setting', "w");
	fwrite($handle, json_encode($_object, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
	fclose($handle);

	// var_dump($object);
	// echo '构建成功';
	header('location:index.php');
	// echo '<script>location.href="index.php"</script>';
} else {
	exit("未收到POST数据");
}

?>