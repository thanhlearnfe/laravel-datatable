
<img src="/public/done.png" alt="License">


## Cấu hình

php 8.1,
<a href="https://laravel.com/docs/10.x/installation">laravel 10</a>,
<a href="https://yajrabox.com/docs/laravel-datatables/10.0/installation">yajrabox 10.0</a>,
<a href="https://cdn.datatables.net/1.10.21/">datatables</a>
bootstrap 5
jquery 3.6.0
    
## Bắt đầu
```sh
npm run dev
php artisan serve
```

## Tự bắt đầu

 ```sh
composer create-project laravel/laravel datatable
cd datatable
php artisan serve
```

## Kết nối database (open .env)
```sh
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laraveldb
DB_USERNAME=root
DB_PASSWORD=""
```
## Tạo bảng
```sh
php artisan make:migration create_customers_table
```
Open database\migrations\create_customers_table.php
```sh
return new class extends Migration
{
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('CustomerName');
            $table->string('Address');
            $table->string('City');
            $table->string('PostalCode');
            $table->string('Country');
            $table->timestamps();
        });
    }
};
```
```sh
php artisan migrate 
```
## Tạo model
```sh
php artisan make:model Customers
```
## Tạo controller
```sh
php artisan make:controller CustomersController
```
app\Http\Controllers\CustomersController.php
```sh
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customers; //add Customers Model
use DataTables;

class CustomersController extends Controller
{
    function index()
    {
        return view('index');
    }

    function getdata()
    {
    $customer = Customers::select('id', 'CustomerName', 'Address', 'City', 'PostalCode', 'Country');
    return Datatables::of($customer)
            ->addColumn('action', function($customer){
                return '<a href="#" class="btn btn-xs btn-primary edit" id="'.$customer->id.'"><i class="bi bi-pencil-square"></i> Edit</a> <a href="#" class="btn btn-xs btn-danger delete" id="'.$customer->id.'"><i class="bi bi-backspace-reverse-fill"></i> Delete</a>';
            })
            ->addColumn('checkbox', '<input type="checkbox" name="customer_checkbox[]" class="customer_checkbox" value="{{$id}}" />')
            ->rawColumns(['checkbox','action'])
            ->make(true);
    }
}
```
laravelproject\routes\web.php
```sh
//laravelproject\routes\web.php
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomersController; //add CustomersController

//Route::get('/', function () {
//    return view('welcome');
//});

Route::get('/', [CustomersController::class, 'index']);
Route::get('ajaxdata', [CustomersController::class, 'getdata'])->name('getdata');
```
laravelproject\resources\views\index.blade.php
//laravelproject\resources\views\index.blade.php
```sh
<!DOCTYPE html>
<html>
<head>
    <title>Laravel Datatables Yajra Server Side</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>

    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css" />
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.3/font/bootstrap-icons.css">
</head>
<body>
<div class="container">
    <br />
    <h3 align="center">Laravel Datatables Yajra Server Side</h3>
    <br />
    <div align="right">
        <button type="button" name="add" id="add_data" class="btn btn-success"> <i class="bi bi-plus-square"></i> Add</button>
    </div>
    <br />
    <table id="customer_table" class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>Name</th>
                <th>Address</th>
                <th>City</th>
                <th>Postal Code</th>
                <th>Country</th>
                <th>Action</th>
                <th>
                    <button type="button" name="bulk_delete" id="bulk_delete" class="btn btn-danger btn-xs"><i class="bi bi-backspace-reverse-fill"></i></button>
                </th>
            </tr>
        </thead>
    </table>
</div>

<script type="text/javascript">
$(document).ready(function() {
    $('#customer_table').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": "{{ route('getdata') }}",
        "columns":[
            { "data": "CustomerName" },
            { "data": "Address" },
            { "data": "City" },
            { "data": "PostalCode" },
            { "data": "Country" },
            { "data": "action", orderable:false, searchable: false},
            { "data":"checkbox", orderable:false, searchable:false}
        ]
    });
});
</script>
</body>
</html>
```
## Install Laravel DataTables
```sh
composer require yajra/laravel-datatables:^10.0
```
## Chạy thôi
```sh
php artisan serve
```