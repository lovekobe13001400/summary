<?php
/**
cURL��һ������URL�﷨���������¹������ļ����乤�ߣ�1997���״η��С���֧���ļ��ϴ������أ��������ۺϴ��乤�ߣ�
������ͳ��ϰ�߳�cURLΪ���ع��ߡ�cURL�����������ڳ��򿪷���libcurl��
**/
/**
	**https����
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
			'X-Requested-With:XMLHttpRequest'//��ʶ�Ƿ���ajax
		);
		$userAgent = 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:23.0) Gecko/20100101 Firefox/23.0';
		$curl = curl_init(); //����һ��curl�Ự
		//curl_setopt($curl, CURLOPT_PORT,83); //���÷��ʶ˿ں�
		curl_setopt($curl, CURLOPT_URL, $url); //Ҫ���ʵĵ�ַ
		curl_setopt($curl, CURLOPT_HTTPHEADER, $header); //����HTTPͷ�ֶε�����
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0); //����֤֤����Դ�ļ��
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2); //��֤���м��SSL�����㷨�Ƿ����
		curl_setopt($curl, CURLOPT_USERAGENT,$userAgent); //ģ���û�ʹ�õ������
		curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1); //ʹ���Զ���ת
		curl_setopt($curl, CURLOPT_AUTOREFERER, 1); //�Զ�����Referer
		curl_setopt($curl, CURLOPT_POST, 1); //����һ�������Post����
		curl_setopt($curl, CURLOPT_POSTFIELDS,$xmlData); //Post�ύ�����ݰ�
		//curl_setopt($curl, CURLOPT_COOKIE, $this->cookie); //��ȡ�����Cookie��Ϣ
		curl_setopt($curl, CURLOPT_TIMEOUT, 30); //���ó�ʱ���Ʒ�ֹ��ѭ��
		curl_setopt($curl, CURLOPT_HEADER, 0); //��ʾ���ص�Header��������
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); //��ȡ����Ϣ���ļ�������ʽ����
		$result = curl_exec($curl); //ִ��һ��curl�Ự
		var_dump($result);
		curl_close($curl); //�ر�curl

	}