<?php
require './query.php';
//采集OSC的代码分享列表，标题 链接 作者
$url = "http://www.oschina.net/code/list";
$reg = array(
	"title"=>array(".code_title a:eq(0)","text"),
	"url"=>array(".code_title a:eq(0)","href"),
	"author"=>array("img","title")
);
//要抓取的所有li标签
$rang = ".code_list li";
$hj = new QueryList($url,$reg,$rang);
$arr = $hj->jsonArr;
//print_r($arr);

//如果还想采当前页面右边的 TOP40活跃贡献者 图像，得到JSON数据,可以这样写
$reg = array("portrait"=>array(".hot_top img","src"));
$hj->setQuery($reg);
$json = $hj->getJSON();
echo $json . "<hr/>";


//采OSC内容页内容
$url = "http://www.oschina.net/code/snippet_186288_23816";
$reg = array("title"=>array(".QTitle h1","text"),"con"=>array(".Content","html"));
$hj = new QueryList($url,$reg);
$arr = $hj->jsonArr;
print_r($arr);

