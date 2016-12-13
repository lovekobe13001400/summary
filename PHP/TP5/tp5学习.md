###1.安装composer  
###2.
应用项目：https://github.com/top-think/think  
核心框架：https://github.com/top-think/framework
###3.切换到web目录（tp的项目目录）
composer create-project topthink/think tp5  --prefer-dist
###4.tp5的目录结构
	tp5
	├─application     应用目录
	├─extend          扩展类库目录（可定义）
	├─public          网站对外访问目录
	├─runtime         运行时目录（可定义）
	├─vendor          第三方类库目录（Composer）
	├─thinkphp        框架核心目录
	├─build.php       自动生成定义文件（参考）
	├─composer.json   Composer定义文件
	├─LICENSE.txt     授权说明文件
	├─README.md       README 文件
	├─think           命令行工具入口
###5.thinkphp系统目录
	├─thinkphp 框架系统目录
	│  ├─lang               语言包目录
	│  ├─library            框架核心类库目录
	│  │  ├─think           think 类库包目录
	│  │  └─traits          系统 traits 目录
	│  ├─tpl                系统模板目录
	│  │
	│  ├─.htaccess          用于 apache 的重写
	│  ├─.travis.yml        CI 定义文件
	│  ├─base.php           框架基础文件
	│  ├─composer.json      composer 定义文件
	│  ├─console.php        控制台入口文件
	│  ├─convention.php     惯例配置文件
	│  ├─helper.php         助手函数文件（可选）
	│  ├─LICENSE.txt        授权说明文件
	│  ├─phpunit.xml        单元测试配置文件
	│  ├─README.md          README 文件
	│  └─start.php          框架引导文件
###6.访问
http://localhost/tp5/public/index.php（这种访问方式不好）
###7.实际目录结构
	├─application           应用目录（可设置）
	│  ├─index              模块目录(可更改)
	│  │  ├─config.php      模块配置文件
	│  │  ├─common.php      模块公共文件
	│  │  ├─controller      控制器目录
	│  │  ├─model           模型目录
	│  │  └─view            视图目录
	│  │
	│  ├─command.php        命令行工具配置文件
	│  ├─common.php         应用公共文件
	│  ├─config.php         应用配置文件
	│  ├─tags.php           应用行为扩展定义文件
	│  ├─database.php       数据库配置文件
	│  └─route.php          路由配置文件
###8.添加1个模块
切换到命令行模式下，进入到应用根目录并执行如下指令：
php think build --module demo
###9.修改完的框架目录
tp5
├─index.php       应用入口文件
├─apps            应用目录
├─public          资源文件目录
├─runtime         运行时目录
└─thinkphp        框架目录
###10.资源访问
	public
	├─index.php       应用入口文件
	├─static                静态资源目录   
	│  ├─css      样式目录
	│  ├─js         脚本目录
	│  └─img      图像目录
###11.开启调试模式
	application/config.php
	'app_debug' =>  false,//false：关闭 true：开启
###12.控制器
我们找到index模块的Index控制器（文件位于application/index/controller/Index.php 注意大小写），我们把Index控制器类的index方法修改为Hello,World！。  

	<?php
	namespace app\index\controller;
	class Index
	{
	    public function index()
	    {
	        return 'Hello,World！';
	    }
	}
###13.疑问
1.为什么默认访问index/index
2.正确访问路径是什么
http://localhost/tp5/index.php/index/index/index
index模块下的index控制器的index方法
###13.视图
application/index创建view
然后添加模板文件：view/index/index.html
index控制器下的index.html,因为index下控制器下会有很多view
控制器代码：
  
	namespace app\index\controller;
	use think\Controller;
	class Index extends Controller
	{
	    public function index()
	    {
			$name = "kobe";
			$this->assign('name', $name);
			return $this->fetch();
	    }
	}

###14.读取数据
1.application/database.php配置数据库信息
2.