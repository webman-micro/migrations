# webman-micro/migrations

包装 robmorgan/phinx 组件支持webman命令行

# 说明
Phinx 可以让开发者简洁的修改和维护数据库。 它避免了人为的手写 SQL 语句，它使用强大的 PHP API 去管理数据库迁移。开发者可以使用版本控制管理他们的数据库迁移。 Phinx 可以方便的进行不同数据库之间数据迁移。还可以追踪到哪些迁移脚本被执行，开发者可以不再担心数据库的状态从而更加关注如何编写出更好的系统。

# 项目地址

https://github.com/webman-micro/migrations

# 安装

通过`composer`安装

```php
composer require webman-micro/migrations
```

# 官方中文文档地址

详细使用可以去看官方中文文档，这里只讲怎么在webman中配置使用

https://tsy12321.gitbooks.io/phinx-doc/content/

# 配置说明

```
|-- config                       # webman 配置文件
    |-- plugin
        |-- webman-micro
            |-- migrations
                |-- app.php          # 主配置信息
                |-- command.php      # 自定命令    
```

## 主配置信息

```php
<?php
return [
    'enable' => true,
    "paths" => [
        "migrations" => "database/migrations", // 迁移文件存储路径
        "seeds" => "database/seeders" // 迁移数据文件存在路径
    ],
    "environments" => [
        "default_migration_table" => "phinxlog", // 迁移记录表
        "default_environment" => "product", // 默认使用的环境配置
        "product" => [
            "adapter" => "mysql", // 使用mysql 配置
            "host" => getenv("DB_HOST", '127.0.0.1'),
            "name" => getenv("DB_NAME", ''),
            "user" => getenv("DB_USER", ''),
            "pass" => getenv("DB_PASSWORD", ''),
            "port" => getenv("DB_PORT", '3306'),
            "charset" => "utf8"
        ]
    ]
];

```

## 迁移文件目录结构

```
.
├── app                           应用目录
│   ├── controller                控制器目录
│   │   └── Index.php             控制器
│   ├── model                     模型目录
......
├── database                      数据库文件
│   ├── migrations                迁移文件
│   │   └── 20180426073606_create_user_table.php
│   ├── seeders                   迁移数据
│   │   └── UserSeeder.php
......
```

# 命令行说明

## migrations 迁移文件命令

| 命令                                 | 说明                       |
|------------------------------------|--------------------------|
| php webman migrations:breakpoint   | 设置断点                     |
| php webman migrations:create       | 创建迁移脚本文件                 |
| php webman migrations:list_aliases | 列出模板类别名                  |
| php webman migrations:migrate      | 运行执行所有脚本                 |
| php webman migrations:rollback     | 回滚之前的迁移脚本,与 Migrate 命令相反 |
| php webman migrations:status       | 打印所有迁移脚本和他们的状态           |
| php webman migrations:test         | 验证配置文件                   |

### Breakpoint 命令

Breakpoint 命令用来设置断点，可以使你对回滚进行限制。你可以调用 breakpoint 命令不带任何参数，即将断点设在最新的迁移脚本上

```
$ php webman migrations:breakpoint -e development
```

可以使用 `--target` 或者 `-t` 来指定断点打到哪个迁移版本上

```
$ php webman migrations:breakpoint -e development -t 20120103083322
```

可以使用 `--remove-all` 或者`-r` 来移除所有断点

```
$ php webman migrations:breakpoint -e development -r
```

当你运行 `status` 命令时可以看到断点信息

### Create 命令

create 命令用来创建迁移脚本文件。需要一个参数：脚本名。迁移脚本命名应该保持 驼峰命名法

```
$ php webman migrations:create MyNewMigration
```

打开新创建的迁移脚本并编写数据库修改。Phinx 把迁移脚本创建到 `phinx.yml` 里面指定的路径。更多信息参考 [配置](/configuration.md)

你可以重写模板文件，并在创建的时候指定模板

```
$ php webman migrations:create MyNewMigration --template="<file>"
```

可以提供一个模板类，这个类必须继承接口 `Phinx\Migration\CreationInterface`

```
$ php webman migrations:create MyNewMigration --class="<class>"
```

提供的模板中，类中也可以定义回调，这个回调将在迁移脚本生成的时候被调用

注意：你不能同时使用 `--template` 和 `--class`

### Migrate 命令

Migrate 命令默认运行执行所有脚本，可选指定环境

```
$ php webman migrations:migrate -e development
```

可以使用 `--target` 或者 `-t` 来指定执行某个迁移脚本

```
$ php webman migrations:migrate -e development -t 20110103081132
```

### Rollback 命令

Rollback 命令用来回滚之前的迁移脚本。与 Migrate 命令相反。

你可以使用 `rollback` 命令回滚上一个迁移脚本。不带任何参数

```
$ php webman migrations:rollback -e development
```

使用 `--target` 或者 `-t` 回滚指定版本迁移脚本

```
$ php webman migrations:rollback -e development -t 20120103083322
```

指定版本如果设置为0则回滚所有脚本

```
$ php webman migrations:rollback -e development -t 0
```

可以使用 `--date` 或者 `-d` 参数回滚指定日期的脚本

```
$ php webman migrations:rollback -e development -d 2012
$ php webman migrations:rollback -e development -d 201201
$ php webman migrations:rollback -e development -d 20120103
$ php webman migrations:rollback -e development -d 2012010312
$ php webman migrations:rollback -e development -d 201201031205
$ php webman migrations:rollback -e development -d 20120103120530
```

如果断点阻塞了回滚，你可以使用 `--force` 或者`-f`参数强制回滚

```
$ php webman migrations:rollback -e development -t 0 -f
```

### Status 命令

Status 命令可以打印所有迁移脚本和他们的状态。你可以用这个命令来看哪些脚本被运行过了

```
$ php webman migrations:status -e development
```

当所有脚本都已经执行（up）该命令将退出并返回 0

* 1：至少有一个回滚过的脚本（down）
* 2：至少有一个未执行的脚本

## Seed 数据填充文件命令

| 命令                     | 说明        |
|------------------------|-----------|
| php webman seed:create | 创建 seed 类 |
| php webman seed:run    | 执行所有 seed |

## Seed Create 命令

Seed Create 命令可以被用来创建 seed 类。需要一个类名参数。命名格式使用驼峰法。

```
$ php webman seed:create MyNewSeeder
```

## Seed Run 命令

默认Seed run 命令会执行所有 seed。

```
$ php webman seed:run -e development
```

如果你想要指定执行一个，只要增加 -s 参数并接 seed 的名字

```
$ php webman seed:run -e development -s MyNewSeeder
```
