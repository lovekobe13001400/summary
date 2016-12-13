##ls命令

	ls [-选项] [参数:对象] ls -la /etc  
	①ls -la /etc -l:long 长格式:权限,用户组,时间等  
	②ls -a: 所有,包括.开始的隐藏文件  
	③ls /etc 产看etc目录下的文件  
	④ls -l:long(长格式显示)  
	⑤ls -lh:h人性化显示,文件大小按照kb,m,g算  
	⑥ls -ld:d显示当前目录  
	⑦ls -i:文件id号  

###文件分析

	-rwxrwxrwx:-表示这是一个文件  
	drwxrwxrwx:d表示这是一个目录   
	lrwxrwxrwx:l这是一个软链接  
	- rwx rwx rwx  
	r:可读  
	w:可写  
	x:可执行  
	-:如果是-没有权限  

###创建目录

	mkdir:创建目录
	mkdir -p waker/music/a.mp3 : -p递归创建

###显示当前目录

	pwd:显示当前所在目录

###删除空目录

	rmdir empty

###复制文件或者目录

	cp /dic/a.txt /tmp ##从原文件或目录复制到目标目录
	cp -r waker ../ ##-r复制目录
	cp /t1 /t2 /t3 /tmp ##可以多个复制
	cp -p /a.txt /root ##-p保留文件属性,比如修改时间 
	cp -r /music /root/music2 ##如果music2存在就是复制目录到music2,如果不存在就是重命名

###剪切目录

	剪切目录:mv 
	mv /dic /root :剪切目录,没有递归等要求,文件,目录,空目录都可以剪切
	当前目录改文件名
	mv a.txt b.txt 虽然是剪切,可以当做改名,b.txt不存在就是重命名

###删除文件或者目录

	rm a.txt
	rm -r /waker :递归删除

###软连接

	waker目录下创建article和music:mkdir article music  
	article: vi a.txt创建文件  
	article中的a.txt软连接到music  
	①创建软链接到waker/music/并重命名为a.txt.soft(可以理解为快捷方式)  
	ls ln -s /waker/article/a.txt /waker/music/a.txt.soft  
	②ls -l /waker/music/a.txt.soft(查看软连接文件)  
	结果:lrwxrwxrwx 1 root root 20 Oct 1 01:41 /waker/music/  a.txt.soft -> /waker/article/a.txt  

###d端口$$进程
	1.查看服务器监听的端口
	ss -tunl
	2.查看80端口被哪个程序占用
	lsof -i:80
	killall -9 apache2 kill掉Apache2占用的进程
	3.安装lsof
	sudo apt-get install lsof
	4.查找pid
	ps aux | grep httpd
	5.杀死进程
	killall -9 强制杀死
	killall -15保存数据慢慢关闭
###权限管理
1. chmod
chmod [{ugoa}{+-=}{rwx}] [文件或目录] 
[mode=421] [文件或目录]
-R递归修改
 2.chmod 777 a.txt
3.chmod -R a/b/c递归修改文件权限
4.touch创建文件
r  读权限   可以查看文件内容  可以列出目录中的内容
w  写权限   可以修改文件内容  可以创建和删除目录中的文件
x  执行权限 可以执行文件      可以进入目录

5.更改所有着,所属组
chown 用户  文件
chown root /waker/a.txt   在root用户将waker用户的文件修改为root用户的文件,文件所有者发生改变,只能在root用户下修改文件
useradd 添加用户
chgrp 用户组  文件或目录
groupadd 添加组

6.
umask -S 显示新建文件目录的缺省文件(系统默认文件状态)
umask -S
新建目录权限为缺省
新建文件少可执行权限:基于安全性考虑 
目录: -rwx-rx-rx
文件: -rw--r-r--
修改:默认缺省 
若想修改缺省权限为:rwxr-xr--
777-754 = 023
umask 023:修改为需要的默认权限
umask -S查看
mkdir test:结果为想要的权限

###解压缩
	--
	.gz 
	压缩:gzip a.txt   压缩文件为:a.txt.gz(压缩文件) gzip只能压缩文件,不保存原文件
	解压缩:gunzip(gzip -d) a.txt.gz 
	
	---
	tar :打包目录
	tar 选项[-zcvf][压缩文件名] [目录]
	tar -cvf  waker.tar  waker
	-c : 打包
	-v : 显示详细信息
	-f : 指定文件名
	-z : 打包同时压缩
	
	在把waker.rar的打包的目录压缩
	gzip waker.rar 变成 waker.rar.gz
	
	一步完成:tar -zcf waker.rar.gz waker(打包+压缩)
	
	
	tar 
	-x 解包
	-v 显示详细信息
	-f 指定解压文件
	-z 解压缩
	
	tar -zxvf waker.tar.gz
	----
	.zip(windows和linux都支持的解压方式)
	能保存源文件能压缩目录
	
	zip -r waker.zip  waker  -r:压缩目录
	zip a.txt.zip  a.txt
	
	解压缩
	unzip  waker.zip
	
	bzip2
	bzip2 -k a.txt 保留a.txt
	
	解压缩
	bunzip2  -k  boduo.bz2
	tar -xjf  japan.tar.tz2
	----
###用户管理
	useradd:执行权限
	useradd waker 添加waker用户
	---
	passwd waker :给waker用户添加密码
	--
	who :当前服务器有几个用户登陆
	登陆用户名  登陆终端 (tty本地终端  pts远程终端) 登陆时间 登陆主机ip地址
	
	w(详细信息)
	
	--
###文件搜索
	1.find [搜索范围] [匹配条件]
	根据文件名搜索:find /etc -name init
	模糊哦苏索文件名:find /etc -name *init*
	init开头后面带三个字符:find /etc -name init???
	不区分大小写查找:find /etc -iname init 
	2.根据文件大小来查找
	find / size +100M 大于
	find / size -100M 小于
	find / size =100M 等于
	数据库换算:512字节为一个数据块=0.5k   所以
	find / size +204800  就是100M
	好像:find / size +100M 也可以
	
	-a:and    -o:or
	find /etc -name init* -a -f  :看文件
	find /etc -name init* -a -d  :看目录
	
	find /etc -size +100M -a -size -200M 大于100M小于200M  -a表示and
	find /etc -size -100M -o -size +200M 小于100M大于200M   -o表示或者or
	--
	2.查找某个用户的所有文件
	find /home/ -user waker
	--
	3.根据时间属性
	find /etc -cmin -5  5分钟内被文件属性被修改
	find /etc -amin 访问时间
	find /etc -mmin 文件内容被修改
	
	-find /etc -name init -exec ls -l{} \;
	-exec/-ok执行操作  {}前面find查找的结果
	find /etc -name init -exec ls -l {} \;
	-ok:有个询问确认
	-find /etc -inum 
	如果文件名叫waker haha
	ls -i 知道对应i节点然后可以做相关操作
	
	-------
	locate:在文件资料库中查找文件(比find快)
	
	
	---
	which:查看命令在哪个目录
	which cp :查看cp命令存放在哪个目录
	--
	whereis:搜索命令所在目录及帮助文档路径
	----
	grep :在文件中搜寻字串匹配的行并输出
	-i 不区分大小写
	-v 排除指定字串
	
	grep waker a.txt 在a.txt中搜索waker的行并输出(列出那一行)
	grep -v ^# /etc/inittab 把注释行(#开头)忽略,不查看


