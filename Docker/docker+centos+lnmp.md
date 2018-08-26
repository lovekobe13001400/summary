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
	sudo docker run -t -i -d --name a123 -v /data:/data -p 80:80 -p 90:90 centos:latest /bin/bash /run.sh

     
    -d 改成 dit
sudo docker run -t -i -dit --name a123 -v /data:/data centos:latest /bin/bash /run.sh
	-d是以Daemon模式运行。
	-p 80:80 是将本地80端口映射到容器的80端口，现在可以在本地使用http://localhost访问。
	-v /web:/www 是将本地的/web目录挂载到容器的/www(容器配置的web目录)目录下。
	vckai/dev:v1 是要运行的镜像名称。
	/sbin/init 是容器运行后的系统初始化操作，主要用于启动nginx，php-fpm，mysql服务
	(参考： docker run -d -p 80:80 -v /web:/www vckai/dev:v1 /sbin/init)
	验证docker是否安装完毕：sudo docker ps
###4.安装nsenter
	 cd /tmp;
	 curl https://www.kernel.org/pub/linux/utils/util-linux/v2.24/util-linux-2.24.tar.gz | tar -zxvf-;
	 cd util-linux-2.24;
	 ./configure --without-ncurses
	 make nsenter && sudo cp nsenter /usr/local/bin

	在/usr/local/bin新建docker-enter文件,文件内容如下

	#!/bin/sh
    if [ -e $(dirname "$0")/nsenter ]; then
        # with boot2docker, nsenter is not in the PATH but it is in the same folder
        NSENTER=$(dirname "$0")/nsenter
    else
        NSENTER=nsenter
    fi

    if [ -z "$1" ]; then
        echo "Usage: `basename "$0"` CONTAINER [COMMAND [ARG]...]"
        echo ""
        echo "Enters the Docker CONTAINER and executes the specified COMMAND."
        echo "If COMMAND is not specified, runs an interactive shell in CONTAINER."
    else
        PID=$(docker inspect --format "{{.State.Pid}}" "$1")
        if [ -z "$PID" ]; then
            exit 1
        fi
        shift

        OPTS="--target $PID --mount --uts --ipc --net --pid --"

        if [ -z "$1" ]; then
            # No command given.
            # Use su to clear all host environment variables except for TERM,
            # initialize the environment variables HOME, SHELL, USER, LOGNAME, PATH,
            # and start a login shell.
            "$NSENTER" $OPTS su - root
        else
            # Use env to clear all host environment variables.
            "$NSENTER" $OPTS env --ignore-environment -- "$@"
        fi
    fi
	
###5.进入docker
sudo docker-start gooddocker
sudo docker-enter gooddocker

###6.安装lnmp
screen -S lnmp
安装screen命令：yum install screen
安装wet命令：yum -y install wget
安装LNMP稳定版本
wget -c http://soft.vpser.net/lnmp/lnmp1.3-full.tar.gz && tar zxf lnmp1.3-full.tar.gz && cd lnmp1.3-full && ./install.sh lnmp
###7.访问成功
localhost访问，出来nginx欢迎界面


###补充
把安装好的centos7镜像变成centos基础镜像，然后加入启动容器脚本
1.变 sudo docker commit a4480ff9004e cy
得到85c5012f8aad10eb85143ff6291e822f46220d5290a561d90e10a30f214a3ae9
2.查看镜像 docker images
sudo docker run -t -i -d --name dockercy -v /data:/data -p 80:80 -p 90:90 -p 3306:3306 cy /sbin/init
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
/etc/init.d/nginx restart

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




开启容器 进入容器
sudo docker run -dit centos
sudo docker attach ID

sudo docker run -dit --name c3 -v /data:/data centos:latest /bin/bash /run.sh

