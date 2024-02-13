<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;
use App\Models\Produk;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class ProdukController extends Controller
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
            ['link' => '/products', 'label' => 'Products'],
            // Add more items as needed
        ];
        $data['page_title'] = 'Manage Products';
        $kategori = Kategori::all()->pluck('nama_kategori', 'id_kategori');

        return view('admin.produk.index', compact('kategori'), $data);
    }

    public function data()
    {
        $produk = Produk::leftJoin('kategori', 'kategori.id_kategori', 'produk.id_kategori')
            ->select('produk.*', 'nama_kategori')
            // ->orderBy('kode_produk', 'asc')
            ->get();

        return datatables()
            ->of($produk)
            ->addIndexColumn()
            ->addColumn('select_all', function ($produk) {
                return '
                    <input type="checkbox" name="id_produk[]" value="' . $produk->id_produk . '">
                ';
            })
            ->addColumn('kode_produk', function ($produk) {
                return '<span class="badge badge-success">' . $produk->kode_produk . '</span>';
            })
            ->addColumn('nama_produk', function ($produk) {
                return '<td class="py-1 pl-0">
                <div class="d-flex align-items-center">
                  <img src="../../../../storage/images/produk/' . $produk->gambar_produk . '" alt="profile" />
                  <div class="ms-3">
                    <p class="mb-0">' . $produk->nama_produk . '</p>
                    <p class="mb-0 text-muted text-small">' . $produk->nama_kategori . '</p>
                  </div>
                </div>
              </td>';
            })
            ->addColumn('harga_beli', function ($produk) {
                return format_uang($produk->harga_beli);
            })
            ->addColumn('harga_jual', function ($produk) {
                return format_uang($produk->harga_jual);
            })
            ->addColumn('stok', function ($produk) {
                return format_uang($produk->stok);
            })
            ->addColumn('aksi', function ($produk) {
                return '
                <div class="btn-group">
                    <button onclick="editForm(`' . route('produk.update', $produk->id_produk) . '`)" class="btn btn-sm btn-info btn-flat p-2">
                        <i class="fa-regular fa-pen-to-square"></i>
                    </button>
                    <button onclick="deleteData(`' . route('produk.destroy', $produk->id_produk) . '`)" class="btn btn-sm btn-danger btn-flat p-2">
                        <i class="fa-regular fa-trash-can"></i>
                    </button>
                </div>
                ';
            })
            ->rawColumns(['aksi', 'nama_produk', 'kode_produk', 'select_all'])
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
        $produk = Produk::latest()->first() ?? new Produk();
        $request['kode_produk'] = 'P' . tambah_nol_didepan((int)$produk->id_produk + 1, 6);

        if ($request->hasFile('gambar_produk')) {
            $imageName = time() . '_' . $request->file('gambar_produk')->getClientOriginalName();
            $imagePath = $request->file('gambar_produk')->storeAs('public/images/produk', $imageName);
            $produk->gambar_produk = $imageName; // Masukkan nama gambar ke dalam request
        }

        $produk = Produk::create([
            'kode_produk' => $request->kode_produk,
            'id_kategori' => $request->id_kategori,
            'nama_produk' => $request->nama_produk,
            'merk' => $request->merk,
            'gambar_produk' => $imageName,
            'harga_beli' => $request->harga_beli,
            'diskon' => $request->diskon,
            'harga_jual' => $request->harga_jual,
            'stok' => $request->stok,
        ]);

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
        $produk = Produk::find($id);

        return response()->json($produk);
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
        $produk = Produk::find($id);
    
        // Hapus gambar lama jika ada gambar yang baru diunggah
        if ($request->hasFile('gambar_produk')) {
            Storage::delete('public/images/produk/' . $produk->gambar_produk);
            $imageName = time() . '_' . $request->file('gambar_produk')->getClientOriginalName();
            $imagePath = $request->file('gambar_produk')->storeAs('public/images/produk', $imageName);
            $produk->gambar_produk = $imageName; // Masukkan nama gambar ke dalam model
        }
    
        // Perbarui produk
        $produk->update([
            'id_kategori' => $request->id_kategori,
            'nama_produk' => $request->nama_produk,
            'merk' => $request->merk,
            // Hanya perbarui gambar_produk jika gambar baru diunggah
            'gambar_produk' => $request->hasFile('gambar_produk') ? $imageName : $produk->gambar_produk,
            'harga_beli' => $request->harga_beli,
            'diskon' => $request->diskon,
            'harga_jual' => $request->harga_jual,
            'stok' => $request->stok,
        ]);
    
        return response()->json('Data berhasil disimpan', 200);
    }
    


    public function destroy($id)
    {
        $produk = Produk::find($id);

        // Hapus gambar terkait dari penyimpanan
        Storage::delete('public/images/produk/' . $produk->gambar_produk);

        // Hapus produk dari database
        $produk->delete();

        return response(null, 204);
    }

    public function deleteSelected(Request $request)
    {
        foreach ($request->id_produk as $id) {
            $produk = Produk::find($id);

            // Hapus gambar terkait dari penyimpanan
            Storage::delete('public/images/produk/' . $produk->gambar_produk);

            // Hapus produk dari database
            $produk->delete();
        }

        return response(null, 204);
    }


    public function cetakBarcode(Request $request)
    {
        $dataproduk = array();
        foreach ($request->id_produk as $id) {
            $produk = Produk::find($id);
            $dataproduk[] = $produk;
        }
        $no  = 1;
        $pdf = PDF::loadView('admin.produk.barcode', compact('dataproduk', 'no'));
        $pdf->setPaper('a4', 'potrait');
        return $pdf->stream('produk.pdf');
    }
}
