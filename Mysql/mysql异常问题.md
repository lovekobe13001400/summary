###1.问题：
	Lost connection to MySQL server at ‘reading initial communication packet', system error: 0
	解决：
	vim /etc/mysql/my.cnf
	first:注释bind-address = 127.0.0.1 这一句。
	second:然后找到[mysqld]部分的参数，在配置后面建立一个新行，添加下面这个参数：
	skip-name-resolve