###已知密码修改密码
	mysql -uroot -p      ----要求输入密码时，直接回车即可。
	use mysql;
	update user set password=PASSWORD('root') where user="root";    ---将root密码设置为12345678
	flush privileges;
	quit
###linux忘记root密码
	　/etc/init.d/mysql stop
	  mysqld_safe --user=mysql --skip-grant-tables --skip-networking &
	  mysql -u root mysql
	 mysql> update user set password=password('root') where user='root';
	 mysql> flush privileges;
	 mysql> quit
	 /etc/init.d/mysql restart
	 mysql -hlocalhost -uroot -p。。。
  