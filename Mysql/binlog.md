1.###开启binlog

	1.查看二进制日志是否开启，show variables like 'log_%';
	2.开启binlog
	找到：/etc/my.cnf
	取消注释：#log-bin=mysql-bin
	3.重启mysql
	service mysqld start 
	4.再次查看，show variables like 'log_%'; 发现log_bin 为on
	5.定义路径log-bin=/var/lib/mysql/mysql-bin-log,
	[mysqld]
	 #添加这一行就ok了=号后面的路径和名字自己定义吧
	3.重启mysql
