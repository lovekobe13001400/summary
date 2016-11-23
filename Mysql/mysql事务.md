###1.什么是事务
事务:在某件事件发展执行的过程中,所包含的所有操作(多个),或者事务是作为一个逻辑单元执行的一系列操作
###2.mysql客户端体验一下事务
①建立bank表（id,name,money） 
②开启事务：start transaction；  
③操作：第一个人-100  update bank set money=money-100 where id=1  
第二个人+100 update bank set money=money+100 where id=2;
数据实际是没有减得  
④提交事务：commit  数据改变  
缓存rollback就是回去了  

###3.事务原理：
事务到底是如何保持数据的一致性(最终要么都成功要么都失败)?
答案:数据是事务操作过程中,并不会直接写入到数据表,而是临时存放到当前用户对应的日志文件中,直到用户最终确认事务(commit),才会将日志中的操作记录同步到数据表;相反,如果用户不确认,系统会自动忽略所有操作(白做了)   

###4.回滚到
savepoint sp1;
update bank set money=money-100 where id=1

savepoint sp2;
update bank set money=money-100 where id=1
savepoint sp3;
update bank set money=money-100 where id=1

回滚：rollback to sp2  
money只减了100  

###5.自动事务（暂定）


###6.事务的acid（）
对于事务而言，它需要满足ACID特性，下面就简要的说说事务的ACID特性。

A（Atomicity），表示原子性；原子性指整个数据库事务是不可分割的工作单位。只有使事务中所有的数据库操作都执行成功，整个事务的执行才算成功。事务中任何一个sql语句执行失败，那么已经执行成功的sql语句也必须撤销，数据库状态应该退回到执行事务前的状态；  
C（Consistency），表示一致性；也就是说一致性指事务将数据库从一种状态转变为另一种一致的状态，在事务开始之前和事务结束以后，数据库的完整性约束没有被破坏；  
I（Isolation），表示隔离性；隔离性也叫做并发控制、可串行化或者锁。事务的隔离性要求每个读写事务的对象与其它事务的操作对象能相互分离，即该事务提交前对其它事务都不可见，这通常使用锁来实现；  
D（Durability），持久性，表示事务一旦提交了，其结果就是永久性的，也就是数据就已经写入到数据库了，如果发生了宕机等事故，数据库也能将数据恢复。   

###7.有哪些事务  
扁平事务；  
带有保存点的扁平事务；  
链事务；  
嵌套事务；  
分布式事务  


###8.事务隔离级别实践
①user表：id name age  
②我们可以可以用SET TRANSACTION语句改变单个会话或者所有新进连接的隔离级别  
设置隔离级别：SET [SESSION | GLOBAL] TRANSACTION ISOLATION LEVEL {READ UNCOMMITTED | READ COMMITTED | REPEATABLE READ | SERIALIZABLE}  
③验证可串行化（Serializable ）级别（打开2个mysql客户端）  
设置隔离级别：SET SESSION TRANSACTION ISOLATION LEVEL SERIALIZABLE  
查看隔离级别：select @@tx_isolation  
	客户端1开启事务，客户端2开启事务，客户端1都不能查看数据，只有客户端2commit事务，客户端1才能查看，所以不会出现脏读，不可重复和幻读  

④验证可重复读  
2个客户端设置隔离级别：SET SESSION TRANSACTION ISOLATION LEVEL REPEATABLE READ
       客户端1开启事务，客户端2开启事务，都能查看
	客户端2插入数据，commit事务，客户端1中查看，数据并没有增加，所以他是可重复读，读的还是开启事务的时候的数据（定格在这个时候的数据）
	当新添加的数据被修改了，客户端1就能查看到新数据了，这就出现了幻读

⑤验证已提交读
2个客户端设置隔离级别：SET SESSION TRANSACTION ISOLATION LEVEL READ COMMITTED  
	客户端1开启事务，客户端2开启事务，都能查看，客户端2插入数据，一旦客户端2提交，客户端1就能看见数据了
⑤验证未提交读	  
	客户端1开启事务，客户端2开启事务，都能查看，客户端2插入数据，客户端1就能查看数据了

使用事务主意:
1.使用小事务
2.选择合适的隔离级别
3.保证开始事务前一切都是可行的
4.避免死锁：事务直接互相block，a用b，b用a

锁：
表锁 lock table user Read(只能读),user2 Write（只有自己自己这个线程可读可写，其他李安读都不可以）
行锁
 

