###1.python安装包的下载地址：https://www.python.org/downloads/

wget https://www.python.org/ftp/python/3.6.1/Python-3.6.1.tgz
###2.载完成后把安装包解压到自己指定目录下（本人安装在/usr/local/Python下）
	$tar -xzvf Python-3.4.2.tgz
###3.一步步走
	$cd Python-3.4.2
	添加配置
	./configure –prefix=/usr/bin/python3.6 
	make
	make install（权限问题用sudo）
###4.检查：python


##$5.
需要删除原有的Python链接文件: 
rm /usr/bin/python
建立指向Python3.6的链接： 
ln -s /usr/bin/python3.6/bin/python3.6 /usr/bin/python

##6.pip安装 升级 卸载
安装
sudo apt-get install python3-pip

升级
sudo pip3 install --upgrade pip

卸载
sudo apt-get remove python3-pip

###这样安装tornado可能不会有问题
python -m pip install tornado

##
wget https://pypi.python.org/packages/source/T/Twisted/Twisted-15.2.1.tar.bz2
tar -xjvf Twisted-15.2.1.tar.bz2
cd Twisted-15.2.1
python setup.py install