###1.优化查询的查询缓存
	// 语句1：query cache does NOT work
	$r = mysql_query("SELECT username FROM user WHERE signup_date >= CURDATE()");
	 
	//语句2： query cache works!
	$today = date("Y-m-d");
	$r = mysql_query("SELECT username FROM user WHERE signup_date >= '$today'");
	查询缓存在第一行不执行的原因在于CURDTE()功能的使用。这适用于所有的非确定性功能，就像NOW()和RAND()等等。。。因为功能返回的结果是可变的。MySQL决定禁用查询器的查询缓存。我们所需要做的是通过添加一额外一行PHP，在查询前阻止它发生。
###2.EXPLAIN你的选择查询
 explain select * from ims_ewei_shop_goods，获取相关信息
###3. 获取唯一行时使用LIMIT 1
LIMIT 1添加到查询条件中可以提高性能。这样，数据库引擎将在找到刚刚第一个记录之后停止扫描记录，而不是遍历整个表或索引。
###4.索引搜索字段
索引不仅仅是为了主键或唯一键。如果你会在你的表中按照任何列搜索，你就都应该索引它们。比如经常在where后面的搜索字段
###5.索引并对连接使用同样的字段类型
使用连接查询，所用字段的类型一致，这样才能用到索引
###6. 不要ORDER BY RAND()
###7. 避免使用SELECT *
###8. 几乎总是有一个id字段
###9. 相比VARCHAR优先使用ENUM，感觉这个用的不够多
###10. 使用PROCEDURE ANALYSE()获取建议
###11. 如果可以的话使用NOT NULL
NULL列需要额外的空间，他们增加了你的比较语句的复杂度。如果可以的话尽量避免它们。当然，我理解一些人，他们也许有非常重要的理由使用NULL值，这不总是一件坏事。
###12. 预处理语句
使用预处理语句有诸多好处，包括更高的性能和更好的安全性。
###13.使用 UNSIGNED INT 存储IP地址（有点麻烦，绕来绕去）
很多程序员没有意识到可以使用整数类型的字段来存储 IP 地址，所以一直使用 VARCHAR(15) 类型的字段。使用 INT 只需要 4 个字节的空间，而且字段长度固定。

必须确保列是 UNSINGED INT 类型，因为 IP 地址可能会用到 32 位无符号整型数据的每一个位。

在查询中可以使用 INET_ATON() 来把一个IP转换为整数，用 INET_NTOA() 来进行相反的操作。在 PHP 也有类似的函数，ip2long() 和 long2ip()。
###14.
###15. 固定长度（静态）的表会更快

（译者注：这里提到的表的长度，实际是指表头的长度，即表中每条数据占用的空间大小，而不是指表的数据量）

如果表中所有列都是“固定长度”，那么这个表被认为是“静态”或“固定长度”的。不固定的列类型包括 VARCHAR、TEXT、BLOB等。即使表中只包含一个这些类型的列，这个表就不再是固定长度的，MySQL 引擎会以不同的方式来处理它。

固定长度的表会提高性能，因为 MySQL 引擎在记录中检索的时候速度会更快。如果想读取表中的某一地，它可以直接计算出这一行的位置。如果行的大小不固定，那就需要在主键中进行检索。

它们也易于缓存，崩溃后容易重建。不过它们也会占用更多空间。例如，如果你把一个 VARCHAR(20) 的字符改为 CHAR(20) 类型，它会总是占用 20 个字节，不管里面存的是什么内容。

你可以使用“垂直分区”技术，将长度变化的列拆分到另一张表中。来看看：
###16. 垂直分区

垂直分区是为了优化表结构而对其进行纵向拆分的行为。

示例 1: 你可能会有一张用户表，包含家庭住址，而这个不是一个常用数据。这时候你可以选择把表拆分开，将住址信息保存到另一个表中。这样你的主用户表就会更小。如你所知，表越小越快。

示例 2: 表中有一个 "last_login" 字段，用户每次登录网站都会更新这个字段，而每次更新都会导致这个表缓存的查询数据被清空。这种情况下你可以将那个字段放到另一张表里，保持用户表更新量最小。

不过你也需要确保不会经常联合查询分开后的两张表，要不然你就得忍受由这带来的性能下降。
###17. 拆分大型DELETE或INSERT语句
如果你的维护脚本需要删除大量的行，只需使用LIMIT子句，以避免阻塞。
while (1) {
    mysql_query("DELETE FROM logs WHERE log_date <= '2009-10-01' LIMIT 10000");
    if (mysql_affected_rows() == 0) {
        // done deleting
        break;
    }
    // you can even pause a bit
    usleep(50000);
}
###18. 越小的列越快
对于数据库引擎来说，磁盘空间可能是最需要注意的瓶颈。对性能而言，“小”和“紧缩”有助于减少磁盘传输量。

MySQL 文档中有一个列表，列举了各种数据类型所需要的存储空间。

如果数据表预计只会有少量的行，那就没必要把主键定义为 INT 类型，可以用 MEDIUMINT、SMALLINT 甚至 TINYINT 来代替。（译者注：对于日期数据，）如果不需要时间部分，就应该使用 DATE 而不是 DATETIME。

请确保留出合理的数据成长空间，不然就可能造成像Slashdot那样的结果（译者注：Slashdot 因为数据增长将评论表的主键改为了 INT 型，但没有修改其父表中的相应的数据类型，虽然一个 ALTER 语句就可以解决问题，但是需要至少停止某些业务三个小时）。
###19. 选择正确的存储引擎

MySQL 有两个主要的存储引擎：MyISAM 和 InnoDB，它们各有利弊。

MyISAM 适用于读请求特别多的应用，但不适用于有大量写请求的情况。甚至你只是要更新一行中的某个字段，都会造成整张表被锁，然后直到这个查询完成，其它进程都不能从这张表读取数据。MyISAM 在计算 SELECT COUNT(*) 这种类型的查询时速度非常快。

InnoDB 是一个复杂的存储引擎，在多数小型应用中它比 MyISAM 慢。但是它支持行级锁，有更好的尺度。它还支持一些高级特性，比如事务。

MyISAM 存储引擎

InnoDB 存储引擎
###20. 使用对象关系映射器（ORM, Object Relational Mapper）

通过使用ORM（对象关系映射器），你可以获得一定的性能提升。ORM可以完成的一切事情，手动编码也可完成。但这可能意味着需要太多额外的工作，并且需要高水平的专业知识。

ORM以“延迟加载”著称。这意味着它们仅在需要时获取实际值。但是你需要小心处理他们，否则你可能最终创建了许多微型查询，这会降低数据库性能。

ORM还可以将多个查询批处理到事务中，其操作速度比向数据库发送单个查询快得多。

目前我最喜欢的PHP-ORM是Doctrine。我写了一篇关于如何安装Doctrine与CodeIgniter的文章（install Doctrine with CodeIgniter）。
###21. 小心使用持久连接

持久连接意味着减少重建连接到MySQL的成本。 当持久连接被创建时，它将保持打开状态直到脚本完成运行。 因为Apache重用它的子进程，下一次进程运行一个新的脚本时，它将重用相同的MySQL连接。

PHP：mysql_pconnect()

理论上看起来不错。 但从我个人（和许多其他人）的经验看来，这个功能可能会导致更多麻烦。 你可能会出现连接数限制问题、内存问题等等。

Apache总是并行运行的，它创建许多子进程。 这是持久连接在这种环境中不能很好工作的主要原因。 在你考虑使用mysql_pconnect()之前，请咨询你的系统管理员。

