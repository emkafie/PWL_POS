<?php

namespace App\Http\Controllers;

use App\Models\KategoriModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class KategoriController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar Kategori',
            'list' => ['Home', 'Kategori']
        ];

        $page = (object) [
            'title' => 'Daftar kategori yang terdaftar dalam sistem',
        ];

        $activateMenu = 'kategori'; //set menu yang sedang aktif

        $kategori = KategoriModel::all();

        return view('kategori.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'kategori' => $kategori, 'activateMenu' => $activateMenu]);
    }

    public function list(Request $request)
    {
        $kategories = KategoriModel::select('kategori_id', 'kategori_kode', 'kategori_nama');

        if ($request->kategori_kode) {
            $kategories->where('kategori_kode', $request->kategori_kode);
        }

        return DataTables::of($kategories)
            // menambahkan kolom index / no urut (default nama kolom: DT_RowIndex) 
            ->addIndexColumn()
            ->addColumn('aksi', function ($kategori) {  // menambahkan kolom aksi 
                // $btn  = '<a href="' . url('/kategori/' . $kategori->kategori_id) . '" class="btn btn-info btn-sm">Detail</a> ';
                // $btn .= '<a href="' . url('/kategori/' . $kategori->kategori_id . '/edit') . '" class="btn btn-warning btn-sm">Edit</a> ';
                // $btn .= '<form class="d-inline-block" method="POST" action="' .
                //     url('/kategori/' . $kategori->kategori_id) . '">'
                //     . csrf_field() . method_field('DELETE') .
                //     '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakin menghapus data ini?\');">Hapus</button></form>';
                $btn = '<button onclick="modalAction(\'' . url('/kategori/' . $kategori->kategori_id .
                    '/show_ajax') . '\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/kategori/' . $kategori->kategori_id .
                    '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/kategori/' . $kategori->kategori_id .
                    '/delete_ajax') . '\')"  class="btn btn-danger btn-sm">Hapus</button> ';

                return $btn;
            })
            ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi adalah html 
            ->make(true);
    }

    public function create()
    {
        $breadcrumb = (object) [
            'title' => 'Tambah Kategori',
            'list' => ['Home', 'Kategori', 'Tambah Kategori']
        ];

        $page = (object) [
            'title' => 'Tambah Kategori Baru',
        ];

        $activateMenu = 'kategori'; //set menu yang sedang aktif

        return view('kategori.create', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activateMenu' => $activateMenu]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'kategori_kode' => 'required|max:10|unique:m_kategori,kategori_kode',
            'kategori_nama' => 'required|max:100',
        ]);

        KategoriModel::create(attributes: [
            'kategori_kode' => $request->kategori_kode,
            'kategori_nama' => $request->kategori_nama,
        ]);

        return redirect('/kategori')->with('success', 'Kategori Berhasil Dibuat.');
    }

    public function show($kategori_id)
    {
        $breadcrumb = (object) [
            'title' => 'Detail Kategori',
            'list' => ['Home', 'Kategori', 'Detail Kategori']
        ];

        $page = (object) [
            'title' => 'Detail Kategori',
        ];

        $activateMenu = 'kategori'; //set menu yang sedang aktif

        $kategori = KategoriModel::find($kategori_id);

        return view('kategori.show', ['breadcrumb' => $breadcrumb, 'page' => $page, 'kategori' => $kategori, 'activateMenu' => $activateMenu]);
    }

    public function edit(string $kategori_id)
    {
        $breadcrumb = (object) [
            'title' => 'Edit Kategori',
            'list' => ['Home', 'Kategori', 'Edit Kategori']
        ];

        $page = (object) [
            'title' => 'Edit Kategori',
        ];

        $activateMenu = 'kategori'; //set menu yang sedang aktif

        $kategori = KategoriModel::find($kategori_id);

        return view('kategori.edit', ['breadcrumb' => $breadcrumb, 'page' => $page, 'kategori' => $kategori, 'activateMenu' => $activateMenu]);
    }

    public function update(Request $request, $kategori_id)
    {
        $kategori = KategoriModel::find($kategori_id);
        $request->validate([
            'kategori_kode' => 'required|max:10|unique:m_kategori,kategori_kode,' . $kategori_id . ',kategori_id',
            'kategori_nama' => 'required|max:100',
        ]);

        $kategori->update([
            'kategori_kode' => $request->kategori_kode,
            'kategori_nama' => $request->kategori_nama,
        ]);

        return redirect('/kategori')->with('success', 'Kategori Berhasil Diupdate.');
    }

    public function destroy($kategori_id)
    {
        $check = KategoriModel::find($kategori_id);
        if (!$check) {
            return redirect('/kategori')->with('error', 'Data kategori tidak ditemukan');
        }

        try {
            KategoriModel::destroy($kategori_id);
            return redirect('/kategori')->with('success', 'Data kategori berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect('/kategori')->with('error', 'Data kategori gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
        }
    }

    public function cek_kode(Request $request)
    {
        $kategoriKode = $request->input('kategori_kode');
        $id = $request->input('id');

        $query = KategoriModel::where('kategori_kode', $kategoriKode);

        // Kalau ada id (berarti sedang edit), exclude dirinya sendiri
        if ($id) {
            $query->where('kategori_id', '!=', $id); // perhatikan: kolom 'kategori_id'!
        }

        $exists = $query->exists();

        return response()->json(!$exists);
    }

    public function create_ajax()
    {
        return view('kategori.create_ajax');
    }

    public function store_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'kategori_kode' => 'required|max:10|unique:m_kategori,kategori_kode',
                'kategori_nama' => 'required|max:100',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors(),
                ], 422);
            }

            $existing = KategoriModel::where('kategori_kode', $request->kategori_kode)->first();
            if ($existing) {
                return response()->json([
                    'status' => false,
                    'message' => 'Kode kategori sudah ada.',
                ], 409);
            }

            KategoriModel::create($request->all());
            return response()->json([
                'status' => true,
                'message' => 'Data kategori berhasil disimpan',
            ]);
        }
    }
    public function edit_ajax(string $id)
    {
        $kategori = KategoriModel::find($id);
        return view('kategori.edit_ajax', ['kategori' => $kategori]);
    }

    public function update_ajax(Request $request, string $id)
    {
        $kategori = KategoriModel::find($id);
        $rules = [
            'kategori_kode' => 'required|max:10|unique:m_kategori,kategori_kode,' . $id . ',kategori_id',
            'kategori_nama' => 'required|max:100',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi Gagal',
                'msgField' => $validator->errors(),
            ], 422);
        }

        $kategori->update([
            'kategori_kode' => $request->kategori_kode,
            'kategori_nama' => $request->kategori_nama,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Data Kategori berhasil diupdate',
        ]);
    }

    public function confirm_ajax(string $id)
    {
        $kategori = KategoriModel::find($id);

        return view('kategori.confirm_ajax', ['kategori' => $kategori]);
    }

    public function delete_ajax(Request $request, $id)
    {

        if ($request->ajax() || $request->wantsJson()) {
            $kategori = KategoriModel::find($id);
            if ($kategori) {
                $kategori->delete();
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
