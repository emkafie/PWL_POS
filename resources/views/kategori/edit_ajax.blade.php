@empty($kategori)
<div id="modal-master" class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Kesalahan</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                aria-hidden="true"></button>
        </div>
        <div class="modal-body">
            <div class="alert alert-danger">
                <h5><i class="icon fas fa-ban"></i> Kesalahan!!!</h5>
                Data yang anda cari tidak ditemukan
            </div>
            <a href="{{ url('/kategori') }}" class="btn btn-warning">Kembali</a>
        </div>
    </div>
</div>
@else
<form action="{{ url('/kategori/' . $kategori->kategori_id.'/update_ajax') }}" method="POST" id="form-edit">
    @csrf
    @method('PUT')
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Data Kategori</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-
                    label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Kategori Kode</label>
                    <input value="{{ $kategori->kategori_kode }}" type="text" name="kategori_kode"
                        id="kategori_kode" class="form-control" required>
                    <small id="error-kategori_kode" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Nama Kategori</label>
                    <input value="{{ $kategori->kategori_nama }}" type="text" name="kategori_nama" id="kategori_nama"
                        class="form-control" required>
                    <small id="error-kategori_nama" class="error-text form-text text-danger"></small>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" data-bs-dismiss="modal" class="btn btn-warning">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
            <input type="hidden" name="id" id="kategori_id" value="{{ $kategori->kategori_id }}">
        </div>
    </div>
</form>
<script>
    $(document).ready(function() {
        $("#form-edit").validate({
            rules: {
                kategori_kode: {
                    required: true,
                    minlength: 3,
                    maxlength: 10,
                    remote: {
                        url: "{{ url('kategori/cek_kode') }}",
                        type: "post",
                        data: {
                            kategori_kode: function() {
                                return $("#kategori_kode").val(); // pastikan id input kategori_kode sesuai
                            },
                            id: function() { // Kirim ID saat edit!
                                return $("#kategori_id").val();
                            },
                            _token: "{{ csrf_token() }}" // CSRF wajib di Laravel
                        }
                    }
                },
                kategori_nama: {
                    required: true,
                    minlength: 3,
                    maxlength: 100
                },
            },
            messages: {
                kategori_kode: {
                    remote: "Kode kategori Sudah Digunakan"
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
                            dataKategori.ajax.reload();
                        } else {
                            $('.error-text').text('');
                            $.each(response.msgField, function(prefix, val) {
                                $('#error-' + prefix).text(val[0]);
                                $('#' + prefix).addClass('is-invalid');
                            });
                            Swal.fire({
                                icon: 'error',
                                title: 'Terjadi Kesalahan',
                                text: response.message
                            });
                        }
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                        Swal.fire({
                            icon: 'error',
                            title: 'Terjadi Kesalahan',
                            text: 'Coba Cek Kembali Inputan'
                        });
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