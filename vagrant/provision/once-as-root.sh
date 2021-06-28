#!/usr/bin/env bash

source /app/vagrant/provision/common.sh

#== Import script args ==

timezone=$(echo "$1")

#== Provision script ==

info "Provision-script user: `whoami`"

export DEBIAN_FRONTEND=noninteractive

info "Configure timezone"
timedatectl set-timezone ${timezone} --no-ask-password

info "Prepare root password for MySQL"
debconf-set-selections <<< "mysql-community-server mysql-community-server/root-pass password \"''\""
debconf-set-selections <<< "mysql-community-server mysql-community-server/re-root-pass password \"''\""
echo "Done!"

info "Update OS software"
apt-get update
apt-get upgrade -y

info "Install php & apache2 software"
apt-get install software-properties-common python-software-properties
add-apt-repository -y ppa:ondrej/php
apt-get update
apt-get install -y php7.3 php7.3-bz2 php7.3-dev php7.3-enchant php7.3-xsl php7.3-json php7.3-common php7.3-curl php7.3-cli php7.3-intl php7.3-mysql php7.3-gd php7.3-fpm php7.3-mbstring php7.3-xml php7.3-zip libapache2-mod-php unzip apache2 mysql-server-5.7 php-xdebug

info "Install NodeJS"
curl -sL https://deb.nodesource.com/setup_11.x | sudo -E bash -
apt-get install -y nodejs

info "Configure MySQL"
sed -i "s/.*bind-address.*/bind-address = 0.0.0.0/" /etc/mysql/mysql.conf.d/mysqld.cnf
mysql -uroot <<< "CREATE USER 'developer'@'localhost' IDENTIFIED BY ''"
mysql -uroot <<< "GRANT ALL PRIVILEGES ON *.* TO 'developer'@'localhost'"
mysql -uroot <<< "FLUSH PRIVILEGES"
echo "Done!"

info "Configure PHP-FPM"
sed -i 's/user = www-data/user = vagrant/g' /etc/php/7.3/fpm/pool.d/www.conf
sed -i 's/group = www-data/group = vagrant/g' /etc/php/7.3/fpm/pool.d/www.conf
sed -i 's/owner = www-data/owner = vagrant/g' /etc/php/7.3/fpm/pool.d/www.conf
cat << EOF > /etc/php/7.3/mods-available/xdebug.ini
zend_extension=xdebug.so
xdebug.remote_enable=1
xdebug.remote_connect_back=1
xdebug.remote_port=9000
xdebug.remote_autostart=1
EOF
echo "Done!"

info "Configure Apache"
sudo sed -ri -e 's/(export\s+APACHE_RUN_(USER|GROUP))=www-data/\1=vagrant/' /etc/apache2/envvars
echo "Done!"

info "Configure Apache2"
a2enmod php7.3
a2enmod proxy_fcgi setenvif
a2enconf php7.3-fpm
a2enmod rewrite
echo "Done!"

info "Enabling site configuration"
cp /app/vagrant/apache2/app.conf /etc/apache2/sites-available/app.conf
echo "Done!"

info "Activating Site"
a2ensite app.conf
echo "Done!"

info "Initailize databases for MySQL"
mysql -uroot <<< 'CREATE DATABASE `kriteria_dev`;'
mysql -uroot <<< 'CREATE DATABASE `kriteria_prod`;'
mysql -uroot <<< 'CREATE DATABASE `kriteria_test`;'
echo "Done!"

info "Install composer"
curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
