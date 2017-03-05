##安装docker镜像：centos+lnmp+phlapi+xdebug+migration+curl+

###1.准备linux环境
	1.新建一个test虚拟机(可以理解为test服务器):vagrant box add test ./ubuntu-14.04-amd64-vbox.box
	2.初始化:vagrant init test
	3.修改配置文件vagrantfile,添加如下内容:
	config.vm.network "forwarded_port", guest: 80, host: 80
	config.vm.network "forwarded_port", guest: 3306, host: 3306
	# 修改 Vagrantfile 下面这样的修改实测 ok:
	config.vm.synced_folder "d:/data", "/data"    #-- 在d盘见data作为工作目录
	4.启动虚拟机,vagrant up
###2.xshell连接，开始操作，安装doker基础镜像
更新软件源：sudo apt-get update  
安装docker基础镜像：sudo apt-get install docker.io
启动docker:sudo service start docker
下载centos镜像：sudo docker pull centos:7（慢，多尝试）
查看centos镜像：sudo docker images
###3.创建一个容器,使之能运行bash应用
	sudo docker run -t -i -d --name gooddocker -v /data:/data -p 80:80 -p 90:90 centos /bin/bash
	-d是以Daemon模式运行。
	-p 80:80 是将本地80端口映射到容器的80端口，现在可以在本地使用http://localhost访问。
	-v /web:/www 是将本地的/web目录挂载到容器的/www(容器配置的web目录)目录下。
	vckai/dev:v1 是要运行的镜像名称。
	/sbin/init 是容器运行后的系统初始化操作，主要用于启动nginx，php-fpm，mysql服务
	(参考： docker run -d -p 80:80 -v /web:/www vckai/dev:v1 /sbin/init)
	验证docker是否安装完毕：sudo docker ps
###4.安装nsenter
	 cd /tmp;
	 curl https://www.kernel.org/pub/linux/utils/util-linux/v2.24/util-linux-2.24.tar.gz | tar -zxf-;
	 cd util-linux-2.24;
	 ./configure --without-ncurses
	 make nsenter && sudo cp nsenter /usr/local/bin

	在/usr/local/bin新建docker-enter文件,文件内容如下
	
###5.进入docker
sudo docker-start gooddocker
sudo docker-enter gooddocker

###6.安装lnmp
screen -S lnmp
安装screen命令：yum install screen
安装wet命令：yum -y install wget
安装LNMP
wget -c http://soft.vpser.net/lnmp/lnmp1.3.tar.gz && tar zxf lnmp1.3.tar.gz && cd lnmp1.3 && ./install.sh lnmp
###7.访问成功
localhost访问，出来nginx欢迎界面
###8.安装Xdebug
	wget https://xdebug.org/files/xdebug-2.2.7.tgz
	tar -xvzf xdebug-2.2.7.tgz
	cd xdebug-2.2.7
	phpize   
	./configure --enable-xdebug  --with-php-config=/usr/local/php/bin/php-config
	make
	make install
	cp modules/xdebug.so /usr/local/php/include/php/ext
	注意：用find / -name 寻找php-config，ext等文件或目录
	编辑php.ini
	 [Xdebug]
	 zend_extension="/usr/local/php/include/php/ext/xdebug.so"  
	 xdebug.trace_output_dir="/tmp/php/xdebug"  
	 xdebug.profiler_output_dir="/tmp/php/xdebug"  
	 xdebug.profiler_output_name="callgrind.out.%s.%t"
	 xdebug.profiler_enable=Off
	 xdebug.profiler_enable_trigger=1
	 xdebug.default_enable=On
	 xdebug.show_exception_trace=Off
	 xdebug.show_local_vars=0
	 xdebug.max_nesting_level=300
	 xdebug.var_display_max_depth=6
	 xdebug.dump_once=On
	 xdebug.dump_globals=On
	 xdebug.dump_undefined=On
	 xdebug.dump.REQUEST=*
	 xdebug.dump.SERVER=REQUEST_METHOD,REQUEST_URI,HTTP_USER_AGENT
	 xdebug.remote_connect_back=1
	 xdebug.remote_enable=1
	 xdebug.remote_handler=dbgp
	 xdebug.remote_mode=req

###问题bash: service: command not found
因为/sbin下根本没有service，随意要安装
yum list | grep initscripts
###重启php-fpm
	/etc/init.d/php-fpm restart
	phpinfo()查看xdebug情况

###phpstorm设置debug
	1)配置Debug项：打开file->setings->php|Debug。在右侧的xdebug配置项中，配置与服务器xdebug一样的端口号，如上例的9001。
	a.打开file->setings->php|Servers 在右侧点击+，添加server，host: web服务器的域名或ip ,端口一般为80。
	
	b.勾选下面的 use path mapping，在absolute path to the server填写服务器上代码所在的路径。这里一定要设置哦！不然，会发生找不到文件而出错，导至调试终止 。
	
	note:由于网址导航中还要引用superphp，所以在project中需要增加superphp，并且设置在服务器上superphp的路径。
	3)配置WEB Application调试点：打开Run->Edit Configurations-> 增加一个 PHP WEB APPlication 的调试点 。
###lnmp目录
Nginx 目录: /usr/local/nginx/
MySQL 目录 : /usr/local/mysql/
Php目录：/usr/local/php/
MySQL配置文件：/etc/my.cnf
PHP配置文件：/usr/local/php/etc/php.ini
###启动命令
/etc/init.d/mysql start
/etc/init.d/php-fpm stop
/etc/init.d/php-fpm start


###centos防火墙
1、关闭firewall：
systemctl stop firewalld.service #停止firewall
systemctl disable firewalld.service #禁止firewall开机启动
firewall-cmd --state #查看默认防火墙状态（关闭后显示notrunning，开启后显示running）
###安装iptables
systemctl stop firewalld
systemctl mask firewalld
 
并且安装iptables-services：

yum install iptables-services
设置开机启动：

systemctl enable iptables
systemctl [stop|start|restart] iptables
#or
service iptables [stop|start|restart]
 
service iptables save
#or
/usr/libexec/iptables/iptables.init save

开发端口配置：Saving firewall rules to /etc/sysconfig/iptables

   1) 重启后生效
        开启： chkconfig iptables on
        关闭： chkconfig iptables off
        2) 即时生效，重启后失效
        开启： service iptables start
        关闭： service iptables stop
 重启防火墙service iptables restart 
###安装locate
yum install mlocate
updatedb

###安装phpsize
yum -y install php-devel 然后 /usr/bin/phpize
