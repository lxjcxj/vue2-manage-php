# vue2-manage-php

## open_basedir restriction in effect

```
lnmp的vhost会在serverroot下建一个.user.ini 里面会有open_basedir
cd到目录下 运行chattr -i .user.ini
然后把它删了就行了
open_basedir=/www/wwwroot/x3.hijs.cc/mysite/www/:/tmp/:/proc/
```
