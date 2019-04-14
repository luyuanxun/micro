# micro 介绍
本项目是基于当前最新的phalcon3.4.3微型应用，phalcon是基于C扩展的高性能框架，phalcon自带mvc结构，所以此项目只有300kb多，代码少易部署，非常轻量。
完全restful风格，亮点如下：
* 提供scaffold脚手架，一键生成增删改查api接口
* restful ，基于php-jwt的api授权
* 提供cli控制台，可结合cli使用swoole异步通信引擎...
* 封装参数验证器，使用更方便更简单


# 安装
```
git clone https://github.com/luyuanxun/micro.git
```
```
composer install
```

# 启动
### 1、直接启动：本地安装php7+和phalcon3.4
```
php -S localhost:9000 -t public/ .htrouter.php
```
注：此方式只能用作于开发,上线请使用nginx+php-fpm方式

### 2.docker启动：docker里已安装phalcon3.4.3和swoole4.3.2扩展
```
docker-compose up -d
```
# scaffold脚手架介绍：代码生成器
#### 参数说明：
* 固定参数：php run scaffold
* --type 为生成类型，如crud、controller、model，默认为crud
* --table 为mysql数据表，如user
* -f 如果已经生成过了，没加此参数将生成失败，加了此参数将会覆盖
##### 举例：假如数据库有一张news新闻表
```
php run scaffold rest --type=crud --table=news -f
```
##### 结果：
```
$ php run scaffold rest --type=crud --table=news -f
controller生成成功：micro/app/controllers/NewsController.php
model生成成功：micro/app/models/News.php
service生成成功：micro/app/services/NewsService.php
CURD完成！！！
恭喜恭喜，请根据micro/app/app.php的路由规则测试一波
```
##### 注：项目里test文件夹有news.sql和postman文件可供参考，若token过期需重新登录

#### 访问 http://localhost:9000/news/list?page=1&pageSize=10
```
{
    "code": 200,
    "msg": "SUCCESS",
    "data": {
        "pagination": {
            "page": 1,
            "pageSize": 10,
            "pageCount": 5
        },
        "list": [
            {
                "id": "x2SCQ8UW1ML0uwiZ6fVdjzI=",
                "title": "title2",
                "content": "content22222"
            },
            {
                "id": "uUoR3CNDZz4W6EGpo0wxiE4=",
                "title": "title3",
                "content": "content6666"
            }
        ]
    }
}
```

# cli控制台
除了代码生成器脚手架scaffold，还可以自定义命令，可参考app/tasks/TimerTask.php
```
$ php run timer tick
每秒执行一次,10秒后停止！
每秒执行一次,10秒后停止！
每秒执行一次,10秒后停止！
每秒执行一次,10秒后停止！
每秒执行一次,10秒后停止！
每秒执行一次,10秒后停止！
每秒执行一次,10秒后停止！
每秒执行一次,10秒后停止！
每秒执行一次,10秒后停止！
每秒执行一次,10秒后停止！
时间到了，结束！
```
##### 注：进入docker内直接运行 ，若本地运行TimerTask.php需安装swoole扩展

# 验证器Validation说明
* required 必填，不能为空
* alphaNum 必须为字母和数字
* alpha 必须为字母
* date 时间格式 date:Y-m-d H:i:s 或 date:Y-m-d 等等
* digit 必须为整数
* num 必须为数字
* email 必须为邮箱
* notIn 不包含格式 notIn:1,a,test
* in 包含格式 in:1,a,test
* regex 正则格式 regex:/^[0-9]$/
* strLen 字符串长度限制格式 strLen:min,max
* between 数字大小限制 between:min,max
* strLen 字符串长度限制格式 strLen:min,max
* confirmed 确认字段一致格式 confirmed:field
* url 必须为 url
* creditCard 必须为 必须是信用卡卡号
* unique 唯一判断 unique:model,field //模型名news，字段名title

#### 使用举例多组合式：required|digit|between:1,10|email

# 说明
为了保证安全，会对返回值中数据库的主键（如：id）进行加密，crud操作也传的是加密后的值


# phalcon参考文档
https://docs.phalconphp.com/3.4/zh-cn/application-micro
