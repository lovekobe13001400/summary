1.新建web项目
2.导入tomcat包，buildpath-myeclipse server ...
3.lib导入Struts spring hibernate 数据库驱动包等
4.添加struts.xml到src目录下
5.配置web.xml
6.添加spring配置文件
①添加spring配置文件applicationContext.xml 到src目录下；
②在web.xml中注册spring监听器，启动spring容器：

--
整合测试项目

1.预期：如果可以在action中能够正确调用service里面的方法执行并返回到一个页面中；那么我们认定struts和spring的整合是成功的。

编写JUnit测试类，测试spring加载是否正确
2.编写 TestService 接口 和实现类 TestServiceImpl
3.在applicationContext.xml中添加bean扫描配置信息；这边使用导入配置文件的方式配置。
①首先在cn.itcast.test.conf中建立test-spring.xml，里面内容： 
<!-- service -->
	<context:component-scan base-package="cn.itcast.test.service.impl" />	 
②将test-spring.xml导入到applicationContext.xml中如下：
 
<import resource="classpath:cn/itcast/*/conf/*-spring.xml" />	 


4.编写TestAction类
5.在test的conf文件夹下新建test-struts.xml中配置TestAction ：
将test-struts.xml导入到struts.xml文件中。
在webRoot目录下新建test/test.jsp
在浏览器中输入：http://localhost:8080/itcastTax/test.action 查看后台是否能输入service中的打印信息。

--
整合hibernate 和 spring 
1.在applicationContext.xml中配置
  	①yi配置c3p0数据库连接源：
	②配置sessionFactory，并将dataSource指向c3p0创建的dataSource：
	③编写实体类Person和对应的映射文件Person.hbm.xml：
        ④编写完实体映射文件后，用JUnit测试hibernate和spring的整合，在测试用例中启动spring容器的时候将扫描Person类根据其创建数据库表，并在测试时将向表插入一条数据。
	测试hibernate，添加一个人员
	⑤测试框架分层的整合(service 与 dao)
	TestDao 中新增方法 save ，在TestService中通过调用testDao来保存人员信息
