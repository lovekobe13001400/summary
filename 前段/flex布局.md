参考博客：http://www.ruanyifeng.com/blog/2015/07/flex-grammar.html
###1.flex布局是什么
Flex 是 Flexible Box 的缩写，意为"弹性布局"，用来为盒状模型提供最大的灵活性。
任何一个容器都可以指定为 Flex 布局。
####2.基本概念
采用 Flex 布局的元素，称为 Flex 容器（flex container），简称"容器"。它的所有子元素自动成为容器成员，称为 Flex 项目（flex item），简称"项目"。


![](http://www.ruanyifeng.com/blogimg/asset/2015/bg2015071004.png)
容器默认存在两根轴：水平的主轴（main axis）和垂直的交叉轴（cross axis）。主轴的开始位置（与边框的交叉点）叫做main start，结束位置叫做main end；交叉轴的开始位置叫做cross start，结束位置叫做cross end。
项目默认沿主轴排列。单个项目占据的主轴空间叫做main size，占据的交叉轴空间叫做cross size。
###3.容器的属性 
flex-direction
flex-wrap
flex-flow
justify-content
align-items
align-content
#### flex-direction属性
.box {
  flex-direction: row | row-reverse | column | column-reverse;
}
![](http://www.ruanyifeng.com/blogimg/asset/2015/bg2015071005.png)
row（默认值）：主轴为水平方向，起点在左端。
row-reverse：主轴为水平方向，起点在右端。
column：主轴为垂直方向，起点在上沿。
column-reverse：主轴为垂直方向，起点在下沿。

### 4.容器属性见flex.html

###5.属性align-content不了解，待定研究

###6.项目属性
order
flex-grow
flex-shrink
flex-basis
flex
align-self

问题：
felx-basis
felx
align-self:待定，待研究
