# IntElect
IntElect is an open-source e-voting solution for school, business and organisations.

## Requirements
Docker (we recommend using the latest version - e.g. from the official repositories)

## Installation
1. Clone this git repository
` git clone https://github.com/htlkrems/IntElect.git `

2. Build the docker container manually
```
 docker volume create mysql_data_intelect
 docker run -d --name intelect --mount source=mysql_data_intelect,target=/var/lib/mysql --mount type=bind,source=/path-to-repo/IntElect,target=/var/www/html/intelect -p 80:80 bsteindl/intelect
```

3. Prepare the database
```
 docker exec -it intelect bash
 cd /var/www/html/intelect/
 composer install
 chmod 775 storage/ -R
 chmod 777 public/uploads/ -R
 php artisan migrate
 mysql -u intelect-user -p5G7XC4bhNw92GGccjpfVQbS < /var/www/html/intelect/app/database_init.sql 
 exit
 docker stop intelect
```

4. Run it as a daemon
```
 docker run -d --mount source=mysql_data_intelect,target=/var/lib/mysql --mount type=bind,source=/path-to-repo/IntElect,target=/var/www/html/intelect -p 80:80 bsteindl/intelect
```

## Default login credentials
Username: admin

Password: admin


Make sure to change the administrator password IMMEDEATELY after installation!
