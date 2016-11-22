##ls命令

ls [-选项] [参数:对象] ls -la /etc  
①ls -la /etc -l:long 长格式:权限,用户组,时间等  
②ls -a: 所有,包括.开始的隐藏文件  
③ls /etc 产看etc目录下的文件  
④ls -l:long(长格式显示)  
⑤ls -lh:h人性化显示,文件大小按照kb,m,g算  
⑥ls -ld:d显示当前目录  
⑦ls -i:文件id号  

###文件分析

-rwxrwxrwx:-表示这是一个文件  
drwxrwxrwx:d表示这是一个目录   
lrwxrwxrwx:l这是一个软链接  
- rwx rwx rwx  
r:可读  
w:可写  
x:可执行  
-:如果是-没有权限  

###创建目录

mkdir:创建目录
mkdir -p waker/music/a.mp3 : -p递归创建

###显示当前目录

pwd:显示当前所在目录

###删除空目录

rmdir empty

###复制文件或者目录

cp /dic/a.txt /tmp ##从原文件或目录复制到目标目录
cp -r waker ../ ##-r复制目录
cp /t1 /t2 /t3 /tmp ##可以多个复制
cp -p /a.txt /root ##-p保留文件属性,比如修改时间 
cp -r /music /root/music2 ##如果music2存在就是复制目录到music2,如果不存在就是重命名

###剪切目录

剪切目录:mv 
mv /dic /root :剪切目录,没有递归等要求,文件,目录,空目录都可以剪切
当前目录改文件名
mv a.txt b.txt 虽然是剪切,可以当做改名,b.txt不存在就是重命名

###删除文件或者目录

rm a.txt
rm -r /waker :递归删除

###软连接

waker目录下创建article和music:mkdir article music  
article: vi a.txt创建文件  
article中的a.txt软连接到music  
①创建软链接到waker/music/并重命名为a.txt.soft(可以理解为快捷方式)  
ls ln -s /waker/article/a.txt /waker/music/a.txt.soft  
②ls -l /waker/music/a.txt.soft(查看软连接文件)  
结果:lrwxrwxrwx 1 root root 20 Oct 1 01:41 /waker/music/  a.txt.soft -> /waker/article/a.txt  