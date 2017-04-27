<?php

/**

请加：技术交流群 304479564

*/

if (!empty($_GET['app']) && $_GET['app'] == 'lottery_json') {
    return lottery_json();
}

/**
 * 中奖机率计算
 */
function lottery_json() {
    //奖品概率
    $proArr = array(
        '1' => 20, //'罗浮山门票'
        '2' => 20, //'罗浮山嘉宝田温泉体验券'
        '3' => 20, //'精美旅游书籍《山水酿惠州》'
        '4' => 20, //'碧海湾漂流门票'
        '5' => 20, //'南昆山门票'
        '6' => 20, //'云顶温泉精美礼品'
        '7' => 50,
        '8' => 50,
        '9' => 50,
        '10' => 50
    );
    //奖品库存
    $proCount = array(
        '1' => 40,
        '2' => 40,
        '3' => 40,
        '4' => 40,
        '5' => 40,
        '6' => 60,
        '7' => 100,
        '8' => 100,
        '9' => 100,
        '10' => 100
    );
    $file = 'num.txt';
    $data = array(
        '1' => 0, '2' => 0, '3' => 0, '4' => 0, '5' => 0, '6' => 0
    );
    if (!file_exists($file)) {//检查文件或目录是否存在
        file_put_contents($file, serialize($data));//规定要写入数据的文件。如果文件不存在，则创建一个新文件//serialize 产生一个可存储的值的表示 
    } else {
        $str = file_get_contents($file);//规定要读取的文件，或者url
        $data = unserialize($str);//从已存储的表示中创建 PHP 的值
    }
    $rid = getRand($proArr, $proCount);

    if ($rid > 6) {
        $rid = 0;
    } else {
        $rid = returnRid($rid, $file, $data, $proCount, $proArr);
    }
    echo $rid;
}
/**
 * $rid       中奖数
 * $file      数据文件
 * $data   
 * $proCount  库存
 * $proArr    中奖概率
 * 查询有没有库存
 */
function returnRid($rid, $file, $data, $proCount, $proArr) {
    $data[$rid] = $data[$rid] + 1;    
    $count = $proCount[$rid]; // 总库存
    if ($count < $data[$rid]){//如果总库存小于需要的数
        // 如果抽取的数据大于总库存时库存清0
        $proCount[$rid] = 0;
        // 然后继续计算一直计算出某个值的库存不为0
        $rid = returnRid($rid, $file, $data, $proCount, $proArr);
    }else{
        // 写入缓存
        file_put_contents($file, serialize($data));
    }
    return $rid;
}

/**
 * 中奖概率计算, 能用
 * $proArr = array('1'=>'概率', '2'=>'概率');
 * $proCount = array('1'=>'库存', '2'=>'库存');
 */
function getRand($proArr, $proCount) {
    $result = '';
    $proSum = 0;
    foreach ($proCount as $key => $val) {
        if ($val <= 0) {
            continue;
        } else {
            $proSum = $proSum + $proArr[$key];
        }
    }
    foreach ($proArr as $key => $proCur) {
        if ($proCount[$key] <= 0) {
            continue;
        } else {
            $randNum = mt_rand(1, $proSum);//算法返回随机整数,1是最小，$proSum最大
            if ($randNum <= $proCur) {
                $result = $key;
                break;
            } else {
                $proSum -= $proCur;
            }
        }
    }
    unset($proArr);//抛出
    return $result;
}
