
###参考链接
https://wenjs.me/p/note-of-nginx-configure
https://segmentfault.com/a/1190000002797606
###Nginx介绍
Nginx是一个高性能的HTTP和反向代理服务器，也是一个IMAP/POP3/SMTP代理服务器，相较于Apache，具有占有内存少、稳定性高等优势。Nginx安装非常简单、配置文件简洁，但是配置的类目却不少，本文主要记录Nginx的安装以及相关的配置（以下操作在CentOS6.7 64bit环境下）
###Nginx安装
...

###Nginx配置
nginx.conf是主配置文件，由若干个部分组成，每个大括号（{}）表示一个部分。每一行指令都由分号结束（;），标志着一行的结束。
	#user  nobody;
	worker_processes  2;
	events {
	    worker_connections  1024;
	}
	
	http {
	    include       mime.types;
	    default_type  application/octet-stream;
	
	    sendfile        on;
	   
	
	    server {
	        listen       80;
	        server_name  nff.gaoyuango.com;
	
		index index.php index.html;
	        root /usr/home/www/emall;
	        location ~ \.php$ {
	                fastcgi_pass 127.0.0.1:10000;
	                include fastcgi.conf;
	        }
	    }
	}
 
从配置可以看出，Nginx监听了80端口、域名为localhost、根路径为html文件夹（上面安装路径为 /usr/local/nginx，所以绝对路径为/usr/local/nginx/html）、默认index文件为index.html、index.htm。
###定义Ngnix运行的用户和用户组
user www www;
###nginx进程数，建议设置为等于cpu总核心数
worker_processes 8
###全局错误日志定义类型，[ debug | info | notice | warn | error | crit ]
error_log ar/loginx/error.log info;
#进程文件
pid ar/runinx.pid;
###一个nginx进程打开的最多文件描述符数目，理论值应该是最多打开文件数（系统的值ulimit -n）
与nginx进程数相除，但是nginx分配请求并不均匀，所以建议与ulimit -n的值保持一致。
worker_rlimit_nofile 65535;
events
{
###参考事件模型，use [ kqueue | rtsig | epoll | /dev/poll | select | poll ]; epoll模型
是Linux 2.6以上版本内核中的高性能网络I/O模型，如果跑在FreeBSD上面，就用kqueue模型。
use epoll;
worker_connections 65535;//单个进程最大连接数（最大连接数=连接数*进程数）
 
}
###reload&&restart
service nginx reload(修改完配置文件)  
service nginx restart（nginx出问题的时候）
###include指令
使用include包含的文件，必须确保包含的文件自身有正确的Nginx语法，即配置指令和块，然后指定这些文件的路径（没有给全路径的情况下，Nginx会基于它的主配置文件路径进行搜索）。如：  
include fastcgi.conf;

###server部分

由关键字server开始的部分被称作虚拟服务器部分，包含在http部分中，用于响应Http请求。一个虚拟服务器由listen和server_name指令组合定义。
server_name指令默认值为""，意味着没有server_name指令时，对于没有设置Host头的请求将会匹配该server。比如说，对于IP地址访问的请求，可以直接丢弃，如下：
  
	server {
	listen 80;
	return 444; # Nginx对于Http非标准代码会立即关闭一个链接
	}
所以把这个虚拟机配置最前面可以阻止ip访问网站

###location指令（具体使用暂定）
location指令可以用在server部分，提供来自客户端的URI或者内部重定向访问，也可以被嵌套使用。

	=	使用精确匹配并且终止搜索
	^~	表示uri以某个常规字符串开头，理解为匹配url路径即可。它并非正则表达式匹配，目的是优于正则表达式匹配。这里匹配的是解码uri，例如uri中的“％20”将会匹配location的“ ”（空格）。
	~	区分大小写的正则表达式匹配
	~*	不区分大小写的正则表达式匹配

###valid_referers指令（待定）
###try_files指令（待定）
###nginx内置预定义变量（待定）
###反向代理
反向代理是一个Web服务器，它接受客户端的连接请求，然后将请求转发给上游服务器，并将从服务器得到的结果返回给连接的客户端。

比如说，我们用Node写了一个服务，挂载在服务器的3000端口上，用户并不能直接该服务，可以采用Nginx来转发，访问http://xxx.com，Nginx*反向代理，从http://localhost:3000获取内容。配置如下：

	location / {
	    proxy_pass http://localhost:3000;
	    proxy_set_header X-Real-IP $remote_addr;
	    proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
	    proxy_set_header Host  $http_host;
	  }
代理模块常用指令

	proxy_connect_timeout	Nginx从接受请求至连接到上游服务器的最长等待时间
	proxy_cookie_domain	替代从上游服务器来的Set-Cookie头的domain属性
	proxy_cookie_path	替代从上游服务器来的Set-Cookie头的path属性
	proxy_set_header	重写发送到上游服务器头的内容，也可以通过将某个头部的值设置为空字符串，而不发送某个头部的方法实现

###upstream模块
###负载均衡


###
#设定http服务器
 
http
 
