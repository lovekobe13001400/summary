1.mysql什么时候要添加索引：
表太大，查询慢
2.
800万：2.48s

添加索引：查询反而变慢了，为什么
https://blog.csdn.net/gaoshan12345678910/article/details/78840158

500万：
explain select * from user where name='c'



1。高性能mysql之前缀索引



#先删除自增长在删除主键
#alter table t_name change time1 id int;-- 删除自增长
#alter table t_name drop primary key;-- 删除主建
alter table test add index(t_name);


###3.explain的解释
