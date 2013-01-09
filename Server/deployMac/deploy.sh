#!/bin/sh

# Deploy into local machine, work for Mac OS X and Debian/Ubuntu OS

unamestr=`uname`
if [[ "$unamestr" == 'Linux' ]]; then
    echo 'Linux Deploy...'
    WWWROOT='/var/www/gtcclibrary'
    LIBPATH='/usr/share/php/gtcclibrary'
elif [[ "$unamestr" == 'Darwin' ]]; then
    echo 'Mac Deploy...'
    WWWROOT='/Users/lylexu/Sites/gtcclibrary'
    LIBPATH='/usr/lib/php/gtcclibrary'
fi

LOGPATH='/var/log/gtcclibrary'
DAEMONPATH='/usr/bin/gtcclibrary'
INIPATH='/etc/gtcclibrary'

rm -rf $WWWROOT
rm -rf $LOGPATH
rm -rf $DAEMONPATH
rm -rf $LIBPATH
rm -rf $INIPATH

mkdir -p  $WWWROOT
mkdir -p $LOGPATH
mkdir -p $DAEMONPATH
mkdir -p $LIBPATH
mkdir -p $INIPATH

mkdir -p $WWWROOT/json/
mkdir -p $WWWROOT/json/Sample/
mkdir -p $WWWROOT/json/Schema/
mkdir -p $WWWROOT/json2html/
mkdir -p $WWWROOT/cache/
mkdir -p $DAEMONPATH/cache/

chmod 777 $WWWROOT/json/
chmod 777 $WWWROOT/cache/
chmod 777 $DAEMONPATH/cache/
chmod 777 $LOGPATH/

#ping www
echo "I'm fine" > $WWWROOT/index.html

# amfphp
cp -R ../source/amfphp2/ $WWWROOT/amfphp/
cp -R ../source/stream/ $WWWROOT/stream/

# json
cp -R ../source/lib/Json/Sample/*.* $WWWROOT/json/Sample/
cp -R ../source/lib/Json/Schema/*.* $WWWROOT/json/Schema/

# json2html
cp -PR ../source/json2html/* $WWWROOT/json2html/

# admin
cp -R ../source/admin/ $WWWROOT/admin/

# tapjoy
cp -R ../source/Tapjoy/ $WWWROOT/tapjoy/

# Images
cp -R ../source/Images/ $WWWROOT/Images/

# Lib
cp ../source/*.php $LIBPATH/
cp -PR ../source/lib/* $LIBPATH/
cp -R ../source/Models/ $LIBPATH/Models/

# ini
cp ../source/*.ini $INIPATH/
