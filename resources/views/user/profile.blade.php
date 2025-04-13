@extends('layouts.template')

@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">Profile Saya</h3>
        <div class="card-tools">
            <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#updateFotoModal">
                <i class="bi bi-pencil"></i> Ubah Foto
            </button>
        </div>
    </div>
    <div class="card-body">
        @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        <div class="row">
            <div class="col-md-4 text-center">
                <div class="profile-picture">
                    @if($user->foto)
                    <img src="{{ asset('uploads/foto/' . $user->foto) }}" alt="Foto Profil" class="img-thumbnail" width="150">
                    @else
                    <img src="{{ asset('uploads/foto/default.png') }}" alt="Default Foto Profil" class="img-thumbnail" width="150">
                    @endif
                </div>
            </div>
            <div class="col-md-8">
                <table class="table table-bordered">
                    <tr>
                        <th>Nama</th>
                        <td>{{ $user->nama }}</td>
                    </tr>
                    <tr>
                        <th>Username</th>
                        <td>{{ $user->username }}</td>
                    </tr>
                    <tr>
                        <th>Level</th>
                        <td>{{ $user->level->level_nama ?? '-' }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
</div>

<div class="modal fade" id="updateFotoModal" tabindex="-1" aria-labelledby="updateFotoModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateFotoModalLabel">Ubah Foto Profil</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('updateFoto') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="foto">Pilih Foto Baru</label>
                        <input type="file" name="foto" id="foto" class="form-control" accept="image/*" required>
                    </div>
                    <div class="mt-3">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('css')
@endpush

@push('js')
<script>
    // Tambahkan script jika diperlukan
</script>
@endpush