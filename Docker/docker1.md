###准备镜像
ubuntu-14.04-amd64-vbox.box
###新建虚拟机
	1.新建一个test虚拟机(可以理解为test服务器):vagrant box add test ./ubuntu-14.04-amd64-vbox.box
	2.初始化:vagrant init test
    3.修改配置文件vagrantfile,添加如下内容:
	config.vm.network "forwarded_port", guest: 80, host: 80
	config.vm.network "forwarded_port", guest: 3306, host: 3306
	# 修改 Vagrantfile 下面这样的修改实测 ok:
	config.vm.synced_folder "d:/data", "/data"    #-- 在d盘见data作为工作目录
    4.启动虚拟机,vagrant up
###从现有容器中导出容器快照文件
	$ sudo docker ps -a 
	$ sudo docker export 7691a814370e(CONTAINER ID) > /data/ubuntu.tar(data是映射目录)
###进入test虚拟机,将容器快照文件导入为镜像
	导入镜像:cat /data/ubuntu.tar | sudo docker import - test_image
	查看镜像:sudo docker images

###基于镜像新建一个容器启动
	sudo docker run -t -i -d --name test_docker -v /data:/data -p 80:80 -p 90:90 test_image /run.sh
	sudo docker run -t -i -d --name test_docker -v /data:/data -p 80:80 -p 90:90 ubuntu:14:04 /run.sh
###容器的启动,停止,删除
	sudo docker start name 
	sudo docker stop name 
	sudo docker rm [-f] name
###使用docker-enter进入容器
	cd ~
	新建文件docker-enter(vim新建)
	放入以下代码
###docker-enter文件的代码
	#!/bin/sh

    if [ -e $(dirname "$0")/nsenter ]; then
        # with boot2docker, nsenter is not in the PATH but it is in the same folder
        NSENTER=$(dirname "$0")/nsenter
    else
        NSENTER=nsenter
    fi

    if [ -z "$1" ]; then
        echo "Usage: `basename "$0"` CONTAINER [COMMAND [ARG]...]"
        echo ""
        echo "Enters the Docker CONTAINER and executes the specified COMMAND."
        echo "If COMMAND is not specified, runs an interactive shell in CONTAINER."
    else
        PID=$(docker inspect --format "{{.State.Pid}}" "$1")
        if [ -z "$PID" ]; then
            exit 1
        fi
        shift

        OPTS="--target $PID --mount --uts --ipc --net --pid --"

        if [ -z "$1" ]; then
            # No command given.
            # Use su to clear all host environment variables except for TERM,
            # initialize the environment variables HOME, SHELL, USER, LOGNAME, PATH,
            # and start a login shell.
            "$NSENTER" $OPTS su - root
        else
            # Use env to clear all host environment variables.
            "$NSENTER" $OPTS env --ignore-environment -- "$@"
        fi
    fi