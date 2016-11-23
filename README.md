##PHP Migrations——Doctrine Migrations教程

博文链接 : http://my.oschina.net/u/930926/blog/741477

> 版权声明：本文为博主原创文章，未经博主允许不得转载。

Doctrine Migrations github地址：[https://github.com/doctrine/migrations](https://github.com/doctrine/migrations)

> 不知道Migrations有什么用，可参考这篇文章：[为什么要用PHP Migrations](https://my.oschina.net/lyaohe/blog/741475)

官方文档Getting Started（快速开始）写得非常不好，用CodeIgniter集成Migrations代码，做了快速演示Demo，可以先把代码跑起来,再看搭建笔记。

> 本教程需要使用Composer，既然是趋势就早日拥抱，能写PHP的这点工具用不来说不过去  
> 如果对Composer还不了解，请参考 [Composer中文网](http://docs.phpcomposer.com/)

## 快速演示Demo

1. 克隆代码到本地，本地Mysql新建ci数据库，可参考`application/config/database_config.php`配置文件
2. 用composer把migration相应包更新下来，`composer update`
3. 切换到script/migration目录，测试migration，`php migrations.php`，命令说明参考搭建笔记的测试命令



## 搭建笔记

用CodeIgniter 3.x来举例集成Doctrine Migrations

### 1. 使用 Composer 安装 doctrine/migrations和symfony/console

如果对Composer还不了解，请参考 [Composer中文网](http://docs.phpcomposer.com/)

	composer require doctrine/migrations
	composer require symfony/console:~2.5

symfony/console最新的3.x版本已经弃用了Symfony\Component\Console\Helper\HelperSet，所以要指定安装symfony/console:~2.5版本

### 2. 构建script/migration目录

- application/config/目录创建公用的数据配置文件database_config.php，database.php使用该配置，migrations也使用该配置
- 复制script/migration目录来用，migrations.php部分代码是连接数据库，具体不详细说了，自行看源码，可参考官方文档

### 3. 测试Migrations命令

- 列举所有命令

		php migrations.php
![](http://7rfk63.com1.z0.glb.clouddn.com/20161123131332.png)

- 创建Migrations脚本文件
		
		 sh gen.sh 或 php migrations.php migrations:generate
![](http://7rfk63.com1.z0.glb.clouddn.com/20161123131455.png)

在新创建的php文件，添加数据库sql语句
![](http://7rfk63.com1.z0.glb.clouddn.com/20160901213423.png)
文件中自动创建了 `up` 和 `down` 两个方法

 `up` 方法是执行Migrations脚本自动执行的函数

 `down` 方法是执行Migrations脚本up函数出错后，回滚执行的函数

在两个方法加入sql，具体可以参考官方的文档，也可以用ORM来编写
![](http://7rfk63.com1.z0.glb.clouddn.com/20160901213842.png)



- 执行Migrations脚本文件
		
		sh mig.sh 或 php migrations.php migrations:migrate

因为 `config/migrantions.yml` 定义 `migration_versions` 表记录执行过Migrations文件，所以`migrations:migrate`命令会检查migration_versions表，判断哪些Migrations文件没执行，再执行。


### 4. 简化命令

常用2个命令：`php migrations.php migrations:generate` 和 `php migrations.php migrations:migrate` ，可是有没有觉得这两个命令好长，写两个sh文件来简化命令，所以在migration目录有mig.sh和gen.sh文件，使用`sh gen.sh`和 `sh mig.sh` ，就简单很多了。

- mig.sh

		#!/bin/sh
		cd  $(cd `dirname $0`;pwd) # 切换到当前目录
		php migrations.php migrations:migrate

- gen.sh

		#!/bin/sh
		cd  $(cd `dirname $0`;pwd) # 切换到当前目录
		php migrations.php migrations:generate

sh脚本文件最好用vi编写或者保存unix编码，不然会报以下错误：

	[Symfony\Component\Console\Exception\CommandNotFoundException]  
	" is not defined.                   
	  Did you mean one of these?                                      
	      migrations:migrate                                          
	      migrations:status                                           
	      migrations:execute                                          
	      migrations:generate                                         
	      migrations:version                                          
	      migrations:diff   
   

可以用`dos2unix mig.sh`命令转换文件编码

没有`dos2unix`命令，可以 `sudo apt-get install dos2unix` 安装


最后，感觉这样的搭建方式还是有点繁琐，有兴趣的同学可以尝试用PHAR文件，再用sh脚本封装一下或许简单很多。

若有哪里不清楚，可以参考github上的代码，也可以留言。

[https://github.com/lyaohe/ci-migration](https://github.com/lyaohe/ci-migration)

参考资料

- Doctrine Migrations文档: http://docs.doctrine-project.org/projects/doctrine-migrations/en/latest/

- Doctrine DBAL and Migrations Example: https://gist.github.com/lyaohe/7a6eedd95ebafd6588799e01e87b978b








