phpnotes
========

php笔记


apache+php配置

1  安装apache 如果安装了wamp 回混乱
2  下载php 将所需要的扩展打开 包括entension_dir='E:\php\ext'(主要最好用单引号) 如需要改时区timezone
3  将php目录配置到环境变量包括 E:\php和E:\php\ext
3  修改apache配置文件 在最下面加入如下内容
 PHPIniDir "E:/mywamp/php"
   LoadModule php5_module "E:/mywamp/php/php5apache2_2.dll"
   AddType application/x-httpd-php .html .phtml .php
   AddType Application/x-httpd-php-source .phps
   <IfModule charset_lite_module>
  AddDefaultCharset UTF-8   
   </IfModule>
LoadFile "E:/mywamp/php/ssleay32.dll"
LoadFile "E:/mywamp/php/libeay32.dll" 
(LoadFile是为了启动时能找到php的curl扩展)
并且把这句LoadModule charset_lite_module modules/mod_charset_lite.so的#去掉
4  配置虚拟站点
在C:\WINDOWS\system32\drivers\etc中修改hosts文件加上如下内容
127.0.0.1       localhost
127.0.0.1       locall.topsem.tt
127.0.0.1       ljiance.topsem.tt
127.0.0.1       wrqewrewrq.com
192.168.5.50 sem.topsem.tt db.topsem.tt
修改apache配置文件打开Include conf/extra/httpd-vhosts.conf
然后再这个文件加入如下
<Directory "E:/wamp/www">
    Options Indexes FollowSymLinks
    AllowOverride All
    Order allow,deny
    Allow from all
</Directory>

<VirtualHost *:80>
    ServerAdmin webmaster@dummy-host3.localhost
    DocumentRoot "E:\mywamp\apache\htdocs\traffic"
    ServerName locall.topsem.tt
</VirtualHost>

<VirtualHost *:80>
    ServerAdmin webmaster@dummy-host3.localhost
    DocumentRoot "E:\mywamp\apache\htdocs\www2"
    ServerName localhost
</VirtualHost>

<VirtualHost *:80>
    ServerAdmin webmaster@dummy-host3.localhost
    DocumentRoot "E:\mywamp\apache\htdocs\jiance"
    ServerName ljiance.topsem.tt
</VirtualHost>

<VirtualHost *:80>
    ServerAdmin webmaster@dummy-host3.localhost
    DocumentRoot "E:\mywamp\apache\htdocs\wrq"
    ServerName wrqewrewrq.com
</VirtualHost>
