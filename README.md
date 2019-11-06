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

