# httpresponse

httpresponse just make sure that your http request library and your code easily.  


## settings

please check if you use nginx.  


### phalcon + nginx + php5.5

* php-fpm

```bash
$ yum install -y php55w-fpm

# do mkdir /var/run/php-fpm/ if the directory is not exists
$ cd /var/run/php-fpm/
$ touch php-fpm.sock
$ chown nginx:nginx php-fpm.sock


$ cd /etc/php-fpm.d
$ vi www.conf

listen = 127.0.0.1:9000
↓
listen = /var/run/php-fpm/php-fpm.sock


;listen.owner = nobody
;listen.group = nobody
;listen.mode = 0660

↓ remove comment

listen.owner = nginx
listen.group = nginx
listen.mode = 0660
```

* vi /etc/nginx/conf.d/xxxx.conf

```bash
server {
	listen       80;
	server_name  your.domain.com;

	index index.php index.html index.htm;

	root /var/www/html/to/your/project/public;

	try_files $uri $uri/ @rewrite;

	location @rewrite {
		rewrite ^(.*)$ /index.php?_url=$1;
	}

	location ~ \.php$ {
		fastcgi_pass unix:/var/run/php-fpm/php-fpm.sock;
		fastcgi_index /index.php;

		include /etc/nginx/fastcgi_params;

		fastcgi_split_path_info ^(.+\.php)(/.+)$;
		fastcgi_param PATH_INFO       $fastcgi_path_info;
		fastcgi_param PATH_TRANSLATED $document_root$fastcgi_path_info;
		fastcgi_param  SCRIPT_FILENAME  $document_root$fastcgi_script_name;
	}
	location ~* ^/(css|img|js|flv|swf|download)/(.+)$ {
		root /var/www/html/to/your/project/public;
	}
	location ~ /\.ht {
		deny all;
	}
}
```

* restart

```bash
# Centos7
$ systemctl restart nginx.service
$ systemctl restart php-fpm.service

# Centos6
$ /etc/rc.d/init.d/nginx restart
$ /etc/rc.d/init.d/php-fpm restart
```


## endpoints

* /success [GET, POST, PUT, PATCH, DELETE]

```
return success with 200
```


* /error [GET, POST, PUT, PATCH, DELETE]

```
return error with 404
```


* /upload [POST, PUT, PATCH]

```
you can check upload file
```
