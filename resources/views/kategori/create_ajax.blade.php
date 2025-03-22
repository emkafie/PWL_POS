<form action="{{ url('/kategori/ajax') }}" method="POST" id="form-tambah">
    @csrf
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Data Kategori</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"
                    aria-hidden="true"></button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Kode Kategori</label>
                    <input value="" type="text" name="kategori_kode" id="kategori_kode" class="form-control"
                        required>
                    <small id="error-kategori_kode" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Nama Kategori</label>
                    <input value="" type="text" name="kategori_nama" id="kategori_nama" class="form-control"
                        required>
                    <small id="error-kategori_nama" class="error-text form-text text-danger"></small>
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
        $("#form-tambah").validate({
            rules: {
                kategori_kode: {
                    required: true,
                    minlength: 3,
                    maxlength: 10,
                    remote: {
                        url: "{{ url('kategori/cek_kode') }}",
                        type: "post",
                        data: {
                            level_kode: function() {
                                return $("#kategori_kode").val(); // pastikan id input level_kode sesuai
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
                level_kode: {
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
                            dataLevel.ajax.reload();
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
                        Swal.fire({
                            icon: 'error',
                            title: 'Terjadi Kesalahan',
                            text: 'Coba Cek Inputan!'
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