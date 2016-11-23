
###1.什么是存储过程：
存储过程（Stored Procedure）是在大型数据库系统中，一组为了完成特定功能的SQL 语句集。
优点：存储在数据库中，经过第一次编译后再次调用不需要再次编译
###2
1 .创建存储过程p1
create procedure p1()
select * from user
end; 
2 .call p1() 
表的数据就筛选出来了

DELIMITER $$
默认情况下，不可能等到用户把这些语句全部输入完之后，再执行整段语句。
因为mysql一遇到分号，它就要自动执行。
即，在语句RETURN '';时，mysql解释器就要执行了。
这种情况下，就需要事先把delimiter换成其它符号，如//或$$。

存储过程语法:变量，运算符，顺序，循环，分支结构




例子1：
假设有个后台管理系统，只要用户浏览记录，就会把这次浏览情况记录下来+1
①写存储过程：
DELIMITER $$
create procedure myproce()
begin
update user set count=count+1;
end
$$
②php程序中调用存储过程
$conn = mysql_connect('localhost','root','123456') or die ("数据连接错误!!!");
mysql_select_db('user',$conn);

$sql = "call user.myproce();";
mysql_query($sql);//调用myproce的存储过程，则数据库中将增加一条新记录。
例子2（传入参数的存储过程）
①
DELIMITER $$
create procedure myproce2(in flag int)
begin
if flag=1 then
select * from t1; 
else
select * from t2;
end if;
end
②
传值不同，取不同表的数据
$conn = mysql_connect('localhost','root','123456') or die ("数据连接错误!!!");
mysql_select_db('test',$conn);

$sql = "call test.myproce2(1);";
$res = mysql_query($sql);//调用myproce的存储过程，则数据库中将增加一条新记录。
var_dump(mysql_fetch_array($res,MYSQL_ASSOC));

例子3：传出参数的存储过程
①
DELIMITER $$
create procedure myproce3(out score int)
begin
set score = 80;
end
$$
②
$conn = mysql_connect('localhost','root','123456') or die ("数据连接错误!!!");
mysql_select_db('test',$conn);


$sql = "call test.myproce3(@score);";
mysql_query($sql);//调用myproce3的存储过程

$res = mysql_query('select @score as score;');

var_dump(mysql_fetch_array($res,MYSQL_ASSOC));
实例四：传出参数的inout存储过程
①
DELIMITER $$
create procedure myproce4(inout sexflag int)
begin
SELECT * FROM user WHERE sex = sexflag;
end; 
$$
②
$conn = mysql_connect('localhost','root','123456') or die ("数据连接错误!!!");
mysql_select_db('test',$conn);


$sql = "set @sexflag = 1";
mysql_query($sql);//设置性别参数为1
$sql = "call test.myproce4(@sexflag);";
$res = mysql_query($sql);//调用myproce4的存储过程

var_dump(mysql_fetch_array($res,MYSQL_ASSOC));
实例五：使用变量的存储过程
①
DELIMITER $$
create procedure myproce5(in a int,in b int)
begin
declare s int default 0;
set s=a+b;
select s;
end
$$
②

$sql = "call test.myproce5(4,6);";

$res = mysql_query($sql);//调用myproce4的存储过程

var_dump(mysql_fetch_array($res,MYSQL_ASSOC));
实例六：case语法
DELIMITER $$
create procedure myproce6(in sex int)
begin
case sex 
when 0 then select '男';
when 1 then select '女';
else select '未知';
end case;
end
$$

7.循环
DELIMITER $$
create procedure myproce7()
begin
declare i int default 0;
declare j int default 0;
while i<10 do
set j=j+i;
set i=i+1;
end while;
select j;
end; 
$$
调用：
8.循环：repeat
create procedure myproce8()
begin
declare i int default 0;
declare j int default 0;
repeat
set j=j+i;
set i=i+1;
until j>=10
end repeat;
select j;
end; 

9.循环loop
create procedure myproce9()
begin
declare i int default 0;
declare s int default 0;

loop_label:loop
set s=s+i;
set i=i+1;
if i>=5 then
leave loop_label;
end if;
end loop;
select s;
end;

10.删除

