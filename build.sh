#!/bin/sh
echo "########################## APACHE BENCH FOR 7881 & 17173 API TEST ##########################"
echo "Ready for testing."
echo "Processing logs......."
mkdir -p ./bench_log
nowtime=`date +%s`
echo "Starting..."
echo "Starting 02......."
Timestamp=`date +%Y-%m-%d_%H-%M-%S`
Mdfive=`printf 1qaz\!QAZ7881\\n2wsx@WSX\\n1442978940640|md5sum|cut -d ' ' -f1`
ab -n15000 -c3000 -v4 -k -H"Connection:keep-alive;Accept:application/json;X-Requested-Accept:application/json;X-Service-App:1qaz!QAZ17173;X-Service-Timestamp:$Timestamp;X-Service-Token:$Mdfive;"  "http://192.168.70.126:9114/api/ping?" >> ./bench_log/bench_log_$nowtime.log
echo "Starting 03......."
Timestamp=`date +%Y-%m-%d_%H-%M-%S`
Mdfive=`printf 1qaz\!QAZ7881\\n2wsx@WSX\\n1442978940640|md5sum|cut -d ' ' -f1`
ab -n15000 -c3000 -v4 -k -H"Connection:keep-alive;Accept:application/json;X-Requested-Accept:application/json;X-Service-App:1qaz!QAZ17173;X-Service-Timestamp:$Timestamp;X-Service-Token:$Mdfive;"  "http://192.168.70.126:9114/api/get_game_info?game_id=A4092" >> ./bench_log/bench_log_$nowtime.log
echo "Starting 04......."
Timestamp=`date +%Y-%m-%d_%H-%M-%S`
Mdfive=`printf 1qaz\!QAZ7881\\n2wsx@WSX\\n1442978940640|md5sum|cut -d ' ' -f1`
ab -n15000 -c3000 -v4 -k -p "./data/04.setting" -H"Connection:keep-alive;Accept:application/json;X-Requested-Accept:application/json;X-Service-App:1qaz!QAZ17173;X-Service-Timestamp:$Timestamp;X-Service-Token:$Mdfive;" -T "application/json"  "http://192.168.70.126:9114/api/update_game_info" >> ./bench_log/bench_log_$nowtime.log
echo "Starting 05......."
Timestamp=`date +%Y-%m-%d_%H-%M-%S`
Mdfive=`printf 1qaz\!QAZ7881\\n2wsx@WSX\\n1442978940640|md5sum|cut -d ' ' -f1`
ab -n15000 -c3000 -v4 -k -p "./data/05.setting" -H"Connection:keep-alive;Accept:application/json;X-Requested-Accept:application/json;X-Service-App:1qaz!QAZ17173;X-Service-Timestamp:$Timestamp;X-Service-Token:$Mdfive;" -T "application/json"  "http://192.168.70.126:9114/api/validate_service_qq" >> ./bench_log/bench_log_$nowtime.log
echo "Starting 06......."
Timestamp=`date +%Y-%m-%d_%H-%M-%S`
Mdfive=`printf 1qaz\!QAZ7881\\n2wsx@WSX\\n1442978940640|md5sum|cut -d ' ' -f1`
ab -n15000 -c3000 -v4 -k -p "./data/06.setting" -H"Connection:keep-alive;Accept:application/json;X-Requested-Accept:application/json;X-Service-App:1qaz!QAZ17173;X-Service-Timestamp:$Timestamp;X-Service-Token:$Mdfive;" -T "application/json"  "http://192.168.70.126:9114/api/get_goods_list" >> ./bench_log/bench_log_$nowtime.log
echo "Starting 07......."
echo "07 is not available. PASS."
echo "Starting 08......."
echo "08 is not available. PASS."
echo "Starting 09......."
echo "09 is not available. PASS."
echo "Starting 11......."
echo "11 is not available. PASS."
echo "Starting 12......."
echo "12 is not available. PASS."
echo "Starting 13......."
echo "13 is not available. PASS."
echo "Starting 14......."
echo "14 is not available. PASS."
echo "Starting 15......."
echo "15 is not available. PASS."
echo "Starting 16......."
echo "16 is not available. PASS."
echo "Starting 17......."
echo "17 is not available. PASS."
echo "Starting 18......."
echo "18 is not available. PASS."
echo "Starting 19......."
echo "19 is not available. PASS."
echo "Starting 20......."
echo "20 is not available. PASS."
echo "Starting 21......."
echo "21 is not available. PASS."
echo "Starting 22......."
echo "22 is not available. PASS."
echo "Starting 24......."
echo "24 is not available. PASS."
echo "Starting 25......."
echo "25 is not available. PASS."
echo "Starting 26......."
echo "26 is not available. PASS."
echo "Starting 27......."
echo "27 is not available. PASS."
echo "Starting 28......."
echo "28 is not available. PASS."
echo "Starting 29......."
echo "29 is not available. PASS."
echo "Starting 30......."
echo "30 is not available. PASS."
echo "Starting 31......."
echo "31 is not available. PASS."
echo "Starting 32......."
echo "32 is not available. PASS."
echo "Starting 4......."
echo "Starting 10......."
echo "10 is not available. PASS."
echo "#################################### END TEST. BY MISAKA ###################################"