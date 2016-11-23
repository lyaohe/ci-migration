#!/bin/sh
cd  $(cd `dirname $0`;pwd) # 切换到当前目录
php migrations.php migrations:generate
