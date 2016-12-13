	date(string format,timestamp)
	①
	print(date("Y年 m月d日");//输出当前,年月日.
	print(date("Y年 m月d日",60*60*24*365*10);//时间戳转年月日
	date('Y')+2 两年后
	date('s')+2 两秒后
	②
	date('w') //当天星期几周一到周日返回1 2 3 4 5 6 0
	date('w',60*60*24*365*10); //某个时间戳
	③
	getdate(integer timestamp) 返回数组
	④
	checkdate(integer month,integer day,integer year)
	**strtotime(string),string格式错误就会返回false
############################################
	time(): 当前时间戳
############################################
	strtotime会对格式进行失败检查
	strtotime
	strtotime ( "now" ),  "\n" ;  当前时间戳
	strtotime ( "10 September 2000" ),  "\n" ;
	strtotime ( "+1 day" ),  "\n" ;
	strtotime ( "+1 week" ),  "\n" ;
	strtotime ( "+1 week 2 days 4 hours 3 minutes 2 seconds" ),  "\n" ;
	strtotime ( "next Thursday" ),  "\n" ;
	strtotime ( "last Monday" ),  "\n" ;
############################################
	int mktime ([ int $hour = date("H") [, int $minute = date("i") [, int $second = date("s") [, int $month = date("n") [, int $day = date("j") [, int $year = date("Y") [, int $is_dst = -1 ]]]]]]] )
############################################