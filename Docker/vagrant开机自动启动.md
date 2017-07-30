##  vagrant开机自启动

1. 进入tk2容器，/run.sh添加启动redis

		#进入tk2容器
		sudo docker-enter tk2
		#编辑/run.sh
		vi /run.sh
		#倒数第二行加入启动redis命令
		/etc/init.d/redis-server restart


2. vagrant开机完，自启动docker容器

		#编辑Vagrantfile文件，在共享目录配置后，添加启动tk2容器的shell
		config.vm.provision "shell", inline: "sudo docker start tk2", run: "always"

3. Windows开机，启动脚本

		#新建一个txt文件重命名为***.bat,输入以下命令
		cd /D D:\box
		vagrant up
		Pause