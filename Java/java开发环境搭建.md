###1.jdk环境
	1.下载jdk：http://www.oracle.com/technetwork/java/javase/downloads/index.html，
	2.配置环境变量
	变量名：JAVA_HOME
	变量值：C:\Program Files\Java\jdk1.7.0_13  // 要根据自己的实际路径配置
	变量名：CLASSPATH
	变量值：.;%JAVA_HOME%\lib\dt.jar;%JAVA_HOME%\lib\tools.jar;         //记得前面有个"."
	变量名：Path
	变量值：%JAVA_HOME%\bin;%JAVA_HOME%\jre\bin;
	3.验证
	java -version