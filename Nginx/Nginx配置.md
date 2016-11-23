###参考链接
https://wenjs.me/p/note-of-nginx-configure
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
