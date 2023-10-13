51Tracking API PHP SDK
=================

The PHP SDK of 51Tracking API

Contact: <service@51tracking.org>

## Official document

[Document](https://www.51tracking.com/v4/api-index/API-)

## Index
1. [Installation](https://github.com/51tracking/51tracking-sdk-php#installation)
2. [Testing](https://github.com/51tracking/51tracking-sdk-php#testing)
3. SDK
    1. [Couriers](https://github.com/51tracking/51tracking-sdk-php#couriers)
    2. [Trackings](https://github.com/51tracking/51tracking-sdk-php#trackings)
    3. [Air Waybill](https://github.com/51tracking/51tracking-sdk-php#air-waybill)


## Installation
##### 选项 1（推荐）： 下载并安装 Composer。

运行以下命令以安装 51Tracking PHP SDK
```
composer require 51tracking/51tracking-sdk-php
```
使用自动加载器导入 SDK 文件
```php
require('vendor/autoload.php');

use Tracking51\Tracking51Exception;
use Tracking51\AirWaybills;
use Tracking51\Couriers;
use Tracking51\Trackings;

$key = 'you api key';

$response = null;

$couriers = new Couriers($key);
$trackings = new Trackings($key);
$airWaybill = new AirWaybills($key);

try {
    //Get all couriers (couriers/all)
    $response = $couriers->getAllCouriers();
} catch (Tracking51Exception $e) {
    echo $e->getMessage();
}

print_r($response);

```

##### 选项 2：手动安装
1. 下载或克隆此软件源到所需位置
2. 在您的项目中引用此 SDK 的文件。最好使用绝对路径。

```php
<?php

require(__DIR__ . '/51tracking/51tracking-sdk-php/src/Tracking51Exception.php');
require(__DIR__ . '/51tracking/51tracking-sdk-php/src/Request.php');
require(__DIR__ . '/51tracking/51tracking-sdk-php/src/Interfaces/CouriersInterface.php');
require(__DIR__ . '/51tracking/51tracking-sdk-php/src/Couriers.php');
require(__DIR__ . '/51tracking/51tracking-sdk-php/src/Interfaces/TrackingsInterface.php');
require(__DIR__ . '/51tracking/51tracking-sdk-php/src/Trackings.php');
require(__DIR__ . '/51tracking/51tracking-sdk-php/src/Interfaces/AirWaybillsInterface.php');
require(__DIR__ . '/51tracking/51tracking-sdk-php/src/AirWaybills.php');

$key = 'you api key';

$couriers = new Tracking51\Couriers($key);
$trackings = new Tracking51\Trackings($key);
$airWaybill = new Tracking51\AirWaybills($key);

$response = null;

try {
    //Get all couriers (couriers/all)
    $response = $couriers->getAllCouriers();
} catch (Tracking51\Tracking51Exception $e) {
    echo $e->getMessage();
}

print_r($response);

```

## Testing
1. 执行文件：
 * 如果手动安装，请在浏览器上执行 "51tracking/51tracking-sdk-php/examples/testing.php"。
 * 如果通过 composer 安装，请在浏览器上执行 "vendor/51tracking/51tracking-sdk-php/examples/testing.php"。
2. 插入 51Tracking API 密钥。[如何生成 51Tracking API 密钥](https://www.51tracking.com/v4/api-index/API-)
3. 点击全部请求按钮或代表请求的按钮。

## Error handling

只需添加一个 try-catch 块即可

```php
try {
  $couriers = new Tracking51\Couriers('you api key');
  $response = $couriers->getAllCouriers();
}catch(\Tracking51Exception $e) {
    echo $e->getMessage();
}

```

## Couriers
##### 返回所有支持的快递公司列表
https://api.51Tracking.com/v4/couriers/all
```php
$couriers = new Tracking51\Couriers('you api key');
$response = $couriers->getAllCouriers();
```

## Trackings
##### 单个物流单号实时添加且查询
https://api.51Tracking.com/v4/trackings/create
```php
$trackings = new Tracking51\Trackings('you api key');
$params = ['tracking_number'=>'9400111899562537624646','courier_code'=>'usps'];
$response = $trackings->createTracking($params);
```

##### 获取多个物流单号的查询结果
https://api.51Tracking.com/v4/trackings/get
```php
$trackings = new Tracking51\Trackings('you api key');
$params = ['tracking_numbers'=>'92612903029511573030094532,9400111899562539126562','courier_code'=>'usps','created_date_min'=>'2023-08-23T06:00:00+00:00','created_date_max'=>'2023-09-05T07:20:42+00:00'];
$response = $trackings->getTrackingResults($params);
```

##### 添加多个物流单号（一次调用最多创建 40 个物流单号）
https://api.51Tracking.com/v4/trackings/batch
```php
$trackings = new Tracking51\Trackings('you api key');
$params = [
    ['tracking_number'=>'92612903029511573030094531','courier_code'=>'usps'],
    ['tracking_number'=>'92612903029511573030094532','courier_code'=>'usps']
];
$response = $trackings->batchCreateTrackings($params);
```

##### 根据ID更新物流信息
https://api.51Tracking.com/v4/trackings/update/{id}
```php
$trackings = new Tracking51\Trackings('you api key');
$params = ['customer_name'=>'New name','note'=>'New tests order note'];
$idString = '9a035f5cdd0437c55d48e223c705a66c';
$response = $trackings->updateTrackingByID($idString,$params);
```

##### 通过ID删除单号
https://api.51Tracking.com/v4/trackings/delete/{id}
```php
$trackings = new Tracking51\Trackings('you api key');
$idString = '99f8a21408be0b436705aa84d6f91806';
$response = $trackings->deleteTrackingByID($idString);
```

##### 通过ID重新查询过期的单号
https://api.51Tracking.com/v4/trackings/retrack/{id}
```php
$trackings = new Tracking51\Trackings('you api key');
$idString = '9a035f5cdd0437c55d48e223c705a66c';
$response = $trackings->retrackTrackingByID($idString);
```
## Air Waybill
##### 查询航空运单的结果
https://api.51Tracking.com/v4/awb
```php
$airWaybill = new Tracking51\AirWaybills('you api key');
$params = ['awb_number'=>'235-69030430'];
$response = $airWaybill->createAnAirWayBill($params);
```

## 响应状态码

51Tracking 使用传统的HTTP状态码来表明 API 请求的状态。通常，2xx形式的状态码表示请求成功，4XX形式的状态码表请求发生错误（比如：必要参数缺失），5xx格式的状态码表示 51tracking 的服务器可能发生了问题。

Http CODE|META CODE|TYPE | MESSAGE
----|-----|--------------|-------------------------------
200    |200     | <code>成功</code>        |    请求响应成功。
400    |400     | <code>错误请求</code>     |    请求类型错误。请查看 API 文档以了解此 API 的请求类型。
400    |4101    | <code>错误请求</code>     |    物流单号已存在。
400    |4102    | <code>错误请求</code>     |    物流单号不存在。请先使用「Create接口」将单号添加至系统。
400    |4103    | <code>错误请求</code>     |    您已超出 API 调用的创建数量。每次创建的最大数量为 40 个快递单号。
400    |4110    | <code>错误请求</code>     |    物流单号(tracking_number) 不符合规则。
400    |4111    | <code>错误请求</code>     |    物流单号(tracking_number)为必填字段。
400    |4112    | <code>错误请求</code>     |    查询ID无效。
400    |4113    | <code>错误请求</code>     |    不允许重新查询。您只能重新查询过期的物流单号。
400    |4120    | <code>错误请求</code>     |    物流商简码(courier_code)的值无效。
400    |4121    | <code>错误请求</code>     |    无法识别物流商。
400    |4122    | <code>错误请求</code>     |    特殊物流商字段缺失或填写不符合规范。
400    |4130    | <code>错误请求</code>     |    请求参数的格式无效。
400    |4160    | <code>错误请求</code>     |    空运单号(awb_number)是必需的或有效的格式。
400    |4161    | <code>错误请求</code>     |    此空运航空不支持查询。
400    |4165    | <code>错误请求</code>     |    查询失败：未创建空运单号。
400    |4166    | <code>错误请求</code>     |    删除未创建的空运单号失败。
400    |4167    | <code>错误请求</code>     |    空运单号已存在，无需再次创建。
400    |4190    | <code>错误请求</code>     |    当前查询额度不足。
401    |401     | <code>未经授权</code>   |    身份验证失败或没有权限。请检查并确保您的 API 密钥正确无误。
403    |403     | <code>禁止</code>      |    禁止访问。请求被拒绝或不允许访问。
404    |404     | <code>未找到</code>       |    页面不存在。请检查并确保您的链接正确无误。
429    |429     | <code>太多请求</code>|    超出 API 请求限制，请稍后重试。请查看 API 文档以了解此 API 的限制。
500    |511     | <code>服务器错误</code>    |    服务器错误。请联系我们： service@51Tracking.org。
500    |512     | <code>服务器错误</code>    |    服务器错误。请联系我们：service@51Tracking.org。
500    |513     | <code>服务器错误</code>    |    服务器错误。请联系我们： service@51Tracking.org。