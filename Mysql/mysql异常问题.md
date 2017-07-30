###1.问题：
	Lost connection to MySQL server at ‘reading initial communication packet', system error: 0
	解决：
	vim /etc/mysql/my.cnf
	first:注释bind-address = 127.0.0.1 这一句。
	second:然后找到[mysqld]部分的参数，在配置后面建立一个新行，添加下面这个参数：
	skip-name-resolve
###问题2:
can't connect to mysql server on ""(10061)

grant all privileges on *.* to root@"39.184.174.137" identified by 'sjq&chenyi.12-345' with grant option;

grant all privileges on *.* to root@"106.14.114.197" identified by 'root' with grant option;


你的用户没有使用 root  账户，或者你的root账户没有授予登录权限，需要使用
GRANT ALL PRIVILEGES ON *.* TO 'myuser'@'%' IDENTIFIED BY 'mypassword' WITH GRANT OPTION;
授权
3.mysql的账户设置。

mysql账户是否不允许远程连接。如果无法连接可以尝试以下方法：

mysql -u root -p    //登录MySQL  
 
mysql> GRANT ALL PRIVILEGES ON *.* TO 'root'@'%'WITH GRANT OPTION;     //任何远程主机都可以访问数据库  
 
mysql> FLUSH PRIVILEGES;    //需要输入次命令使修改生效  
 
mysql> EXIT    //退出 
也可以通过修改表来实现远程：

mysql -u root -p  
 
mysql> use mysql;  
 
mysql> update user set host = '%' where user = 'root';  
 
mysql> select host, user from user; 