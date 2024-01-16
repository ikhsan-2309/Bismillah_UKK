<?php 

namespace App\Http\Controllers;
 
use App\DataTables\UsersDataTable;
 
class UsersController extends Controller
{
    public function index(UsersDataTable $dataTable)
    {
        $data['breadcrumb_items'] = [
            ['link' => '/dashboard', 'label' => 'Dashboard'],
            ['link' => '/categories', 'label' => 'Categories'],
            // Add more items as needed
        ];
        $data['page_title'] = 'Manage Categories';
        return $dataTable->render('admin.coba',$data);
    }
}