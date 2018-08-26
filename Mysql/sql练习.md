###1.获取表的奇数行
练习地址：https://www.nowcoder.com/practice/e3cf1171f6cc426bac85fd4ffa786594?tpId=82&&tqId=29829&rp=7&ru=/activity/oj&qru=/ta/sql/question-ranking

select e1.first_name from employees e1 where (select count(*) from employees e2 where e1.first_name>=e2.first_name)%2=1
###2.按照salary的累计和running_total，其中running_total为前两个员工的salary累计和，员工salary累加类似于sum += 100
题目地址：https://www.nowcoder.com/practice/58824cd644ea47d7b2b670c506a159a6?tpId=82&&tqId=29828&rp=8&ru=/activity/oj&qru=/ta/sql/question-ranking

sql：思考为什么是s1.salary
SELECT s2.emp_no,s2.salary,SUM(s1.salary) AS running_total FROM salaries AS s1 
INNER JOIN salaries AS s2 ON s1.emp_no <= s2.emp_no
WHERE s1.to_date = "9999-01-01"AND s2.to_date = "9999-01-01"
GROUP BY s2.emp_no


###3.case的使用
题目地址：https://www.nowcoder.com/practice/5cdbf1dcbe8d4c689020b6b2743820bf?tpId=82&tqId=29827&rp=8&ru=/activity/oj&qru=/ta/sql/question-ranking
题目的用法：主要考察case的用法
select e.emp_no,e.first_name,e.last_name,b.btype,s.salary,
(CASE b.btype 
 WHEN 1 THEN s.salary * 0.1
 WHEN 2 THEN s.salary * 0.2
 ELSE s.salary * 0.3 END) as bonus from employees e
inner join emp_bonus b on e.emp_no=b.emp_no
inner join salaries s on e.emp_no=s.emp_no
where s.to_date='9999-01-01'
###4.更视图进行相连
select e.* from employees e,emp_v v where e.emp_no=v.emp_no

###5.
exists关键字:强调的是是否返回结果集，不要求知道返回什么。只要返回了字段，就是真。

###6.not exists
select * from employees s where not exists
(select 1 from dept_emp d where d.emp_no=s.emp_no)
###7查找排除当前最大、最小salary之后的员工的平均工资avg_salary。可能会排出多个
select avg(salary) avg_salary from salaries where to_date='9999-01-01'
and salary!=(select max(salary) from salaries where to_date='9999-01-01')
and salary!=(select min(salary) from salaries where to_date='9999-01-01')
###8.按照dept_no进行汇总，属于同一个部门的emp_no按照逗号进行连接，结果给出dept_no以及连接出的结果employees

select dept_no,group_concat(emp_no,',') as employees from dept_emp
group by dept_no
###9.获取Employees中的first_name，查询按照first_name最后两个字母，按照升序进行排列(字符串一些函数的使用)
select first_name from employees
order by substr(first_name,length(first_name)-1) asc
###10.给子表增加一个外键
alter table audit add foreign key(EMP_no) references employees_test(ID)
###11.update和replace的区别

###12.distinct
select distinct emp_no,title from titles_test
emp_no,title同时去重
1001 abc
1002 abc
1001 bbb
1001 abc
只会把1001 abc去重

select count( distinct emp_no,title )from titles_test
去重后的数目（共8条，重复2条，最后还剩1条）
但往往只用它来返回不重复记录的条数，而不是用它来返回不重记录的所有值。其原因是 distinct只能返回它的目标字段，而无法返回其它字段

###13.insert  ignore into test values(null,'aa')

###14.一次性插入多条数据
insert into test 
(name,age)
values
('jack',11),
('tom',12),
('amy',13)
###15.对所有员工的当前(to_date='9999-01-01')薪水按照salary进行按照1-N的排名，相同salary并列且按照emp_no升序排列
select s1.emp_no,s1.salary,count(distinct s2.salary) as rank from salaries s1,salaries s2
where s1.to_date='9999-01-01' and s2.to_date='9999-01-01' and s1.salary<=s2.salary
group by s1.emp_no
order by rank asc,s1.emp_no as

###16.获取薪资涨幅的次数
select 
sum(
	(select 
	 case 
	 when s1.salary<s2.salary then 1
	 else 0
	 end
	 from salary s2 where s1.to_date<s2.to_date order by s2.to_date asc limit 1
 	)
) 
 as num

from salary s1

###17获取多个部门薪资涨幅的次数
select *,(select(sum(
		(select(sum(
		
			(select case when s1.salary<s2.salary then 1 else 0 end from salaries s2 where s2.to_date<s1.to_date order by s2.to_date asc limit 1 )
		
		)) from salaries s1 where s1.emp_no=e.emp_no)
	
	)) from dept_emp e where e.dept_no = d.dept_no ) 


from departments d


###薪资的涨幅，grouth,上班到现在的涨幅是多少
会把员工没有薪资的，只有一个月薪资的都筛选出来
select e.emp_no,
((select salary from salaries s1 where s1.emp_no=e.emp_no and s1.to_date='9999-01-01' order by s1.to_date desc limit 1 ) -
(select salary from salaries s2 where s2.emp_no=e.emp_no order by s2.to_date asc limit 1 )) growth 
 from employees e order by growth asc

用inner join(结束日记就是今天to_date='9999-01-01')
开始时间就是hire日期==from-date

select s1.salary- s2.salary from employees e
inner join salaries s1 on e.emp_no=s1.emp_no and s1.to_date='9999-01-01'
inner join salaries s2 on e.emp_no=s2.emp_no and s2.from_date=e.hire_date
group by e.emp_no
###薪资每个月的涨幅情况


###18.行转列
https://blog.csdn.net/sinat_27406925/article/details/77507478


###19.第二高的薪资
select max(salary) from salaries s1 where salary not in (select max(salary) from salaries s2)
###20.having的使用
select count(*) as num from titles_test group by title having num>2

###21薪水涨幅次数
select s1.emp_no,sum((select case when s2.salary>s1.salary then 1 else 0 end from salaries s2 where s2.to_date<s1.to_date order by s2.to_date asc limit 1)) as t
from salaries s1
group by s1.emp_no
having t>5