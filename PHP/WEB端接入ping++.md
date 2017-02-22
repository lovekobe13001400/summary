###1.下载服务端sdk：https://www.pingxx.com/docs/downloads  
	git clone 到data目录
	ib 文件夹下是 PHP SDK 文件，
	example 文件夹里面是简单的接入示例，该示例仅供参考。
2.安装部署服务端环境部署：
	require_once('../init.php'); //1.
	\Pingpp\Pingpp::setApiKey('sk_test_uzfHeP4iDC80yLOmDS18aPmP'); //私有key
	\Pingpp\Pingpp::setPrivateKeyPath('./your_rsa_private_key.pem');      //私钥文件，ping++能自动生成，并把公钥放到ping++上
	$content = \Pingpp\Charge::create(array( //ping++开始生成支付订单
	    'order_no'  => '123456789',
	    'amount'    => '100',//订单总金额, 人民币单位：分（如订单总金额为 1 元，此处请填 100）
	    'app'       => array('id' => 'app_uvrz1C5e5WHOvHer'),
	    'channel'   => 'alipay_qr',
	    'currency'  => 'cny',
	    'client_ip' => '127.0.0.1',
	    'subject'   => 'Your Subject',
	    'body'      => 'Your Body'
	  ));
	 var_dump(json_decode($content,true));//支付订单结果，主要有二维码
	//支付宝扫一扫，订单就变成支付成功