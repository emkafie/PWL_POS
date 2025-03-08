<?php

namespace App\Http\Controllers;

use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $user = UserModel::all();
        return view('user', ['data' => $user]);
    }

    public function tambah()
    {
        return view('user_tambah');
    }

    public function tambah_simpan(Request $request)
    {
        UserModel::create([
            'username' => $request->username,
            'nama' => $request->nama,
            'password' => Hash::make('$request->password'),
            'level_id' => $request->level_id,
        ]);

        return redirect('/user');
    }

    public function ubah($id)
    {
        $user = UserModel::find($id);
        return view('user_ubah', ['data' => $user]);
    }

    public function ubah_simpan($id, Request $request)
    {
        $user = UserModel::find($id);

        $user->username = $request->username;
        $user->nama = $request->nama;
        $user->password = Hash::make('$request->password');
        $user->level_id = $request->level_id;

        $user->save();

        return redirect('/user');
    }

    public function hapus($id) {
        $user = UserModel::find($id);
        $user->delete();

        return redirect('/user');
    }
    // $user = UserModel::create(
    //     [
    //         'username' => 'manager11',
    //         'nama' => 'Manager11',
    //         'password' => Hash::make('12345'),
    //         'level_id' => 2
    //     ]
    // );
    // $user->username = 'manager12';

    // $user->save();

    // $user->wasChanged(); // true
    // $user->wasChanged('username'); // true
    // $user->wasChanged(['username', 'level_id']); // true
    // $user->wasChanged('name'); // false
    // dd($user->wasChanged(['name', 'username'])); // true
    // $user->isDirty(); //true
    // $user->isDirty('username'); //true
    // $user->isDirty('name'); //false
    // $user->isDirty(['name', 'username']); //true

    // $user->isClean(); //true
    // $user->isClean('username'); //false
    // $user->isClean('name'); //true
    // $user->isClean(['name', 'username']); //false


    // $user->isDirty(); //false
    // $user->isClean(); //true
    // dd($user->isDirty);

    // return view('user', ['data' => $user]);

    // $user = UserModel::firstOrCreate(
    //     [
    //         'username' => 'manager22',
    //         'nama' => 'Manager Dua Dua',
    //         'password' => Hash::make('12345'),
    //         'level_id' => 2
    //     ],
    // );
    // $user = UserModel::where('level_id', 2)->count();
    // $user = UserModel::where('username', 'manager9')->firstOrFail();

    // $user = UserModel::findOrFail(1);
    // $user = UserModel::findOr(20, ['username', 'nama'], function () {
    //     abort(404);
    // });

    // $user = UserModel::firstWhere('level_id', 1);
    // return view('user', ['data' => $user]);

    // $user = UserModel::where('level_id', 1)->first();
    // return view('user', ['data' => $user]);

    // $user = UserModel::find(1);
    // return view('user', ['data' => $user]);

    // $user = UserModel::all();
    // return view('user', ['data' => $user]);

    // $data = [
    //     'username' => 'manager_tiga',
    //     'nama' => 'Manager 3',
    //     'password' => Hash::make('12345'),
    //     'level_id' => 2,
    // ];
    // UserModel::create($data);

    // $user = UserModel::all();
    // return view('user', ['data' => $user]);
    // $data = [
    //     'nama' => 'Pelanggan Pertama'
    // ];
    // UserModel::where('username', 'customer-1')->update($data);

    // }
}
