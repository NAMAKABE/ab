<?php
/* SETTINGS */
/* 并发连接 */
$concurrency = 3000;
/* 请求次数 */
$number = 5;
/* 自定义待测接口 */
$aAPI = ['02', '03', '04', '05', '06'];
/* 自定义GET接口 */
$aAPIGET = ['03'];
/* 输出头信息的级别 */
$v = 4;
/* 输出为文件 */
$w = false;
/* SETTINGS END */
$vC = '';
$wC = '';
if ($v != 0) {
	$vC = '-v' . $v;
}
if ($w) {
	$wC = '-w';
}
$requests = (int) $concurrency * (int) $number;
$json_content = json_decode(file_get_contents("./data/get.json"), true);
$handle = fopen('./build.sh', "w");
$content = "#!/bin/sh\necho \"########################## APACHE BENCH FOR 7881 & 17173 API TEST ##########################\"\n";
$content .= "echo \"Ready for testing.\"\n";
$content .= "echo \"Processing logs.......\"\n";
$content .= "mkdir -p ./bench_log\n";
$content .= "nowtime=`date +%s`\n";
$content .= "echo \"Starting...\"\n";
// var_dump($json_content);
foreach ($json_content as $key => $value) {
	$nameID = explode("-", $value['title'])[0];
	$content .= "echo \"Starting " . $nameID . ".......\"\n";
	if (in_array($nameID, $aAPI)) {
		// echo $value['methods'][0];
		if (isset($value['parameters']) && (count($value['methods']) != 1 || $value['methods'][0] == 'POST') && $value['modules'] == '7881接口') {
			// 生成子项目
			$content .= "Timestamp=`date +%Y-%m-%d_%H-%M-%S`\n";
			$content .= "Mdfive=`printf 1qaz\!QAZ7881\\\\n2wsx@WSX\\\\n1442978940640|md5sum|cut -d ' ' -f1`\n";
			// printf 1qaz\!QAZ7881\\n2wsx@WSX\\n1442978940640|md5sum|cut -d ' ' -f1
			$content .= "ab -n" . $requests . " -c" . $concurrency . " " . $vC . " -k -p \"./data/" . $nameID . ".setting\" -H\"Connection:keep-alive;Accept:application/json;X-Requested-Accept:application/json;X-Service-App:1qaz!QAZ17173;X-Service-Timestamp:\$Timestamp;X-Service-Token:\$Mdfive;\" -T \"application/json\" " . $wC . " \"http://192.168.70.126:9114/api" . $value['api'] . "\" >> ./bench_log/bench_log_\$nowtime.log\n";
		} else if ((!isset($value['parameters']) || ($value['methods'][0] == 'GET' && count($value['methods']) == 1)) && $value['modules'] == '7881接口') {
			$content .= "Timestamp=`date +%Y-%m-%d_%H-%M-%S`\n";
			$content .= "Mdfive=`printf 1qaz\!QAZ7881\\\\n2wsx@WSX\\\\n1442978940640|md5sum|cut -d ' ' -f1`\n";
			$url = '?';
			if (!isset($value['parameters'])) {
				// var_dump($value['parameters']);
			} else {
				$array = file_get_contents("./data/" . $nameID . ".setting");
				// var_dump($array);
				$array_content = json_decode($array, true);
				// var_dump($array_content)

				if ($array_content != '') {
					foreach ($array_content as $key2 => $value2) {
						# code...
						$a = 1;
						if (count($array_content) == $a) {
							$url .= $key2 . '=' . $value2;
						} else {
							$url .= $key2 . '=' . $value2 . '&';
						}
						$a++;

					}
				}

			}

			// var_dump($value);
			$content .= "ab -n" . $requests . " -c" . $concurrency . " " . $vC . " -k -H\"Connection:keep-alive;Accept:application/json;X-Requested-Accept:application/json;X-Service-App:1qaz!QAZ17173;X-Service-Timestamp:\$Timestamp;X-Service-Token:\$Mdfive;\" " . $wC . " \"http://192.168.70.126:9114/api" . $value['api'] . $url . "\" >> ./bench_log/bench_log_\$nowtime.log\n";
			// $content .= "ab -n" . $requests . " -c" . $concurrency . " -p \"post.txt\" -T \"application/json\" -w \"http://192.168.70.126:9114/api/get_goods_detail\" >> ./bench_log.log";
		}
	} else {
		$content .= "echo \"" . $nameID . " is not available. PASS.\"\n";
	}
}

$content .= "echo \"#################################### END TEST. BY MISAKA ###################################\"";
fwrite($handle, $content);
fclose($handle);
?>

<!-- printf '1qaz!QAZ7881\\n2wsx@WSX\\n1442978940640'|tr -d '\n'|md5sum |cut -d ' ' -f1 -->