{
 
include mime.types; #文件扩展名与文件类型映射表
 
default_type application/octet-stream; #默认文件类型
 
#charset utf-8; #默认编码
 
server_names_hash_bucket_size 128; #服务器名字的hash表大小
 
client_header_buffer_size 32k; #上传文件大小限制
 
large_client_header_buffers 4 64k; #设定请求缓
 
client_max_body_size 8m; #设定请求缓
 
sendfile on; #开启高效文件传输模式，sendfile指令指定nginx是否调用sendfile函数来输出文件
，对于普通应用设为 on，如果用来进行下载等应用磁盘IO重负载应用，可设置为off，以平衡磁盘与
网络I/O处理速度，降低系统的负载。注意：如果图片显示不正常把这个改成off。
 
autoindex on; #开启目录列表访问，合适下载服务器，默认关闭。
 
tcp_nopush on; #防止网络阻塞
 
tcp_nodelay on; #防止网络阻塞
 
keepalive_timeout 120; #长连接超时时间，单位是秒
 
 
#FastCGI相关参数是为了改善网站的性能：减少资源占用，提高访问速度。下面参数看字面意思都能
理解。
 
fastcgi_connect_timeout 300;
 
fastcgi_send_timeout 300;
 
fastcgi_read_timeout 300;
 
fastcgi_buffer_size 64k;
 
fastcgi_buffers 4 64k;
 
fastcgi_busy_buffers_size 128k;
 
fastcgi_temp_file_write_size 128k;
 
 
 
#gzip模块设置
 
gzip on; #开启gzip压缩输出
 
gzip_min_length 1k; #最小压缩文件大小
 
gzip_buffers 4 16k; #压缩缓冲区
 
gzip_http_version 1.0; #压缩版本（默认1.1，前端如果是squid2.5请使用1.0）
 
gzip_comp_level 2; #压缩等级
 
gzip_types text/plain application/x-javascript text/css application/xml;
 
#压缩类型，默认就已经包含textml，所以下面就不用再写了，写上去也不会有问题，但是会有一个
warn。
 
gzip_vary on;
 
#limit_zone crawler $binary_remote_addr 10m; #开启限制IP连接数的时候需要使用
 
 
 
upstream blog.ha97.com {
 
#upstream的负载均衡，weight是权重，可以根据机器配置定义权重。weigth参数表示权值，权值越
高被分配到的几率越大。
 
server 192.168.80.121:80 weight=3;
 
server 192.168.80.122:80 weight=2;
 
server 192.168.80.123:80 weight=3;
 
}

###
#虚拟主机的配置
 
server
 
{
 
#监听端口
 
listen 80;
 
#域名可以有多个，用空格隔开
 
server_name www.ha97.com ha97.com;
 
index index.html index.htm index.php;
 
root /data/www/ha97;
 
location ~ .*.(php|php5)?$
 
{
 
fastcgi_pass 127.0.0.1:9000;
 
fastcgi_index index.php;
 
include fastcgi.conf;
 
}
 
#图片缓存时间设置
 
location ~ .*.(gif|jpg|jpeg|png|bmp|swf)$
 
{
 
expires 10d;
 
}
 
#JS和CSS缓存时间设置
 
location ~ .*.(js|css)?$
 
{
 
expires 1h;
 
}
 
#日志格式设定
 
log_format access '$remote_addr - $remote_user [$time_local] "$request" '
 
'$status $body_bytes_sent "$http_referer" '
 
'"$http_user_agent" $http_x_forwarded_for';
 
#定义本虚拟主机的访问日志
 
access_log ar/loginx/ha97access.log access;
 
 
#对 "/" 启用反向代理
 
location / {
 
proxy_pass http://127.0.0.1:88;
 
proxy_redirect off;
 
proxy_set_header X-Real-IP $remote_addr;
 
#后端的Web服务器可以通过X-Forwarded-For获取用户真实IP
 
proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
 
#以下是一些反向代理的配置，可选。
 
proxy_set_header Host $host;
 
client_max_body_size 10m; #允许客户端请求的最大单文件字节数
 
client_body_buffer_size 128k; #缓冲区代理缓冲用户端请求的最大字节数，
 
proxy_connect_timeout 90; #nginx跟后端服务器连接超时时间(代理连接超时)
 
proxy_send_timeout 90; #后端服务器数据回传时间(代理发送超时)
 
proxy_read_timeout 90; #连接成功后，后端服务器响应时间(代理接收超时)
 
proxy_buffer_size 4k; #设置代理服务器（nginx）保存用户头信息的缓冲区大小
 
proxy_buffers 4 32k; #proxy_buffers缓冲区，网页平均在32k以下的设置
 
proxy_busy_buffers_size 64k; #高负荷下缓冲大小（proxy_buffers*2）
 
proxy_temp_file_write_size 64k;
 
#设定缓存文件夹大小，大于这个值，将从upstream服务器传
 
}
 
 
#设定查看Nginx状态的地址
 
location /NginxStatus {
 
stub_status on;
 
access_log on;
 
auth_basic "NginxStatus";
 
auth_basic_user_file confpasswd;
 
#htpasswd文件的内容可以用apache提供的htpasswd工具来产生。
 
}
 
#本地动静分离反向代理配置
 
#所有jsp的页面均交由tomcat或resin处理
 
location ~ .(jsp|jspx|do)?$ {
 
proxy_set_header Host $host;
 
proxy_set_header X-Real-IP $remote_addr;
 
proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
 
proxy_pass http://127.0.0.1:8080;
 
}
 
#所有静态文件由nginx直接读取不经过tomcat或resin
 
location ~ .*.(htm|html|gif|jpg|jpeg|png|bmp|swf|ioc|rar|zip|txt|flv|mid|doc|ppt|
pdf|xls|mp3|wma)$
 
{ expires 15d; }
 
location ~ .*.(js|css)?$
 
{ expires 1h; }
 
}
 
}

###更详细的模块参数请参考
http://wiki.nginx.org/Main