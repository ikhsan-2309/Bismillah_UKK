<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kategori;
use Yajra\DataTables\DataTables;
use App\DataTables\KategoriDataTable;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;

class KategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['breadcrumb_items'] = [
            ['link' => '/dashboard', 'label' => 'Dashboard'],
            ['link' => '/categories', 'label' => 'Categories'],
            // Add more items as needed
        ];
        $data['page_title'] = 'Manage Categories';
        return view('admin.category.index', $data);
    }

    // public function data()
    // {
    //     $kategori = Kategori::orderBy('id_kategori', 'desc')->get();
    //     return DataTables::of($kategori)
    //         ->addIndexColumn()
    //         ->addColumn('aksi', function ($kategori) {
    //             return '
    //                 <div class="btn-group">
    //                     <button onclick="editForm(`' . route('kategori.update', $kategori->id_kategori) . '`)" class="btn btn-xs btn-info btn-flat">
    //                         <i class="bi bi-pencil-square text-white"></i>
    //                     </button>
    //                     <button onclick="deleteData(`' . route('kategori.destroy', $kategori->id_kategori) . '`)" class="btn btn-xs btn-danger btn-flat">
    //                         <i class="bi bi-trash"></i>
    //                     </button>
    //                 </div>
    //             ';
    //         })
    //         ->toJson(); // Ensure that the response is in JSON format
    // }



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
        $kategori = new Kategori();
        $kategori->nama_kategori = $request->nama_kategori;
        $kategori->save();

        return response()->json('Data berhasil disimpan', 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function data()
    {
        $kategori = Kategori::orderBy('id_kategori', 'desc')->get();

        return datatables()
            ->of($kategori)
            ->addIndexColumn()
            ->addColumn('aksi', function ($kategori) {
                return '
                   <div class="btn-group">
                       <button onclick="editForm(`' . route('kategori.update', $kategori->id_kategori) . '`)" class="btn btn-xs btn-info btn-flat">
                           <i class="bi bi-pencil-square text-white"></i>
                       </button>
                       <button onclick="deleteData(`' . route('kategori.destroy', $kategori->id_kategori) . '`)" class="btn btn-xs btn-danger btn-flat">
                           <i class="bi bi-trash"></i>
                       </button>
                   </div>
               ';
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }
    public function show($id)
    {
        $kategori = Kategori::find($id);
        return response($kategori);
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
        $kategori = Kategori::find($id);
        $kategori->nama_kategori = $request->nama_kategori;
        $kategori->update();

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
        $kategori = Kategori::find($id);
        $kategori->delete();

        return response(null, 204);
    }
}
