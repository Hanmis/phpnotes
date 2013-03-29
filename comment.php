<?php
/**
 * Created by JetBrains PhpStorm.
 * User: xpg
 * Date: 13-3-28
 * Time: 上午11:09
 * To change this template use File | Settings | File Templates.
 */
$data = array(
    array('id'=>1, 'pid'=>0, 'article_id'=>1, 'path'=>'01,', 'author'=>'id1', 'content'=>'content #1'),
    array('id'=>2, 'pid'=>0, 'article_id'=>1, 'path'=>'02,', 'author'=>'id2', 'content'=>'content #2'),
    array('id'=>3, 'pid'=>1, 'article_id'=>1, 'path'=>'01,03,', 'author'=>'id3', 'content'=>'content #3'),
    array('id'=>4, 'pid'=>0, 'article_id'=>1, 'path'=>'04,', 'author'=>'id4', 'content'=>'content #4'),
    array('id'=>5, 'pid'=>3, 'article_id'=>1, 'path'=>'01,03,05,', 'author'=>'id5', 'content'=>'content #5'),
    array('id'=>6, 'pid'=>5, 'article_id'=>1, 'path'=>'01,03,05,06,', 'author'=>'id6', 'content'=>'content #6'),
    array('id'=>7, 'pid'=>1, 'article_id'=>1, 'path'=>'01,07,', 'author'=>'id7', 'content'=>'content #8'),
    array('id'=>8, 'pid'=>4, 'article_id'=>1, 'path'=>'04,08,', 'author'=>'id8', 'content'=>'content #9')
);

foreach ($data as $row) {
    $volume[] = $row['path'];
}
//按照path字段排序
array_multisort($volume, SORT_ASC, $data);

$newData = array();


//按照path头个字段生成新的数组
foreach($data as $v) {
    $split = explode(',', $v['path']);
    $i = $split[0];
    $level = count($split) - 1;
    $v['lv'] = $level;
    $newData[$i][] = $v;
}

//把数组的key变成数字
$newData = array_values($newData);

//找出父评论的作者
function getAuthor($pid, $arr) {
    foreach ($arr as $k=>$v) {
        if($pid == $v['id'])
            return $arr[$k]['author'];
    }
}

//取得最大级数
function getMaxLevel ($data) {
    $max = 0;

    foreach ($data as $k =>$v) {
        foreach ($v as $k1 => $v1)
            $max = $max>$v1['lv'] ? $max :$v1['lv'];
    }

    return (int)$max;
}

//生成级别样式
function genLvCss() {
    $lvStr='.lv_';
    $lvCss='';
    global $newData;

    for($i=2; $i<=getMaxLevel($newData);$i++) {

        $mlNum =30*($i-1);
        $ml ="margin-left:" . $mlNum ."px;";

        $bg = ($i%2==0)?"background-color:#fee;" : "background-color:#fff;";
        $lvCss .= $lvStr.$i . "{" . $ml .$bg. "}\n";
    }

    return $lvCss;
}

?>
<!DOCTYPE html PUBLIC “-//W3C//DTD XHTML 1.0 Strict//EN” “http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd“>
<html xmlns=”http://www.w3.org/1999/xhtml” lang=”zh-CN” xml:lang=”zh-CN”>
<head>
    <title>嵌套评论列表</title>
    <style>
    h1 {
            margin-left:100px;
        }
        h2 {
            font-size:14px;
            margin:0;
            padding:0;
        }
        .main {
    /*border:2px solid #000;*/
            margin-bottom:20px;
            width:400px;
            /*background-color:#ffc;*/
            padding: 5px 10px 20px 10px;
            border:3px double #000;

        }
        .level {
            font-size:12px;
            border:1px dotted #000;
            padding:5px;
            border-spacing:0;
            margin-bottom:3px;

        }
        .lv_1{
            margin-left:0px;
            color:#000;
            background-color:#fec;
            border:1px solid #000;

        }

        .re_comment {
            text-decoration:underline;
            display:inline;
            font-style:italic;
            color:#f00;
        }
        .comment_content {
            padding-left: 20px;
        }
    </style>
    <style>
        <?php
            //生成按级别层叠的样式
            echo genLvCss();
        ?>
    </style>
</head>
<?php echo genLvCss();?>
<h1>嵌套评论列表</h1>
<body>
<?php foreach ($newData As $k => $rows) : ?>
<div class = "main">
<h2><?php echo "#".($k+1). "楼"; ?></h2>
    <?php foreach($rows as $k=>$row): ?>
    <div class = "level lv_<?php echo $row['lv']?>">
        <?php echo $row['author'] ?>
        <?php if ($k ==0) : ?>说 :

            <?php else :?>回复#
            <div class = "re_comment">
                             <?php echo getAuthor($row['pid'],$rows)?>
                         :</div>
            <?php endif ?>

    <div class = "comment_content"><?php echo $row['content'] ?></div>
</div>
        <?php endforeach; ?>
</div>
    <?php endforeach; ?>
</body>
</html>