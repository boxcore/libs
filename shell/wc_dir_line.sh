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

CUR_DIR=`pwd`
# 通过ls获取目录时候可能有换行符,需要作过滤
DIRS=`ls -dm */ | sed 'N;s/\n/ /g' `
FILE_NAME='cnt.txt'
rm -rf $FILE_NAME
touch $FILE_NAME
IFS='/, ' read -ra ADDR <<< "$DIRS"

OIFS=$IFS
IFS=', '
arr2=$DIRS
for x in $arr2; do
if [ $x ]; then
    echo -n  [`date "+%Y-%m-%d %H:%M:%S"`] "$CUR_DIR/$x Line Count : " >> $FILE_NAME
    find $CUR_DIR/$x -name "*.log" |xargs cat|wc -l >> $FILE_NAME
fi
done

# find $CUR_DIR/$i -name "*.log" |xargs cat|grep -v ^$|wc -l >> $FILE_NAME
# wc -l `find $CUR_DIR/$i -name "*.log"`|tail -n1 >> $FILE_NAME