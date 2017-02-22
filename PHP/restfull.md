###参考链接：
https://mengkang.net/625.html
http://segmentfault.com/search?q=%E8%AE%A4%E8%AF%81
https://github.com/interagent/http-api-design#return-appropriate-status-codes
###1.什么是restful
它是：一种架构设计风格，提供了设计原则和约束条件，而不是架构。而满足这些约束条件和原则的应用程序或设计就是 RESTful架构或服务。
###2.resuful安全认证
	1.Http Basic Authentication：
	Http Basic 是一种比较简单的身份认证方式。在 Http header 中添加键值对 Authorization:  Basic xxx （xxx 是 username:passowrd base64 值）。
	2.Access Token（怎么设计）
	不知道是否应该这么称呼。原理即当客户端登录完毕之后，给客户端返回一个token，服务器端控制该token的有效期，每次请求都带上该值，然后服务器端做验证，退出之后，客户端通知服务端端销毁token，客户端本地也销毁。但是如果抓包获取到token，就能任意伪造请求了。
	同时 api 接口还存在被第三方开发者或者公司随意利用的风险。也就是说，别人可以非常轻易的就弄出一个你们 app 的复制版，而且还用的你们的所有资源。
	危险性高，实际开发估计使用得还不少。
	3.Api Key + Security Key + Sign
###3.oauth2.0 则属于第三方认证
###4.研究下其他接口
微信支付接口
微信报关接口
ping++接口

###分页
1.select sid from stock group by sid
2.简历时间
###token如何自己造
用户id,随机数，密钥，加密算法，有效时间，user_agent（操作系统版本）


