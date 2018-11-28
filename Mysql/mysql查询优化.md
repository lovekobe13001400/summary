1资料：https://www.cnblogs.com/wangning528/p/6388538.html


###1.mysql的性能优化包罗甚广： 
	索引优化，
	查询优化，
	查询缓存，
	服务器设置优化，
	操作系统和硬件优化，
	应用层面优化（web服务器，缓存）
###2.建立索引的几个准则：
	1、合理的建立索引能够加速数据读取效率，不合理的建立索引反而会拖慢数据库的响应速度。 
	2、索引越多，更新数据的速度越慢。
	3、尽量在采用MyIsam作为引擎的时候使用索引（因为MySQL以BTree存储索引），而不是InnoDB。但MyISAM不支持Transcation。
	4、当你的程序和数据库结构/SQL语句已经优化到无法优化的程度，而程序瓶颈并不能顺利解决，那就是应该考虑使用诸如memcached这样的分布式缓存系统的时候了。 
	5、习惯和强迫自己用EXPLAIN来分析你SQL语句的性能。

###3.
SELECT TOP 300 COL1,COL2,COL3 FROM T1 区别于select * 

###4.索引字段上进行运算会使索引失效。

###5.避免使用!=或＜＞、IS NULL或IS NOT NULL、IN ，NOT IN等这样的操作符.
因为这会使系统无法使用索引,而只能直接搜索表中的数据。例如: SELECT id FROM employee WHERE id != “B%” 优化器将无法通过索引来确定将要命中的行数,因此需要搜索该表的所有行。在in语句中能用exists语句代替的就用exists.

###6.
一部分开发人员和数据库管理人员喜欢把包含数值信息的字段 设计为字符型，这会降低查询和连接的性能，并会增加存储开销。这是因为引擎在处理查询和连接回逐个比较字符串中每一个字符，而对于数字型而言只需要比较一次就够了。
那就bigint啊 才占8字节  能省点空间
varchar


###7.
合理使用EXISTS,NOT EXISTS子句
1.SELECT SUM(T1.C1) FROM T1 WHERE (SELECT COUNT(*)FROM T2 WHERE T2.C2=T1.C2>0) 2.SELECT SUM(T1.C1) FROM T1WHERE EXISTS(SELECT * FROM T2 WHERE T2.C2=T1.C2) 两者产生相同的结果，但是后者的效率显然要高于前者。因为后者不会产生大量锁定的表扫描或是索引扫描。如果你想校验表里是否存在某条纪录，不要用count(*)那样效率很低，而且浪费服务器资源。可以用EXISTS代替。如： IF (SELECT COUNT(*) FROM table_name WHERE column_name = ‘xxx’)可以写成：IF EXISTS (SELECT * FROM table_name WHERE column_name = ‘xxx’)

7. 能够用BETWEEN的就不要用IN

8. 能够用DISTINCT的就不用GROUP BY

9. 尽量不要用SELECT INTO语句。SELECT INTO 语句会导致表锁定，阻止其他用户访问该表。

10.必要时强制查询优化器使用某个索引

11.
尽管在所有的检查列上都有索引，但某些形式的WHERE子句强迫优化器使用顺序存取。如： SELECT * FROM orders WHERE (customer_num=104 AND order_num>1001) OR order_num=1008 解决办法可以使用并集来避免顺序存取： SELECT * FROM orders WHERE customer_num=104 AND order_num>1001 UNION SELECT * FROM orders WHERE order_num=1008 这样就能利用索引路径处理查询。【jacking 数据结果集很多，但查询条件限定后结果集不大的情况下，后面的语句快】