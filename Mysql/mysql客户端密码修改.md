###已知密码修改密码
	mysql -uroot -p      ----要求输入密码时，直接回车即可。
	use mysql;
	update user set password=PASSWORD('12345678') where user="root";    ---将root密码设置为12345678
	flush privileges;
	quit