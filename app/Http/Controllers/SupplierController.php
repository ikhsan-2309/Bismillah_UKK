<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Supplier;

class SupplierController extends Controller
{
    public function index()
    {
        $data['breadcrumb_items'] = [
            ['link' => '/dashboard', 'label' => 'Dashboard'],
            ['link' => '/products', 'label' => 'Products'],
            // Add more items as needed
        ];
        $data['page_title'] = 'Manage Supplier';
        return view('admin.supplier.index',$data);
    }

    public function data()
    {
        $supplier = Supplier::orderBy('id_supplier', 'desc')->get();

        return datatables()
            ->of($supplier)
            ->addIndexColumn()
            ->addColumn('aksi', function ($supplier) {
                return '
                <div class="btn-group">
                <button onclick="editForm(`' . route('supplier.update', $supplier->id_supplier) . '`)" class="btn btn-xs btn-info btn-flat">
                    <i class="bi bi-pencil-square text-white"></i>
                </button>
                <button onclick="deleteData(`' . route('supplier.destroy', $supplier->id_supplier) . '`)" class="btn btn-xs btn-danger btn-flat">
                    <i class="bi bi-trash"></i>
                </button>
            </div>
                ';
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $supplier = Supplier::create($request->all());

        return response()->json('Data berhasil disimpan', 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $supplier = Supplier::find($id);

        return response()->json($supplier);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $supplier = Supplier::find($id)->update($request->all());

        return response()->json('Data berhasil disimpan', 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $supplier = Supplier::find($id)->delete();

        return response(null, 204);
    }
}
