<?php

namespace App\Http\Controllers;

use App\Models\SupplierModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class SupplierController extends Controller
{

    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar Supplier',
            'list' => ['Home', 'Supplier']
        ];

        $page = (object) [
            'title' => 'Daftar supplier yang terdaftar dalam sistem',
        ];

        $activateMenu = 'supplier'; //set menu yang sedang aktif

        $supplier = SupplierModel::all();

        return view('supplier.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'supplier' => $supplier, 'activateMenu' => $activateMenu]);
    }

    public function list(Request $request)
    {
        $suppliers = SupplierModel::select('supplier_id', 'supplier_code', 'supplier_nama', 'email', 'no_telp', 'address');

        if ($request->supplier_code) {
            $suppliers->where('supplier_code', $request->supplier_code);
        }

        return DataTables::of($suppliers)
            // menambahkan kolom index / no urut (default nama kolom: DT_RowIndex) 
            ->addIndexColumn()
            ->addColumn('aksi', function ($supplier) {  // menambahkan kolom aksi 
                // $btn  = '<a href="' . url('/supplier/' . $supplier->supplier_id) . '" class="btn btn-info btn-sm">Detail</a> ';
                // $btn .= '<a href="' . url('/supplier/' . $supplier->supplier_id . '/edit') . '" class="btn btn-warning btn-sm">Edit</a> ';
                // $btn .= '<form class="d-inline-block" method="POST" action="' .
                //     url('/supplier/' . $supplier->supplier_id) . '">'
                //     . csrf_field() . method_field('DELETE') .
                //     '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakin menghapus data ini?\');">Hapus</button></form>';
                $btn = '<button onclick="modalAction(\'' . url('/supplier/' . $supplier->supplier_id .
                    '/show_ajax') . '\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/supplier/' . $supplier->supplier_id .
                    '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/supplier/' . $supplier->supplier_id .
                    '/delete_ajax') . '\')"  class="btn btn-danger btn-sm">Hapus</button> ';

                return $btn;
            })
            ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi adalah html 
            ->make(true);
    }

    public function create()
    {
        $breadcrumb = (object) [
            'title' => 'Tambah Supplier',
            'list' => ['Home', 'Supplier', 'Tambah Supplier']
        ];

        $page = (object) [
            'title' => 'Tambah Supplier Baru',
        ];

        $activateMenu = 'supplier'; //set menu yang sedang aktif

        return view('supplier.create', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activateMenu' => $activateMenu]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'supplier_code' => 'required|max:10|unique:m_supplier,supplier_code',
            'supplier_nama' => 'required|max:100',
            'email' => 'required|email|unique:m_supplier,email',
            'no_telp' => 'required|string|max:15',
            'address' => 'required|string|max:100'
        ]);

        SupplierModel::create(attributes: [
            'supplier_code' => $request->supplier_code,
            'supplier_nama' => $request->supplier_nama,
            'email' => $request->email,
            'no_telp' => $request->no_telp,
            'address' => $request->address
        ]);

        return redirect('/supplier')->with('success', 'Supplier Berhasil Dibuat.');
    }

    public function show($supplier_id)
    {
        $breadcrumb = (object) [
            'title' => 'Detail Supplier',
            'list' => ['Home', 'Supplier', 'Detail Supplier']
        ];

        $page = (object) [
            'title' => 'Detail Supplier',
        ];

        $activateMenu = 'supplier'; //set menu yang sedang aktif

        $supplier = SupplierModel::find($supplier_id);

        return view('supplier.show', ['breadcrumb' => $breadcrumb, 'page' => $page, 'supplier' => $supplier, 'activateMenu' => $activateMenu]);
    }

    public function edit(string $supplier_id)
    {
        $breadcrumb = (object) [
            'title' => 'Edit Supplier',
            'list' => ['Home', 'Supplier', 'Edit Supplier']
        ];

        $page = (object) [
            'title' => 'Edit Supplier',
        ];

        $activateMenu = 'supplier'; //set menu yang sedang aktif

        $supplier = SupplierModel::find($supplier_id);

        return view('supplier.edit', ['breadcrumb' => $breadcrumb, 'page' => $page, 'supplier' => $supplier, 'activateMenu' => $activateMenu]);
    }

    public function update(Request $request, $supplier_id)
    {
        $supplier = SupplierModel::find($supplier_id);
        $request->validate([
            'supplier_code' => 'required|max:10|unique:m_supplier,supplier_code,' . $supplier_id . ',supplier_id',
            'supplier_nama' => 'required|max:100',
            'email' => 'required|email|unique:m_supplier,email' . $supplier_id . ',supplier_id',
            'no_telp' => 'required|string|max:15',
            'address' => 'required|string|max:100'
        ]);

        $supplier->update([
            'supplier_code' => $request->supplier_code,
            'supplier_nama' => $request->supplier_nama,
            'email' => $request->email,
            'no_telp' => $request->no_telp,
            'address' => $request->address
        ]);

        return redirect('/supplier')->with('success', 'Supplier Berhasil Diupdate.');
    }

    public function destroy($supplier_id)
    {
        $check = SupplierModel::find($supplier_id);
        if (!$check) {
            return redirect('/supplier')->with('error', 'Data supplier tidak ditemukan');
        }

        try {
            SupplierModel::destroy($supplier_id);
            return redirect('/supplier')->with('success', 'Data supplier berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect('/supplier')->with('error', 'Data supplier gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
        }
    }

    public function cek_code(Request $request)
    {
        $supplierKode = $request->input('supplier_code');
        $id = $request->input('id');

        $query = SupplierModel::where('supplier_code', $supplierKode);

        // Kalau ada id (berarti sedang edit), exclude dirinya sendiri
        if ($id) {
            $query->where('supplier_id', '!=', $id); // perhatikan: kolom 'supplier_id'!
        }

        $exists = $query->exists();

        return response()->json(!$exists);
    }

    public function create_ajax()
    {
        return view('supplier.create_ajax');
    }

    public function store_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'supplier_code' => 'required|max:10|unique:m_supplier,supplier_code',
                'supplier_nama' => 'required|max:100',
                'email' => 'required|email|unique:m_supplier,email',
                'no_telp' => 'required|string|max:15',
                'address' => 'required|string|max:100'
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors(),
                ], 422);
            }

            $existing = SupplierModel::where('supplier_code', $request->supplier_code)->first();
            if ($existing) {
                return response()->json([
                    'status' => false,
                    'message' => 'Kode supplier sudah ada.',
                ], 409);
            }

            SupplierModel::create($request->all());
            return response()->json([
                'status' => true,
                'message' => 'Data supplier berhasil disimpan',
            ]);
        }
    }
    public function edit_ajax(string $id)
    {
        $supplier = SupplierModel::find($id);
        return view('supplier.edit_ajax', ['supplier' => $supplier]);
    }

    public function update_ajax(Request $request, string $id)
    {
        $supplier = SupplierModel::find($id);
        $rules = [
            'supplier_code' => 'required|max:10|unique:m_supplier,supplier_code,' . $id . ',supplier_id',
            'supplier_nama' => 'required|max:100',
            'email' => 'required|email|unique:m_supplier,email,' . $id . ',supplier_id',
            'no_telp' => 'required|string|max:15',
            'address' => 'required|string|max:100'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi Gagal',
                'msgField' => $validator->errors(),
            ], 422);
        }

        $supplier->update([
            'supplier_code' => $request->supplier_code,
            'supplier_nama' => $request->supplier_nama,
            'email' => $request->email,
            'no_telp' => $request->no_telp,
            'address' => $request->address,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Data Supplier berhasil diupdate',
        ]);
    }

    public function confirm_ajax(string $id)
    {
        $supplier = SupplierModel::find($id);

        return view('supplier.confirm_ajax', ['supplier' => $supplier]);
    }

    public function delete_ajax(Request $request, $id)
    {

        if ($request->ajax() || $request->wantsJson()) {
            $supplier = SupplierModel::find($id);
            if ($supplier) {
                $supplier->delete();
                return response()->json([
                    'status'  => true,
                    'message' => 'Data berhasil dihapus'
                ]);
            } else {
                return response()->json([
                    'status'  => false,
                    'message' => 'Data tidak ditemukan'
                ]);
            }
        }
        return redirect('/');
    }
}
