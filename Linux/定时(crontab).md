###简单命令
	列出定时任务：crontab -l 
	编辑定时任务：crontab -e
###每个位置的意义
	*　　*　　*　　*　　*　   command
	分  时   日   月   周	    命令
	第1列表示分钟1～59 每分钟用*或者 */1表示 
	第2列表示小时1～23（0表示0点） 
	第3列表示日期1～31 
	第4列表示月份1～12 
	第5列标识号星期0～6（0表示星期天） 
	第6列要运行的命令 
	一个*下多个逗号，表示多个，
###例子
1.每晚的21:30重启apache。
30 21 * * * /usr/local/etc/rc.d/lighttpd restart 
2.每月1、10、22日的4 : 45重启apache。 
45 4 1,10,22 * * /usr/local/etc/rc.d/lighttpd restart 
3.每天18 : 00至23 : 00之间每隔30分钟重启apache。 
0,30 18-23 * * * /usr/local/etc/rc.d/lighttpd restart
4.每一小时重启apache 
0 */1 * * * /usr/local/etc/rc.d/lighttpd restart 
5.晚上11点到早上7点之间，每隔一小时重启apache 
0 23-7/1 * * * /usr/local/etc/rc.d/lighttpd restart 
6.每月的4号与每周一到周三的11点重启apache 
0 11 4 * mon-wed /usr/local/etc/rc.d/lighttpd restart 
7.星期一到星期五12：00，下午6：300执行一次脚本
0 12,18 * non-fri /script/stock.sh
###注意
crontab无法保存是语法问题，总共有5个*
sh给777才能不通过sh xx.sh执行
###使用权限
使用权限 : 所有使用者 
使用方式 : 
crontab file [-u user]-用指定的文件替代目前的crontab。 
crontab-[-u user]-用标准输入替代目前的crontab. 
crontab-1[user]-列出用户目前的crontab. 
crontab-e[user]-编辑用户目前的crontab. 
crontab-d[user]-删除用户目前的crontab. 
crontab-c dir- 指定crontab的目录。 
crontab文件的格式：M H D m d cmd. 
M: 分钟（0-59）。 
H：小时（0-23）。 
D：天（1-31）。 
m: 月（1-12）。 
d: 一星期内的天（0~6，0为星期天）。 
cmd要运行的程序，程序被送入sh执行，这个shell只有USER,HOME,SHELL这三个环境变量 
说明 : 
crontab 是用来让使用者在固定时间或固定间隔执行程序之用，换句话说，也就是类似使用者的时程表。-u user 是指设定指定 
user 的时程表，这个前提是你必须要有其权限(比如说是 root)才能够指定他人的时程表。如果不使用 -u user 的话，就是表示设 
定自己的时程表。 
