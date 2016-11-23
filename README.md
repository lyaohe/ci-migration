##PHP Migrations——Doctrine Migrations教程

博文链接 : http://my.oschina.net/u/930926/blog/741477

> 版权声明：本文为博主原创文章，未经博主允许不得转载。

Doctrine Migrations github地址：[https://github.com/doctrine/migrations](https://github.com/doctrine/migrations)

官方文档Getting Started（快速开始）写得非常不好，根据本人的使用，总结一下快速开始的案例。

下面用Thinkphp5来举例集成Doctrine Migrations

### 1. 使用 Composer 安装 doctrine/migrations和symfony/console

如果对Composer还不了解，请参考 [Composer中文网](http://docs.phpcomposer.com/)

	composer require doctrine/migrations
	composer require symfony/console:~2.5

symfony/console最新的3.x版本已经弃用了Symfony\Component\Console\Helper\HelperSet，所以要指定安装symfony/console:~2.5版本

### 2. 构建Migration目录

构建目录和代码托管到github：[https://github.com/lyaohe/tp-migrations](https://github.com/lyaohe/tp-migrations)

由于 Composer 创建 `/vendor/bin/doctrine-migrations` 不好用,所以，需要另行创建目录并编写migrations.php文件

- 在项目根目录创建migration目录

- 在migration目录添加migrations.php、migrations-input.php、config/migrations.yml、mig.sh、gen.sh文件，并创建Migrations目录（不是本人设计的，只是参考资料整理出来的）

- migrations.php 可以修改连接数据库的方式 
![](http://7rfk63.com1.z0.glb.clouddn.com/20160902113006.png)


- migrations-input.php 读取 `config/migrations.yml` 配置文件

### 3. 测试Migrations命令

- 列举所有命令

		php migrations.php
![](http://7rfk63.com1.z0.glb.clouddn.com/20160901211356.png)

- 创建Migrations脚本文件
		
		 php migrations.php migrations:generate
![](http://7rfk63.com1.z0.glb.clouddn.com/20160901211430.png)

在新创建的php文件，添加数据库sql语句
![](http://7rfk63.com1.z0.glb.clouddn.com/20160901213423.png)
文件中自动创建了 `up` 和 `down` 两个方法

 `up` 方法是执行Migrations脚本自动执行的函数

 `down` 方法是执行Migrations脚本up函数出错后，回滚执行的函数

在两个方法加入sql，具体可以参考文档，也可以用ORM来编写
![](http://7rfk63.com1.z0.glb.clouddn.com/20160901213842.png)



- 执行Migrations脚本文件
		
		php migrations.php migrations:migrate

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

[https://github.com/lyaohe/tp-migrations](https://github.com/lyaohe/tp-migrations)

参考资料

- Doctrine Migrations文档: http://docs.doctrine-project.org/projects/doctrine-migrations/en/latest/

- Doctrine DBAL and Migrations Example: https://gist.github.com/lyaohe/7a6eedd95ebafd6588799e01e87b978b








