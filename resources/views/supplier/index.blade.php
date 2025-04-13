@extends('layouts.template')

@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">{{ $page->title }}</h3>
        <div class="card-tools">
            <a href="{{ url('supplier/export_pdf') }}" class="btn btn-sm btn-warning"><i class="bi bi-file-pdf"></i> Export Supplier</a>
            <a href="{{ url('supplier/export_excel') }}" class="btn btn-sm mt-1 btn-primary"><i class="bi bi-file-earmark-excel"></i> Export Supplier</a>
            <a class="btn btn-sm btn-primary mt-1" href="{{ url('supplier/create') }}">Tambah</a>
            <button onclick="modalAction(`{{ url('supplier/create_ajax') }}`)" class="btn btn-sm btn-success mt-1">Tambah Ajax</button>
            <button onclick="modalAction(`{{ url('supplier/import') }}`)" class="btn btn-sm btn-info mt-1">Import Supplier</button>
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
                    <select class="form-control" name="supplier_code" id="supplier_code" required>
                        <option value="">- Semua -</option>
                        @foreach ($supplier as $item)
                        <option value="{{ $item->supplier_code }}">{{ $item->supplier_nama }}</option>
                        @endforeach
                    </select>
                    <small class="form-text text-muted">Data Supplier</small>
                </div>
            </div>
        </div>
        <table class="table table-bordered table-striped table-hover table-sm" id="table_supplier">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Kode Supplier</th>
                    <th>Nama Supplier</th>
                    <th>Email</th>
                    <th>No. Telp</th>
                    <th>Alamat</th>
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

    var dataSupplier;
    $(document).ready(function() {
        dataSupplier = $('#table_supplier').DataTable({
            // serverSide: true, jika ingin menggunakan server side processing 
            serverSide: true,
            ajax: {
                "url": "{{ url('supplier/list') }}",
                "dataType": "json",
                "type": "POST",
                "data": function(d) {
                    d.level_id = $('#supplier_id').val();
                }
            },
            columns: [{ // nomor urut dari laravel datatable addIndexColumn() 
                data: "DT_RowIndex",
                className: "text-center",
                orderable: false,
                searchable: false
            }, {
                data: "supplier_code",
                className: "",
                // orderable: true, jika ingin kolom ini bisa diurutkan  
                orderable: true,
                // searchable: true, jika ingin kolom ini bisa dicari 
                searchable: true
            }, {
                data: "supplier_nama",
                className: "",
                orderable: true,
                searchable: true
            }, {
                data: "email",
                className: "",
                orderable: false,
                searchable: false
            }, {
                data: "no_telp",
                className: "",
                orderable: false,
                searchable: false
            }, {
                data: "address",
                className: "",
                orderable: false,
                searchable: false
            }, {
                data: "aksi",
                className: "",
                orderable: false,
                searchable: false
            }]
        });

        $('#kategori_id').on('change', function() {
            dataSupplier.ajax.reload();
        });
    });
</script>
@endpush