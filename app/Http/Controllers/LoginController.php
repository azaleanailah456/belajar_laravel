<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Carbon\carbon;


class LoginController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function login()
    {
        return view('dashboard.login');
    }

    public function register()
    {
        return view('dashboard.register');
    }

    public function inputRegister(Request $request)
    {
        $request->validate([
            'name' => 'required|min:4|max:50',
            'email' =>'required',
            'password' =>'required',
            'username' =>'required'
        ]);
        //tambah data ke db bagia table user
        User::create([
        'name' =>$request->name,
        'username' =>$request->username,
        'email' =>$request->email,
        'password' =>Hash::make($request->password),
        
        ]);
        //apabila berhasil maka, bakal diarahin ke halaman login dengan pesan success
        return redirect('/')->with('success', 'Berhasil membuat akun');
    }

    public function auth(Request $request)
    {
        $request->validate([
            'username' => 'required|exists:users,username',
            'password' => 'required',
        ],[
            'username.exists'=>"This user doesen't exists"
        ]);

    $user = $request->only('username', 'password');
    if (Auth::attempt($user)){
        return redirect()->route('todo.index');
    }else{
        return redirect('/')->with('fail', "Gagal login, periksa dan coba lagi!");
    }
}
 
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.create');
    }
    
    public function index()
    {
        //menampilkan halaman awal , semua data
        //cari data todo yang punya user_id nya sama dengan id orang yang login, kalau ketemu datanya di ambil
        $todos = Todo::where([
            ['user_id', '=', Auth::user()->id],
            ['status', '=', 0],
            ])->get();
        //tampilkan file index di folder dashboard dan bawa data dari variable yang namanya todos ke file tersebut
        return view('dashboard.index', compact('todos')); 
    }

    public function complated()
    {
        $todos = Todo::where([
            ['user_id', '=', Auth::user()->id],
            ['status', '=', 1],
            ])->get();

        return view('dashboard.complated', compact('todos'));
    }

    public function updateComplated($id)
    {
        //$id pada parameter mengambil data dari path dinamis {$id}
        //cari data yang memiliki value column id sama dengan data id yg diirim ke route maka update baris data tersebut 
        Todo::where('id', $id)->update([
            'status' => 1,
            'done_time' => Carbon::now(),
        ]);
        
        //kalau halaman berhasil akan diarhain ke halaman list todo yang complated dengan pembritahuan
        return redirect()->route('todo.complated')->with('done', 'Todo sudah selesai di kerjakan');

    }

    public function logout()
    {
        //menghapus history login
        Auth::logout();
        //mengarahakan ke halaman login lagi
        return redirect('/');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //mengirim data ke database (data baru) / menambahkan data baru db

        $request->validate([
            'title' => 'required|min:3',
            'date' => 'required',
            'description' => 'required|min:8', 
        ]);
        //tambah data ke database
        Todo::create([
            'title' => $request->title,
            'description' => $request->description, 
            'date' => $request->date,
            'status' => 0,
            'user_id' => Auth::user()->id,
        ]);
        //redirect apabila berhasil bersama dengan alert-nya
        return redirect()->route('todo.index')->with('successAdd', 'Berhasil menambahkan data ToDo!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\login  $login
     * @return \Illuminate\Http\Response
     */
    public function show(login $login)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\login  $login
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //mena,,pilkan form edit data
        //ambil data dari db yang id nya sama dengan id yg dikirim di route
        $todo = Todo::where('id', $id)->first();

        //lalu tampilkan halaman dari view edit dengan mengirim data yg ada di variable todo
        return view('dashboard.edit', compact('todo'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\login  $login
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //mengubah data di database
        //validasi
        $request->validate([
            'title' => 'required|min:3',
            'date' => 'required',
            'description' => 'required|min:8', 
        ]);

        Todo::where('id', $id)->update([
            'title' => $request->title,
            'description' => $request->description,
            'date' => $request->date,
            'status' => 0,
            'user_id' => Auth::user()->id,
        ]);
        return redirect('/todo/')->with('successUpdate', 'Data berhasil di perbarui!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\login  $login
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //parameter $id akan mengambil data dari dinamis {$id}
        //cari data yg isisan column id nya sma dengan $id yg dikirim ke path dinamis
        //kalau ada, ambil terus hapus datanya
        Todo::where('id', '=', $id)->delete();
        //kalau berhasil bakal dibalikin ke halaman list todo dengan pemberitahuan
        return redirect()->route('todo.index')->with('successDelete', 'Berhasil menghapus data todo!');
    }
}
