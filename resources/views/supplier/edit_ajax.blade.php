@empty($supplier)
<div id="modal-master" class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Kesalahan</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" aria-hidden="true"></button>
        </div>
        <div class="modal-body">
            <div class="alert alert-danger">
                <h5><i class="icon fas fa-ban"></i> Kesalahan!!!</h5>
                Data yang anda cari tidak ditemukan
            </div>
            <a href="{{ url('/supplier') }}" class="btn btn-warning">Kembali</a>
        </div>
    </div>
</div>
@else
<form action="{{ url('/supplier/' . $supplier->supplier_id.'/update_ajax') }}" method="POST" id="form-edit">
    @csrf
    @method('PUT')
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Data Supplier</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-
                    label="Close" aria-hidden="true"></button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Kode Supplier</label>
                    <input value="{{ $supplier->supplier_code }}" type="text" name="supplier_code"
                        id="supplier_code" class="form-control" required>
                    <small id="error-supplier_code" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Nama Supplier</label>
                    <input value="{{ $supplier->supplier_nama }}" type="text" name="supplier_nama" id="supplier_nama"
                        class="form-control" required>
                    <small id="error-supplier_nama" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input value="{{ $supplier->email }}" type="text" name="email" id="email"
                        class="form-control" required>
                    <small id="error-email" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>No. Telp</label>
                    <input value="{{ $supplier->no_telp }}" type="text" name="no_telp" id="no_telp"
                        class="form-control" required>
                    <small id="error-no_telp" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Alamat</label>
                    <input value="{{ $supplier->address }}" type="text" name="address" id="address"
                        class="form-control" required>
                    <small id="error-address" class="error-text form-text text-danger"></small>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" data-bs-dismiss="modal" class="btn btn-warning">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </div>
    </div>
</form>
<script>
    $(document).ready(function() {
        $("#form-edit").validate({
            rules: {
                supplier_kode: {
                    required: true,
                    minlength: 3,
                    maxlength: 10,
                    remote: {
                        url: "{{ url('supplier/cek_kode') }}",
                        type: "post",
                        data: {
                            supplier_kode: function() {
                                return $("#supplier_kode").val(); // pastikan id input level_kode sesuai
                            },
                            id: function() { // Kirim ID saat edit!
                                return $("#supplier_id").val();
                                _token: "{{ csrf_token() }}" // CSRF wajib di Laravel
                            }
                        }
                    },
                    supplier_nama: {
                        required: true,
                        minlength: 3,
                        maxlength: 100
                    },
                    email: {
                        required: true,
                        email: true,
                        minlength: 3,
                        maxlength: 100
                    },
                    no_telp: {
                        required: true,
                        number: true,
                        minlength: 8,
                        maxlength: 15
                    },
                    address: {
                        required: true,
                        minlength: 3,
                        maxlength: 255
                    }
                }
            },
            messages: {
                supplier_kode: {
                    remote: "Kode Kategori Sudah Digunakan"
                }
            },
            submitHandler: function(form) {
                $.ajax({
                    url: form.action,
                    type: form.method,
                    data: $(form).serialize(),
                    success: function(response) {
                        if (response.status) {
                            $('#myModal').modal('hide');
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: response.message
                            });
                            dataSupplier.ajax.reload();
                        } else {
                            $('.error-text').text('');
                            $.each(response.msgField, function(prefix, val) {
                                $('#error-' + prefix).text(val[0]);
                            });
                            Swal.fire({
                                icon: 'error',
                                title: 'Terjadi Kesalahan',
                                text: response.message
                            });
                        }
                    }
                });
                return false;
            },
            errorElement: 'span',
            errorPlacement: function(error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function(element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            }
        });
    });
</script>
@endempty