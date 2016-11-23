###数据库三大范式
    F1第一范式（原子性）
    一张表中的某个字段里面的数据在获取之后可以直接使用，而不需要进行拆分或者进行其他加工。
    比如position字段还能拆分，这就违背了第一范式
###关系型数据库：建立在关系模型上的数据库（数据结构（二维表），操作指令的集合和完整性约束###
###SQL查询语言:DDL,DML,DCL,DQL###
	DDL(Data Definition Language)：数据库模式定义语言，关键字：create
	DML(Data Manipulation Language)：数据库操纵语言，关键字：Insert、delete、update
	DCL(Data control Language)：数据库控制语言 ，关键字：grant、remove
	DQL(Data query Language)：数据库查询语言，关键字：select
###校对集###
	校对集:比较的集合，在某种具体的编码格式下，对数据的比较方式的集合。
    分类(排序的时候使用):
	_bin：binary，二进制比较，理解为区分大小写
	_cs：case sensitive，大小写敏感，区分大小写
	_ci：case insensitive，大小写不敏感，不区分大小写（统一大小写之后比较）
    查看校对集:show collation
    常用校对集:utf8_general_ci,
###数据类型###
	枚举:enum, day enum('星期一','星期二','')
    存储原理：系统在日志文件中保存了一份数值与具体元素的对应关系，当数据进行查询或者插入操作的时候，系统会去日志文件中进行匹配
###列属性(字段)###
    常见的列属性有以下：comment，NULL/NOT NULL，Primary key，auto_increment，Unique key，default
###蠕虫复制###
    Insert into 表名[(字段列表)] select 字段列表 from 表名；
###主键重复###
  	①Insert into 表名 [(字段列表)] values(值列表) on duplicate key update 字段 = 值
    ②replace into 表名 [(字段列表)] values(值列表)
###sql查询###
	Select [select选项] */字段列表[字段别名] from 数据源 [where子句] [group by子句] [having子句] [order by子句] [limit子句]
    [select选项]:Distinct去重,
    例如: select distinct name from ...,
###连表###
	select *　from t1,t2 ,笛卡尔积
    From后面可以接select语句（子查询）,必须使用别名
    例如:select *　from (select * from table ) as t
###判断null###
	where data is null/is not null
###where条件的原理####
	Where条件的筛选原理：从磁盘上读取一条记录进入到内存，马上进行where条件判断，如果判断结果成立：存放在内存中；如果不成立：不放在内存中；等所有记录都读取结束之后，返回内存中的数据。Where子句之后的所有操作，都是基于内存中的数据操作
###groupby原理
   	分组原理：先根据某个字段进行分组，但是在分组之后合并数据返回的时候，系统在自动选择每组里面的第一条记录。
    分组统计运算:
    Count()：统计记录数，参数可以是*或者是某个字段名（不统计为null字段）
	Sum()：求某个字段的和
	Max()：某个字段的最大值
	Min()：某个字段最小值
	Avg()：某个字段的平均值
    with rollup:回溯,只要结果向上回溯一次，就会产生一次回溯统计
	如果分了多层，就会产生多次回溯
###Having子句###
	Having是用来对内存中的数据进行筛选；where是对磁盘中的数据进行筛选
	①Where不能做having能做的事情：having能够使用group by的 统计结果，而where不能使用
	②Where不能使用字段别名而having可以
###Order by子句###
	Order by可以进行多字段排序：在第一个字段排序的结果上，再对其他字段进行排序
###limit ###
	Limit offset,length;	-- 限制从第几条数据开始，获取指定长度的记录：默认的offset值为0：mysql的记录编号从0开始
###联合查询###
	联合查询:将多个查询的结果，联合起来横向的相加（记录数相加而字段数不改变
    语法:Select 语句1 Union [联合查询选项] Select 语句2
    注意1:字段数一样就能联合查询
    注意2:如果要在union联合查询中使用order by，那么必须给select语句使用()包裹
    注意3:Order by不能生效：order by在union中使用必须搭配limit
###内外链接###
	内连接:只连接匹配的行,
	左外链接:包含左边表的全部行,以及右边表中全部匹配的行,左定,右一一匹配
	右外连接:包含右边表的全部行,以及左边表中全部匹配的行,右定,左一一匹配
	交叉连接:笛卡尔积
###索引###
	索引:索引是一种文件,是一种能够帮助系统去在查询数据的时候快速定位或者写数据的时候进行数据约束的一种文件
	主键索引:不允许重复且不能为空
	唯一索引:不允许重复但是可以为空
	普通索引:index,普通索引效率比较低(占用空间比较少)
	全文索引:从一堆文字中快速的定位或者进行匹配(索引都是在插入数据的时候就已经建立)
	优点:增加查询效率
	缺点:占据存储空间
    ![](image/5699ddb7b588b.jpg)![](image/5699ddc1c7f71.jpg)![](image/5699ddcc5bf7b.jpg)

###mysql的sql语句的执行频率###
	show [session|global] status like '%Com_%'
	Com_select ：执行 select 操作的次数，一次查询只累加 1 。
    Com_insert ：执行 INSERT 操作的次数，对于批量插入的 INSERT 操作，只累加一次。
	Com_update ：执行 UPDATE 操作的次数。
	Com_delete ：执行 DELETE 操作的次数
###慢查询定位低效率的sql###
	查看慢查询(log_slow_queries)是否开启:show variables like '%quer%';
	开启慢查询:set global slow_query_log='ON'
###explain分析低效的sql###
    explain
###show profile分析sql###
	查看是否支持profile:select @@have_profiling
	查看profile是否开启:select @@profiling
	设置开启:set profiling=1
	执行sql完毕,查看sql语句的执行情况;show profiles
	某一条sql语句执行过程中的线程状态:show profiles for query q_id