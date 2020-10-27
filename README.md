## 简单的记录网内IP/MAC 和 MAC/交换机接口 信息程序

### 一、原理

使用expect模拟管理员登录交换机，获取IP/MAC地址信息、MAC地址/交换机接口信息，并记录到数据库中，通过简单web显示。

### 二、IP/MAC地址记录

程序为 `ipmac_from_stdin.php`，执行参数

```
php ipmac_from_stdin.php [ -d ] router_ip
```

输入文件格式

```
IP地址  MAC地址
...
```

### 三、MAC地址/交换机接口记录

程序为`macport_from_stdin.php`，执行参数

```
php macport_from_stdin.php [ -d ] switch_ip
```

输入文件格式

```
MAC地址 VLAN 接口
...
```

### 四、安装


```
yum install -y git mysql-server mysql expect screen httpd php-cli php php-mysql
service mysqld start
chkconfig mysqld on

cd /usr/src/
git clone https://github.com/bg6cq/ipmac.git
cd ipmac
echo "create database ipmac;" | mysql
cat db/db.sql | mysql ipmac

ln -s /usr/src/ipmac/web /var/www/html/ipmac
```

然后就是根据自己的交换机，参考 getipmac_n7k getmacaddr_hw 等编辑获取信息的脚本，参考 run.sample 编辑运行脚本。

执行 screen ，然后执行 sh run 即可。

### 五、关键表

UplinkPort 表
```
上联口信息，表中的接口MAC地址不记录
```

