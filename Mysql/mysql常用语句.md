###1.子查询
	select * from push_talent where user_id = (select id from user_v2 where phone=15267607479);
###2.时间戳
	问题:invite_time = update_time +()  超过date格式的长度,会有警告,更新会失败 
	update push_talent set invite_time =   FROM_UNIXTIME ( UNIX_TIMESTAMP(update_time) + 
	( 1+rand() )*1800 ) where UNIX_TIMESTAMP(invite_time) = 0  
	update push_talent set deal_time =   FROM_UNIXTIME ( UNIX_TIMESTAMP(invite_time) + ( rand() )*600 )
---
通过:
update push_talent set pass_time =   FROM_UNIXTIME ( UNIX_TIMESTAMP(deal_time) + ( 1+rand() )*1800 ) where  resume_status=1
--
拒绝:
update push_talent set reject_time =   FROM_UNIXTIME ( UNIX_TIMESTAMP(deal_time) + ( 1+rand() )*1800 ) where  resume_status=2

--
收藏
update push_talent set favorite_time =   FROM_UNIXTIME ( UNIX_TIMESTAMP(update_time) + ( 1+rand() )*1800 ) where  favorite=1
-------
改成已读
update push_talent set read_status=1

3#####################################
获取push_talent表中的id集合,删选talent表的数据,resume_id不在id集合中
SELECT t.* FROM `talent` t
             WHERE 1
            AND t.job_category != 0
            AND t.job_category IN (1,2,3,4)
            AND t.push_status > 0
            AND t.id not in (select resume_id from push_talent where resume_status=2 and user_id=4)


-----
1.创建student和score表
CREATE  TABLE  student (
id  INT(10)  NOT NULL  UNIQUE  PRIMARY KEY  ,
name  VARCHAR(20)  NOT NULL ,
sex  VARCHAR(4)  ,
birth  YEAR,
department  VARCHAR(20) ,
address  VARCHAR(50) 
);
创建score表。SQL代码如下：
CREATE  TABLE  score (
id  INT(10)  NOT NULL  UNIQUE  PRIMARY KEY  AUTO_INCREMENT ,
stu_id  INT(10)  NOT NULL ,
c_name  VARCHAR(20) ,
grade  INT(10)
);
2.为student表和score表增加记录
## 向student表插入记录的INSERT语句如下：
INSERT INTO student VALUES( 901,'张老大', '男',1985,'计算机系', '北京市海淀区');
INSERT INTO student VALUES( 902,'张老二', '男',1986,'中文系', '北京市昌平区');
INSERT INTO student VALUES( 903,'张三', '女',1990,'中文系', '湖南省永州市');
INSERT INTO student VALUES( 904,'李四', '男',1990,'英语系', '辽宁省阜新市');
INSERT INTO student VALUES( 905,'王五', '女',1991,'英语系', '福建省厦门市');
INSERT INTO student VALUES( 906,'王六', '男',1988,'计算机系', '湖南省衡阳市');
## 向score表插入记录的INSERT语句如下：
INSERT INTO score VALUES(NULL,901, '计算机',98);
INSERT INTO score VALUES(NULL,901, '英语', 80);
INSERT INTO score VALUES(NULL,902, '计算机',65);
INSERT INTO score VALUES(NULL,902, '中文',88);
INSERT INTO score VALUES(NULL,903, '中文',95);
INSERT INTO score VALUES(NULL,904, '计算机',70);
INSERT INTO score VALUES(NULL,904, '英语',92);
INSERT INTO score VALUES(NULL,905, '英语',94);
INSERT INTO score VALUES(NULL,906, '计算机',90);
INSERT INTO score VALUES(NULL,906, '英语',85);
1.查询所有记录
SELECT * FROM student;
2.查询student表的第2到4条记录
SELECT * FROM student LIMIT 1,3;
3.从student表查询所有学生的学号（id）、姓名（name）和院系（department）的信息
SELECT id,name,department FROM student;
4.
统计学生最高分成绩
SELECT student.id,name,SUM(grade) FROM student,score WHERE student.id=score.stu_id GROUP BY id;
5.从student表中查询计算机系和英语系的学生的信息
select * from student where department in ('计算机系','英语系') 
6.18-20岁
select * from student where 2013-birth between 18 and 22
7.从student表中查询每个院系有多少人 
select department,count(*) from student group by department
8.从score表中查询每个科目的最高分
select c_name,max(grade) from score group by c_name
9.查询李四的考试科目（c_name）和考试成绩（grade）
①select  sco.c_name,sco.grade from score as sco,student as stu where stu.id=sco.stu_id and stu.name='李四'
②select  c_name,grade from score where stu_id =(select id from student where name='李四')
10.用连接的方式查询所有学生的信息和考试信息
①id取得是后面那张表,select  * from score as sco,student as stu where stu.id = sco.stu_id
②select  stu.id,name,sex,birth,department,address,c_name,grade from score as sco,student as stu where stu.id = sco.stu_id,可以看出先形成结果集
11.计算每个学生的总成绩
select stu.id,stu.name,sum(grade) from student as stu,score as sco where stu.id = sco.stu_id group by stu.id
12.计算每个考试科目的平均成绩
select c_name,avg(grade) from score group by c_name
13.查询同时参加计算机和英语考试的学生的信息
select a.* from student a,score b,score c where a.id=b.stu_id and b.c_name='计算机' and a.id=c.stu_id and c.c_name='英语'

----mysql优化
1)禁止3表以上的join
2)避免"select *"和排序功能共同使用
3)用jion替换子查询
4)用union all替换union
5)避免数据类型的转换，同数据类型比较
6)避免排序(通过索引或减少排序记录数)
7)对数据尽早过滤(复合索引过滤性更好的字段放的更靠前；尽量加少最后join结果集的数量)
8)把大sql拆分为多小sql
9)如果只是分组，用”group by a1 order by null“替换“group by a1”去除排序
10)禁止索引null列
11)字符例是否是前缀索引



///talent_mark重复
select * from talent where talent_mark in (select talent_mark as m from( select count(*) as num,id,talent_mark,talent_source from talent  where talent_mark != '0'  group by talent_mark  having num>1 order by num desc ) as t) order by talent_mark 



①delete from talent where talent_mark in (select talent_mark as m from( select count(*) as num,id,talent_mark,talent_source from talent  where talent_mark != '0'  group by talent_mark  having num>1 order by num desc ) as t) order by talent_mark;

②update talent set talent_mark=id where talent_mark is null or talent_mark='0';

###时间格式化
//查询时间，友好提示
$sql = "select date_format(create_time, '%Y-%m-%d') as day from table_name";
###int 时间戳类型
$sql = "select from_unixtime(create_time, '%Y-%m-%d') as day from table_name";
###替换某字段的内容的语句
update user set content = REPLACE(content, 'hello', 'hi') where content like "%hello%"
找到所有hello模糊匹配的记录，然后把hello替换成hi，
###获取表中某字段包含某字符串的数据（更模糊匹配没什么区别啊）
select * from user WHERE LOCATE('hi',content);
###获取字段中的前4位
$sql = "SELECT SUBSTRING(字段名,1,4) FROM 表名 ";

###删除表中多余的重复记录(留id最小)
	//单个字段
	$sql = "delete from 表名 where 字段名 in ";
	$sql .= "(select 字段名 from 表名 group by 字段名 having count(字段名) > 1)  ";
	$sql .= "and 主键ID not in ";
	$sql .= "(select min(主键ID) from 表名 group by 字段名 having count(字段名 )>1) ";