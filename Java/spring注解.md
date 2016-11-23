一#利用proxy实现aop功能(主函数->代理->目标对象)
使用前提:目标对象必须要实现接口,否则不能使用这个方法
步骤:
1.创建接口:StudentInterface.java
2.创建接口实现类:Student.java
3.创建代理工厂类:ProxyFactory.java
---


注解技术（机制）： 对某些事物添加注释说明，存放某些信息。。。
1.java注解技术基本概念：
介绍：annotation是java5开始引入的新特征，中文名称一般叫注解，它提供了一种安全的类似注释的机制，用来将任何的信息或元数据（metadata），
与程序元素(类，方法，成员变量)进行关联
概念：对某些事物添加注释说明，存放某些信息。。。，通过反射机制，在某段时间提取出来
原理：接口，
应用场合：软件框架，

2.标准注解
@Override ：标准方法，重载了父类方法
@deprecated 延续性
@suppressWarinings 关闭类等警告
3.元注解：负责注解其他的注解
@Target 描述注解的使用范围
	取值范围：
	constructor:描述构造器
	field：域
	local_variable：局部变量
	method：方法
	package：包
	parameter：参数
	type：类，接口...
@Retention：在什么级别保存该注释信息，用于描述注解的生命周期me
	范围：
	source:源文件
	class：class文件
	runtime:运行时有效
	
@Documented：成员的公共api用于描述其他类型的annotation应该被作为被标注的程序
@Inherited：标记注解
4.自定义注解：

5.注解元素默认值

---
@Resource 注解被用来激活一个命名资源（named resource）的依赖注入，在JavaEE应用程序中，该注解被典型地转换为绑定于JNDI context中的一个对象。 Spring确实支持使用@Resource通过JNDI lookup来解析对象，默认地，拥有与@Resource注解所提供名字相匹配的“bean name（bean名字）”的Spring管理对象会被注入。 在下面的例子中，Spring会向加了注解的setter方法传递bean名为“dataSource”的Spring管理对象的引用。


































二.#spring注解方式实现aop功能
1.引入jar文件
2.配置aop命名空间
3.创建目标对象类
4.创建切面
5.在配置文件中配置切面
6.创建入口类进行测试
