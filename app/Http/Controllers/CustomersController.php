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