####参考教程:http://www.liaoxuefeng.com/#
##git init

##Git是分布式版本控制系统，所以，每个机器都必须自报家门##
	$ git config --global user.name "Your Name"
	$ git config --global user.email "email@example.com"
##创建版本库(待定整理添加)##
##文件添加,提交到仓库##
	第一步，用命令git add告诉Git，把文件添加到仓库(添加到暂存区)：
	$ git add readme.txt
	第二步，用命令git commit告诉Git，把文件提交到仓库(提交到当前分支)：
	$ git commit -m "wrote a readme file"
##git常用命令##
	①git status : 查看git仓库的状态,比如修改的文件,未提交的文件
	②git diff : 查看某个文件的改变
	③git log :查看提交日志
	④git reset --hard HEAD^  上一个版本
	 git reset --hard HEAD^^ 上两个版本
	 git reset --hard 3628164 某一个版本,版本号不用写全,git会自己寻找
	 git reset HEAD readme.txt 把暂存区的修改回退到工作区
	⑤git reflog :记录你的每一次命令,回退到历史版本,又想回退到新版本,用这个命令
##git工作区和暂存区##
	工作区:tkadmin
	版本库:tkadmin下.git,有暂存区,自动创建的分支master,指向maser的一个指针head
	暂存区:版本库的stage(index)就是暂存区
##git checkout的使用##
	①git checkout -- readme.txt 撤销文件在工作区的修改,就是让文件回到最近一次git commit或git add时的状态.
	②git reset HEAD readme.txt 把暂存区的修改回退到工作区
##总结1##
	场景1: 改乱工作区某个文件内容,直接丢弃工作区的修改, git checkout -- file
	场景2: 改乱并添加到了暂存区,丢弃修改,①git reset HEAD file回到场景1,在操作场景1
	场景3: 提交到版本库,那就版本回退
##远程仓库待定##
##克隆仓库地址##
	git clone 仓库地址(ssh地址或http地址)
##创建和合并分支##
	创建分支 git branch dev
	切换分支 git checkout dev
	创建并切换分支: git checkout -b dev
	显示所有分支: git branch
	切换回master,合并分支dev:git merge dev
	删除分支:git branch -d dev
##解决冲突##
##查看远程库信息##
	git remote -v 
##git保存密码
	git config --global credential.helper store
##删除本地分支
$ git branch -D grap(分支名)

###git上传代码
git add .        （注：别忘记后面的.，此操作是把Test文件夹下面的文件都添加进来）

git commit  -m  "提交信息"  （注：“提交信息”里面换成你需要，如“first commit”）

git push -u origin master   （注：此操作目的是把本地仓库push到github上面，此步骤需要你输入帐号和密码）
		


git cherry-pick
###永久记住密码
git config --global credential.helper store