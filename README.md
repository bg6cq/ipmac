## 简单的记录网内IP/MAC 和 MAC/交换机接口 信息程序

### 一、原理
    使用expect模拟管理员登录交换机，获取IP/MAC地址信息、MAC地址/交换机接口信息，并记录到数据库中，通过简单web显示。

### 二、IP/MAC地址记录

    程序为`ipmac_from_stdin.php`，执行参数
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

