1.显示行号(显示空格)
settings -> Editor->Appearance->Show line numbers
2. 去掉右上角浏览器图标:
settings -> tools -> WebBrowsers
3.将编辑的文件加星号标识:
settings -> editor->general -> editor tabs -> 勾选 mark modifed tabs…
4.多个项目窗口:
File -> settings -> Directories -> Add Content Root 选择要添加的项目目录即可。
5.调整字体大小
file>setting>Editor>Color&Font>Font 这里面设置字体大小（原生的主题不能修改的，你需要把它另存为之后才能修改）
---快捷键
1.ctrl+tab              --  切换到之前编辑的页面:
2.alt+alt               --  连续两次快速按下alt键不放，显示tool windows,移动,左边文件,右边函数
3.alt+F3                --  显示搜索窗格，对当前文件进行搜索，然后配合ctrl+alt+r,可以进行替换操作
4.ctrl+alt+r    --  替换
5.ctrl+shift+f  --  find in path 在指定文件夹或者整个project内搜索，ctrl+shift+r进行替换操作
6.ctrl+shift+alt+t: 快速rename，里面有好几个选项，慢慢理解吧
7.ctrl+y      --  删除一行
shift+F6:         rename，自动重命名该变量所有被调用的地方
ctrl+shift+n    --      快速导航到指定文件，弹出一个dialog，输入文件名即可
ctrl+shift+i:     快速查找选中内容定义的位置 quick definition viewer
ctrl+n                  --      快速打开任意类，弹出一个对话框，输入类名称，跳转到类文件
ctrl+shift+alt+n: 快速打开指定的method，field.弹出一个对话框，输入标识符，选择后跳转到指定内容
alt+F7:           查找选定变量，方法被调用的地方。选中一个方法或者变量，查找出所有调用的地方
ctrl+F12:         弹出一个对话框，显示当前文件里的所有方法，变量，直接输入方法变量名，回车即可跳转到定义位置
alt+F1:           快速打开当前编辑文件在其他tool windows里，这个很好用的键盘
ese:              退出tool windows，焦点返回到编辑器里
shift+esc:        退出并隐藏tool windows,焦点返回编辑器里
F12:              光标从编辑器里移动到最后一个关闭的tool windows里
ctrl+d:       快速复制多行，哈哈，这个vim里更加简单
ctrl+shift+p:     显示函数方法的参数列表
ctrl+shift+backspace: last edit location
ctrl+shift+F7:    在当前文件高亮选定的标识符，esc退出高亮，f3,shift f3向下向上导航高亮标识符
ctrl+shift+alt+e: exploer最近打开的文件
alt+方向键：      左右在打开的编辑器标签间切换，上下在打开的文件中的方法里上下切换
alt+shift+c:      浏览最近的修改历史
ctrl+`:           选择主题，不常用