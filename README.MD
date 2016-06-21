##一个即使聊天工具, 效率工具

* 使用websocket协议 实现了浏览器与服务器全双工通信.
* 使用php 做消息的服务端. 使用Yii2框架  运用 WorkerMan来实现服务端的websocket.
* 前端使用AngularJs, 并且使用了一个语法糖工具CoffeeScript来写js代码

##启动流程
0. 环境准备, 需要php, mysql nginx/apache(推荐使用nginx, php是用FPM方式.) bower npm composer
1. clone 代码.
###服务端配置
2. cd server && composer install
3. 新建数据库 warcrm 用户名密码都是warcrm 然后执行 ./yii migrate 生成数据库.
4. 启动方法
```
php worker.php start -d #启动消息服务器
php worker.php status   #查看消息服务器状态
php worker.php stop     #停止消息服务器
php worker.php reload   #重启消息服务器
```
###客户端配置
4. cd client && bower install && npm install
5. 启动客户端 
```
gulp serve 启动客户端
gulp build 打包客户端
```


##Todo

1. 一对一聊天 clear
1. 群组聊天 clear
1. 聊天附件 clear
1. 团队成员管理 clear
1. 密码登陆 clear
1. 聊天发送代码片段 clear
1. 消息合并
1. 上传头像 clear
1. 增加头衔 clear
1. 群组合成头像 clear
1. 表情
1. @人
1. 个人资料页面
1. 在线状态的变更
1. 上拉加载聊天记录 clear
1. Ctrl 回车换行 clear
1. 鼠标悬停头像显示profile
1. 找回密码
1. 邀请用户 clear
1. 个人的todo列表
1. 项目的增删改查, 往项目里添加成员
1. 任务的分配
1. 分享文章
1. 敏捷面板
1. 通知系统
1. 搜索
1. 断线心跳重连机制 clear
