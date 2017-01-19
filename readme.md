# Laravel with google sheet
Lấy dữ liệu từ google sheet


## Installation

1. Run 
    ```
    composer require kayac/sheet:1.6.x@dev
    ```
    
2. Add service provider into **config/app.php** file.
    ```php
    Kayac\Sheet\CallRouteServiceProvider::class
    ```
3. Run **composer update**

4. publish kayacsheet.php to config folder
```
php artisan vendor:publish --provider="Kayac\Sheet\CallRouteServiceProvider" --tag=config
```

## Commands
Tạo controller bất kỳ và 
```
<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Router;
use Kayac\Sheet\SheetReader;

class MasterDataController extends MyController
{
    function __construct(Router $router)
    {
        parent::__construct($router);
    }

    public function index() {
        $sheet = new SheetReader();
        $sheet->generateKey();
    }

}


```

Chạy lệnh sau để tạo file credentials với google
```
php artisan route:call --uri=/master-data
```


##Author
Hà Anh Mận

##Document
Xem thêm cách dùng Google Sheet ở đây
https://developers.google.com/sheets/api/quickstart/php