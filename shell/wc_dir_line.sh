#/bin/sh
#
########################################
# 获取目录下所有日志的行数(过滤掉空格)
# author:chunze.huang
# date:  2015-05-05
# todo:  通过ls获取目录时候有换行符
#        需求过滤换行符
########################################
#

cur_dir=`pwd`
dirs=`ls -dm */`
file_name='cnt.txt'
rm -rf $file_name
touch $file_name
IFS='/, ' read -ra ADDR <<< "$dirs"

OIFS=$IFS
IFS=', '
arr2=$dirs
for x in $arr2; do
if [ $x ]; then
    echo "$cur_dir/$x" `date "+%Y-%m-%d %H:%M:%S"` >> $file_name
    find $cur_dir/$x -name "*.log" |xargs cat|wc -l >> $file_name
fi
done

# find $cur_dir/$i -name "*.log" |xargs cat|grep -v ^$|wc -l >> $file_name
# wc -l `find $cur_dir/$i -name "*.log"`|tail -n1 >> $file_name