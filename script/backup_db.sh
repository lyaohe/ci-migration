# 备份数据库参考脚本
day_file=/data/back/`date  +"%F"`.sql
month_file=/data/back/`date  +"%m"`.sql
mysqldump -h127.0.0.1 -uroot  ci > $day_file
mv $day_file $month_file -f

