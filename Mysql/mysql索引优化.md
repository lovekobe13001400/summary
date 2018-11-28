资料：
1.https://www.cnblogs.com/yyjie/p/7486975.html
2.https://blog.csdn.net/dennis211/article/details/78170079

###mysql索引
	1.使用了BTREE索引，意味着所有的索引是按顺序排列存储的（升序），mysql就是这么干的，mysl中的BTREE索引抽象结构如下图（参考高性能mysql）
	2.
	 包含一列的索引称为单列索引，多列的称为复合索引，因为BTREE索引是顺序排列的，所以比较适合范围查询，但是在复合索引中，还应注意列数目、列的顺序以及前面范围查询的列对后边列的影响。

###表
	create table staffs(
	    id int primary key auto_increment,
	    name varchar(24) not null default '' comment '姓名',
	    age int not null default 0 comment '年龄',
	    pos varchar(20) not null default '' comment '职位',
	    add_time timestamp not null default current_timestamp comment '入职时间'
	  ) charset utf8 comment '员工记录表';
	
	  ##添加三列的复合索引
	  alter table staffs add index idx_nap(name, age, pos);

###1.全值匹配：
	
	explain select * from staffs where name = 'July' and age = '23' and pos = 'dev' 
	1. possible_keys：显示可能应用在这张表中的索引，一个或多个。查询涉及到的字段上若存在索引，则该索引奖杯列出，但不一定被查询实际使用。
	2. key：实际使用的索引，若为null，则没有使用到索引。（两种可能，①没建立索引。②建立索引，但索引失效）。查询中若使用了覆盖索引，则该索引仅出现在key列表中。
	3. key_len：表示索引中使用的字节数，可通过该列计算查询中使用的索引的长度。在不损失精确型的情况下，长度越短越好，key_len显示的值为索引字段的最大可能长度，并非实际使用长度，即key_len是根据定义计算而得，不是通过表内检索出的。
	4.ref:显示索引的哪一列被使用了，有时候会是一个常量：表示哪些列或常量被用于用于查找索引列上的值
	type是range的查询计划，ref都是NULL的，并不是说没用到索引 
	5.type类型：
	all:全表扫描
	index：这种连接类型只是另外一种形式的全表扫描，只不过它的扫描顺序是按照索引的顺序
	range：ange指的是有范围的索引扫描，相对于index的全索引扫描，它有范围限制，因此要优于index
	ref:出现该连接类型的条件是： 查找条件列使用了索引而且不为主键和unique。其实，意思就是虽然使用了索引，但该索引列的值并不唯一，有重复。这样即使使用索引快速查找到了第一条数据，仍然不能停止
	ref_eq:ref_eq 与 ref相比牛的地方是，它知道这种类型的查找结果集只有一个？什么情况下结果集只有一个呢！那便是使用了主键或者唯一性索引进行查找的情况，
	const:通常情况下，如果将一个主键放置到where后面作为条件查询，mysql优化器就能把这次查询优化转化为一个常量。至于如何转化以及何时转化，这个取决于优化器
###2. 匹配最左列，对于复合索引来说，不总是匹配所有字段列，但是可以匹配索引中靠左的列
	如select * from staffs where name = 'July' and age = '23'，key字段显示用到了索引，注意，key_len字段（表示本次语句使用的索引长度）数值比上一条小了，意思是它并未使用全部索引列（通常这个长度可估摸着用了哪些索引列，埋个坑），事实上只用到了name和age列
   2.explain select * from staffs where age>10 没有索引
	只有有了name,age才会有索引
	

###3.匹配列前缀：
	1.select * fromstaffs where name like 'J%'，explain信息的key字段表示使用了索引
	2.select * from staffs where name like '%y' 或者 like '%u%'，不会用的索引

###4.匹配范围，
###5.精确匹配一列并范围匹配右侧相邻列
###6.只访问索引的查询，
1.explain select name,age,pos from staffs where name = 'July' and age = 25 and pos = 'dev',type：ref,全部索引列
2.explain select * from staffs where name = 'July' and age = 25 and pos = 'dev'，type：ref,全部索引列

	