<?php
/**
cURL是一个利用URL语法在命令行下工作的文件传输工具，1997年首次发行。它支持文件上传和下载，所以是综合传输工具，
但按传统，习惯称cURL为下载工具。cURL还包含了用于程序开发的libcurl。
**/
/**
	**https访问
	**/
	function curl_post_ssl($url,$xmlData){
		$url=(substr($url,0,4)=='http')?$url:"http://$url";
		$urlParts=parse_url($url);
		$host=$urlParts['host'];
		$header = array(
			'Accept:*/*',
			'Accept-Charset:utf-8,GBK;q=0.7,*;q=0.3',
			'Accept-Encoding:gzip,deflate,sdch',
			'Accept-Language:zh-CN,zh;q=0.8',
			'Connection:keep-alive',
			'Host:'.$host,
			'Origin:www.baidu.com',
			'Referer:www.baidu.com',
			'X-Requested-With:XMLHttpRequest'//标识是否是ajax
		);
		$userAgent = 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:23.0) Gecko/20100101 Firefox/23.0';
		$curl = curl_init(); //启动一个curl会话
		//curl_setopt($curl, CURLOPT_PORT,83); //设置访问端口号
		curl_setopt($curl, CURLOPT_URL, $url); //要访问的地址
		curl_setopt($curl, CURLOPT_HTTPHEADER, $header); //设置HTTP头字段的数组
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0); //对认证证书来源的检查
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2); //从证书中检查SSL加密算法是否存在
		curl_setopt($curl, CURLOPT_USERAGENT,$userAgent); //模拟用户使用的浏览器
		curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1); //使用自动跳转
		curl_setopt($curl, CURLOPT_AUTOREFERER, 1); //自动设置Referer
		curl_setopt($curl, CURLOPT_POST, 1); //发送一个常规的Post请求
		curl_setopt($curl, CURLOPT_POSTFIELDS,$xmlData); //Post提交的数据包
		//curl_setopt($curl, CURLOPT_COOKIE, $this->cookie); //读取储存的Cookie信息
		curl_setopt($curl, CURLOPT_TIMEOUT, 30); //设置超时限制防止死循环
		curl_setopt($curl, CURLOPT_HEADER, 0); //显示返回的Header区域内容
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); //获取的信息以文件流的形式返回
		$result = curl_exec($curl); //执行一个curl会话
		var_dump($result);
		curl_close($curl); //关闭curl

	}