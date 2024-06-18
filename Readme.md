# Kanban module for Yii2

## Installation

Unpack the module code in the desired location (usually ***@common/modules***). Add the module namespace alias to the bootstrap.php file:
```php
Yii::setAlias('@mf/kanban', '@common/modules/MF_Kanban');
```
You will most likely be using the module in one of your applications, so use bootstrap.php and further settings in the relevant application's configuration, rather than in @common/config.

In the application settings, describe the module to be installed:
```php
...........
    'modules'             => [
        ...........
        'kanban' => [
            'class'      => '\mf\kanban\Module',
            'layoutPath' => '@app/views/layouts',
        ]
        ...........
    ],
...........
```
Thus, the URL to the module will be ```http(s)://<you_base_host>/<module_index_in_settings>```.
**module_index_in_settings** in this case is ***kanban***.

**layoutPath** indicate which one is needed, but it must exist. 
See [Module settings](https://www.yiiframework.com/doc/guide/2.0/en/structure-modules#using-modules).

The next step is to perform migrations. All necessary tables have the kanban_ prefix, so they most likely will not interfere with tables in the current database, and migrations can be performed in another database. 
In any case, the controller needs to specify the path to the migrations.
See [Yii2 migrations](https://www.yiiframework.com/doc/guide/2.0/en/db-migrations#using-command-line-options).

*For example (assuming that the module is located in @common/modules, and the database is different from the default):*
```shell
$ php yii migrate/up --db=<database name> --migrationPath=@common/modules/MF_Kanban/migrations
```
