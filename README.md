**Нужные пакеты**  

apt-get install nano git python3 python3-pip mysql-server php libapache2-mod-php libapache2-mod-fastcgi php-fpm libapache2-mod-fastcgi php7.0-fpm php-mcrypt php-mysql phpmyadmin php-mbstring php-gettext composer php7.0-zip  
sudo mysql_secure_installation  
pip3 install --upgrade pip  
pip3 install pytz pymysql  


**Apache**  
sudo a2enmod actions fastcgi alias rewrite  
nano /etc/php/7.0/fpm/pool.d/www.conf  
listen = 127.0.0.1:9000  

 <FilesMatch "\.php$">  
            SetHandler "proxy:fcgi://127.0.0.1:9000/"  
        </FilesMatch>  
 a2enmod proxy_fcgi  
 systemctl restart php7.0-fpm apache2   

**sites-available:**  

<VirtualHost *:80>  
    ServerName 78.24.216.13  
    Redirect 403 /  
    ErrorDocument 403 "Please use www.sfriend.ru :)"  
    DocumentRoot /dev/null/  
    UseCanonicalName Off  
</VirtualHost>  
<VirtualHost *:80>  
    ServerName 78.24.216.13  
    Redirect 403 /  
    ErrorDocument 403 "No"  
    DocumentRoot /dev/null/  
    UseCanonicalName Off  
</VirtualHost>  
<VirtualHost *:80>  
 <FilesMatch "\.php$">  
            SetHandler "proxy:fcgi://127.0.0.1:9000/"  
        </FilesMatch>  
ServerName www.sfriend.ru  
    <Directory /var/www/portal/web>  
        Options Indexes FollowSymLinks MultiViews  
        AllowOverride All  
        Require all granted  
    </Directory>  
</VirtualHost>  

**SSL**  
sudo apt-get update  
sudo apt-get install software-properties-common  
sudo add-apt-repository ppa:certbot/certbot  
sudo apt-get update  
sudo apt-get install python-certbot-apache  
sudo certbot --apache  


**Cron**  

crontab -e  
*/1 * * * * python3 /var/www/www.sfriend.ru/integration/expl/oktava/integrate.py  
* 22 * * * certbot renew  
0 * * * * python3 /bot/portalsb_bot/bot_notify.py  

**Php**  
nano  /etc/php/7.0/apache2/php.ini  
date.timezone = "UTC"  

**Русский в консоли**  
sudo dpkg-reconfigure tzdata  
locale-gen ru_RU.UTF-8  
export LANG=ru_RU.UTF-8  
