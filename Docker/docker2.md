###导入空ubuntu镜像
###更新软件源:sudo apt-get update
###安装docker包 
	sudo apt-get install docker.io
###获取镜像ubuntu:14.04
	sudo docker pull ubuntu:14.04
###查看docker镜像
sudo docker images;
###创建一个容器,使之能运行bash应用
	-d后台运行
	sudo docker run -t -i -d --name waker -v /data:/data -p 80:80 -p 90:90 ubuntu /bin/bash
###安装nsenter
	 cd /tmp;
     curl https://www.kernel.org/pub/linux/utils/util-linux/v2.24/util-linux-2.24.tar.gz | tar -zxf-;
     cd util-linux-2.24;
	 ./configure --without-ncurses
	 make nsenter && sudo cp nsenter /usr/local/bin
###在/usr/local/bin新建docker-enter文件,文件内容如下
	-
###验证docker是否已经装好
 	sudo docker ps
	sudo docker start waker  开启容器tk2
	sudo docker-enter waker 进入容器


下面ubuntu只来装lamp
###安装lamp
	安装apache:sudo apt-get install apache2
	
	启动apache:sudo /etc/init.d/apache2 start
	
	安装php:sudo apt-get install libapache2-mod-php5 php5 php5-gd php5-mysql
	
	重启apache:sudo /etc/init.d/apache2 restart
	
	编辑test.php:sudo vi /var/www/html/test.php,在test.phpe 写phpinfo();验证环境是否ok

	安装mysql:sudo apt-get install mysql-server mysql-client
    开启mysql服务:sudo service mysql start
	进入mysql:mysql -uroot -proot

	安装phpmyadmin:sudo apt-get install phpmyadmin
	然后将phpmyadmin与apache2建立连接，以我的为例：phpmyadmin目录在/var/www/html，phpmyadmin在/usr/share 
	sudo ln -s /usr/share/phpmyadmin /var/www/html
	phpmyadmin测试： 
	在浏览器地址栏中打开http://localhost/phpmyadmin

###辅助命令
	更新软件源:sudo apt-get update
###