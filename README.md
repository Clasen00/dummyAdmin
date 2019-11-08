# Dummy admin

To run it just add something like this in your xampp\apache\conf\extra:

```
<VirtualHost dummyadmin:80>
    ServerAdmin admin.ru
    DocumentRoot "C:\xampp\htdocs\dummyadmin\index.php"
    ServerName dummyadmin
    ServerAlias www.dummyadmin.loc
    ErrorLog "logs/dummyadmin.loc.log"
    CustomLog "logs/dummyadmin.loc.log" common
</VirtualHost>
```

also, add `127.0.0.1  dummyadmin` to your hosts file.

To make your db.php work you need to add in app->database file databaseConfig.php It should looks something like this

```
<?php

namespace app\database;

class DatabaseConfig
{
    public static $dsn = 'mysql:dbname=YOURDBNAME;host=localhost';
    public static $user = 'USER';
    public static $pass = 'PASSWORD';

}
```

