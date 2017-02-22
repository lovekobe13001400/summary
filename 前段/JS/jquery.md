###1.基本选择器
	#id ：根据元素的id属性获取指定的元素
	element ：根据元素的名称获取指定的元素
	selector1,selector2 ：匹配所有满足条件的元素
	.class ：根据元素的class属性获取指定的元素
  	$('#tip').html();
	$('.content').html();
	$('h1').html();
	$('h1,div,p').html()
###2.层级选择器
	ancestor (空格) descendant ：选取祖先元素下的所有后代元素
	parent > child ：选择父元素下的所有子元素
	prev + next ：选取上一个元素紧邻的下一个元素
	prev ~ siblings ：选取上一个元素所有的同级兄弟元素
 	①获取div下的所有后代元素p
	$('div p').html()
	②获取div元素下的所有子元素
	$('div > p').html()
	③获取div的紧邻的div元素
	$('#div1 + div').html()
	④获取div1的所有同级元素
	$('#div1 ~ div').html
###3.简单选择器
	:first ：匹配第一个元素
	:last ：匹配最后一个元素
	:even ：匹配所有偶数 
	:odd ： 匹配所有奇数
	:eq(index) ：匹配索引为index的元素（默认索引从0开始）
	:gt(index) ：匹配索引大于index的元素
	:lt(index) ：匹配索引小于index的元素
	:not(selector) ：匹配除指定选择器以外的其他元素
	1.获取第一个元素
	$('td:first').html()
	2.获取最后个元素
	$('td:last').html()
	3.隔行变色
	$('td:even').attr('bgcolor','red')
	$('td:odd').attr('bgcolor','red')
	4.匹配索引为4的元素
	$('td:eq（4）').html()
	5.匹配索引大于4
	$('td:gt（4）').html(
	6.匹配索引4除外
	$('td:not(td:eq(4))').html()
###4.内容选择器
	:contains(text) ：匹配内容包含指定文本的元素
	:empty ：匹配内容为空的元素
	:has(selector) ：匹配具有指定选择器的元素
	:parent ：匹配具有子元素的元素（内容不为空的元素）
	1.匹配内容中包含“你好”的元素
	$('li:contains("你好")').html
	2.内容为空的元素
	$('li:empty()').html()
	3.匹配具有指定选择器的元素
	$('li:has("span")').html()
	4.匹配内容不为空的元素(作为父母的元素)
	$('li:parent()')
###5.可见性选择器
	:hidden ：匹配所有隐藏元素(display:none，input type=’hidden’)
	:visible ：匹配所有可见元素(display:block)
	$("div:hidden").show()
###6）属性选择器
	[attribute] ：匹配具有指定属性的元素
	[attribute=value] ：匹配属性值等于value的元素
	[attribute!=value] ：匹配属性值不等于value的元素
	[attribute^=value] ：匹配属性值以value开始的元素
	[attribute$=value] ：匹配属性值以value结尾的元素
	[attribute*=value] ：匹配属性值包含value的元素
	[selector1][selector2][selectorN] ：匹配包含多个属性的元素
	1.匹配具有size的font元素
	$('font[size]')
	2.属性值等于#ff0000
	$('font[color="#ff0000"]')
	3.属性值已#ff开头
	$('font[color^="#ff"]')
	4.匹配属性值包含00的font元素
	$('font[color*="00"]').html()
	5.匹配同时具有多个属性的元素
	$('font[color][size]').html();
###7）子元素选择器
	:nth-child(index/even/odd) 从1算起 ：匹配索引为index的指定元素
	:first-child ：匹配第一个子元素
	:last-child ：匹配最后一个子元素
	:only-child ：如果当前元素是唯一子元素，则匹配
$('div:first-child').html()
###8.表单选择器
	:input ：匹配所有表单元素
	:text ：匹配所有文本框
	:password ：匹配所有密码框
	:radio ：匹配所有单选按钮
	:checkbox ：匹配所有复选框
	:submit ：匹配提交按钮
	:reset ：匹配重置按钮
	:image ：匹配图像域
	:button ：匹配按钮
	:file ：匹配文件域
	:hidden ：匹配隐藏表单
###9.9）表单属性选择器
	:enabled ：匹配所有可用元素
	:disabled ：匹配所有不可用元素
	:checked ：匹配复选框所有选中元素
	:selected ：匹配下拉选框所有选中元素
	$('option:checked').val
------
dom对象：document.getElementById(id)获取到的对象就是DOM对象
在jQuery中，通过$符号获取的对象我们都称之为jQuery对象
DOM对象 = jQuery对象[index];
DOM对象 = jQuery对象.get(index);
DOM对象转jQuery对象基本语法：
jQuery = $(DOM对象);
-------
###jquery中的属性
###1.attr属性
attr(name) ：获取指定元素的属性
attr(key,value) ：设置元素的属性
attr(properties) ：为元素同时设置多个属性，要求参数是一个json数据
attr(key,fn) ：通过函数的返回值设置元素属性
removeAttr(name) ：移除元素属性
$('img').attr('src','/src/img')
###2、class属性
addClass(class) ：为元素添加css属性
removeClass(class) ：移除元素的css属性
toggleClass(class) ：切换样式，如果元素不存在该属性则添加，否则移除
hasClass(class) ：判断元素是否具有某个css样式
###3.css方法
css(name) ：获取元素的属性
css(name,value) ：设置元素的属性
css(properties) ：同时为元素设置多个属性，要求参数是一个json数据
$('#result').css({
	border:"1px #f00 solid"
});
###4.offset位置
offset() ：获取元素的位置，返回json格式数据，带有left与top属性
offset(coordinates) ：设置元素的位置，要求参数是一个json数据且必须要拥有left与top属性
$('#result').offset({
	left:400,
	top:300
});
###5.元素的尺寸
	width() ：获取元素的宽度
	width(value) ：设置元素的宽度
	height() ：获取元素的高度
	height(value) ：设置元素的高度
###6、文本与值
	相当于以前的innerHTML属性：
	html() ：获取元素的值
	html(val) ：设置元素的值
	
	相当于以前的value属性：
	val() ：获取表单元素的值
	val(val) ：设置表单元素的值
	
	相当于以前的innerText属性
	text() ：获取元素的值
	text(val) ：设置元素的值

------
###jquey中的事件
在原生Javascript代码中，我们通过window.onload实现页面的载入功能，其主要执行流程如下：载入HTML代码到内存形成DOM树载入全部资源（文本、图片、样式）执行Javascript脚本。
window.onload = function(){
	alert('hello jQuery!!!');
}
通过jQuery中的ready方法实现页面的载入功能，基本语法：
1）语法1：
$(document).ready(function(){
	//事件的处理程序
});
2）语法2：
$().ready(function(){
	//事件的处理程序
});
3.$(function()){
}

2、window.onload事件与ready()区别
ready方法执行流程如下：载入HTML代码到内存形成DOM树结构执行jQuery脚本载入全部资源（文本、图片、样式）

所以ready方法的执行速度要快于window.onload方法

证明：ready方法执行效率要优于window.onload

###常用事件
3、常用的事件
jQuery中的所有事件都封装成了方法，所以在编写时语法如下：
jQuery对象.事件(事件的程序);

blur(fn) ：失去焦点时触发
change(fn) ：状态改变时触发
click(fn) ：点击时触发
dblclick(fn) ：双击时触发
focus(fn) ：获得焦点时触发
keydown(fn) ：键盘按下时触发
keyup(fn) ：键盘弹起时触发
keypress(fn) ：键盘按下时触发
load(fn) ：页面载入时触发，功能与ready类似
unload(fn) ：页面关闭时触发
mousedown(fn) ：鼠标按下时触发
mouseup(fn) ：鼠标弹起时触发
mousemove(fn) ：鼠标移动时触发
mouseover(fn) ：鼠标悬浮时触发
mouseout(fn) ：鼠标离开时触发
resize(fn) ：调整大小时触发
scroll(fn) ：滚动时触发
select(fn) ：文本选中时触发
submit(fn) ：表单提交时触发
###事件监听
回顾事件绑定的三种形式：
1）行内绑定
<标签 属性列表  事件=”事件的处理程序()” />
2）动态绑定
DOM对象.事件 = 事件的处理程序
3）事件监听
IE浏览器：attachEvent(type,callback);
W3C浏览器：addEventListener(type,callback,capture);
###4、事件切换
hover(over,out) ：鼠标悬浮与鼠标离开事件
参数说明：
over：鼠标悬浮事件
out：鼠标离开事件

###事件编程
1、bind(type,[data],fn) ：为元素绑定相关的事件处理程序
2、bind({type:fn,type:fn}) ：为元素绑定多个事件，要求参数
3、one(type,[data],fn) ：为元素绑定事件，但事件只触发一次
4、unbind([type]) ：移除事件
###事件冒泡（冒泡事件就是点击子节点，会向上触发父节点，祖先节点的点击事件。）
对象.事件 = function(event) {
	event.stopPropagation();
}
###事件默认行为
对象.事件 = function(event) {
	event.preventDefault();
}
###在jQuery，事件绑定中的this指针指向了当前要操作的DOM对象
###jquery动画
show() ：显示
show(speed,[callback]) ：以动画效果显示
参数说明：
speed：速度（动画的持续时间）
[callback]：可选参数,事件完成时所触发的回调函数
hide() ：隐藏
hide(speed,[callback]) ：以动画效果隐藏
参数说明：
speed：速度（动画的持续时间）
[callback]：可选参数，事件完成时所触发的回调函数
toggle() ：切换显示或隐藏
toggle(switch) ：显示或隐藏  true：显示  false：隐藏
toggle(speed,[callback]) ：以动画效果切换显示或隐藏
speed:"slow", "normal", "fast" ：slow：慢  normal：正常  fast：快速
2、滑动效果
slideDown(speed,[callback]) ：以动画效果向下滑动
slideUp(speed,[callback]) ：以动画效果向上滑动
slideToggle(speed,[callback]) ：以动画效果滑动
fadeIn(speed,[callback]) ：以动画形式淡入
fadeOut(speed,[callback]) ：以动画形式淡出
参数说明：
speed ：动画的持续时间
[callback] ：动画完成时所触发的回调函数
fadeTo(speed,opacity,[callback]) ：设置元素的透明度
参数说明；
speed ：动画的持续时间
opacity ：透明度（0-1） 0 全透明  1不透明
[callback] ：动画完成时所触发的回调函数
4、自定义动画
animate(params,[speed]) ：自定义动画效果
params ：自定义动画，要求参数是一个json格式的数据
[speed] ：动画的持续时间
###查找
7、查找操作
eq(index) ：通过元素的索引查找元素，index默认从0开始
filter(expr) ：查找与给定元素匹配的元素，expr匹配条件
not(expr) ：查找与给定元素不匹配的元素
children([expr]) ：查找所有子元素
find(expr) ：查找所有后代元素
next([expr]) ：查找紧邻的下一个元素
prev([expr]) ：查找紧邻的上一个元素
parent([expr]) ：查找当前元素的父元素
siblings([expr]) ：查找所有同级兄弟节点（无论上下）
###each方法
$('img').each(function(i,item)){
	item.attr('src','image/');
}
###
4、解决Ajax中缓存问题
运行以上代码发现，当我们在IE浏览器下使用get时，系统会存在缓存问题，那么在实际项目开发中，如何解决以上问题呢？
回顾Ajax中的原生代码，如何解决缓存问题：
1）随机数2）时间戳3）If-Modified-Since4）在服务器端禁止缓存
###面试题：为什么Ajax不允许跨域请求
答：受到浏览器中的同源策略影响，基于安全考虑，不允许跨域。
###同源策略
所谓同源策略，指的是浏览器对不同源的脚本或者文本的访问方式进行的限制。比如源a的js不能读取或设置引入的源b的元素属性。

那么先定义下什么是同源，所谓同源，就是指两个页面具有相同的协议，主机（也常说域名），端口，三个要素缺一不可。
###什么是jsonp
JSONP是一个非官方的协议，它允许在服务器端集成script tags返回至客户端，通过javascript callback的形式实现跨域访问。
