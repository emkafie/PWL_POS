@extends('layouts.template')

@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">{{ $page->title }}</h3>
        <div class="card-tools">
            <a href="{{ url('/barang/export_excel') }}" class="btn btn-sm mt-1 btn-primary"><i class="bi bi-file-earmark-excel"></i> Export Barang</a>
            <button onclick="modalAction(`{{ url('barang/create_ajax') }}`)" class="btn btn-sm btn-success mt-1">Tambah Ajax</button>
            <button onclick="modalAction(`{{ url('barang/import') }}`)" class="btn btn-sm btn-info mt-1">Import Barang</button>
        </div>
    </div>
    <div class="card-body">
        @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        <div class="form-group row">
            <div class="col-md-12">
                <label class="col-1 control-label col-form-label">Filter:</label>
                <div class="col-3">
                    <select class="form-control" name="kategori_id" id="kategori_id" required>
                        <option value="">- Semua -</option>
                        @foreach ($kategori as $item)
                        <option value="{{ $item->kategori_id }}">{{ $item->kategori_nama }}</option>
                        @endforeach
                    </select>
                    <small class="form-text text-muted">Barang</small>
                </div>
            </div>
        </div>
        <table class="table table-bordered table-striped table-hover table-sm" id="table_barang">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Kategori Barang</th>
                    <th>Kode Barang</th>
                    <th>Nama Barang</th>
                    <th>Harga Beli</th>
                    <th>Harga Jual</th>
                    <th>Aksi</th>
                </tr>
            </thead>
        </table>
    </div>
</div>
<div id="myModal" class="modal fade animate shake" tabindex="-1"
    role="dialog" data-backdrop="static" data-keyboard="false" data-width="75%" aria-hidden="true"></div>

@endsection

@push('css')
@endpush

@push('js')
<script>
    function modalAction(url = '') {
        $('#myModal').load(url, function() {
            $('#myModal').modal('show');
        });
    }

    var dataBarang;

    $(document).ready(function() {
        dataBarang = $('#table_barang').DataTable({
            // serverSide: true, jika ingin menggunakan server side processing 
            serverSide: true,
            ajax: {
                "url": "{{ url('barang/list') }}",
                "dataType": "json",
                "type": "POST",
                "data": function(d) {
                    d.kategori_id = $('#kategori_id').val();
                }
            },
            columns: [{ // nomor urut dari laravel datatable addIndexColumn() 
                data: "DT_RowIndex",
                className: "text-center",
                orderable: false,
                searchable: false
            }, {
                data: "kategori.kategori_nama",
                className: "",
                // orderable: true, jika ingin kolom ini bisa diurutkan  
                orderable: false,
                // searchable: true, jika ingin kolom ini bisa dicari 
                searchable: false
            }, {
                data: "barang_kode",
                className: "",
                orderable: true,
                searchable: true
            }, {
                data: "barang_nama",
                className: "",
                orderable: true,
                searchable: true
            }, {
                data: "harga_beli",
                className: "",
                orderable: true,
                searchable: true,
                render: function(data, type, row) {
                    return new Intl.NumberFormat('id-ID', {
                        style: 'currency',
                        currency: 'IDR',
                        minimumFractionDigits: 0
                    }).format(data);
                }
            }, {
                data: "harga_jual",
                className: "",
                orderable: true,
                searchable: true,
                render: function(data, type, row) {
                    return new Intl.NumberFormat('id-ID', {
                        style: 'currency',
                        currency: 'IDR',
                        minimumFractionDigits: 0
                    }).format(data);
                }
            }, {
                data: "aksi",
                className: "",
                orderable: false,
                searchable: false
            }, ]
        });

        $('#kategori_id').on('change', function() {
            dataBarang.ajax.reload();
        });
    });
</script>
@endpush