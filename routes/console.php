<?php
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
Artisan::command('library:admin', function() {
 $name=$this->ask('Nama admin'); $email=$this->ask('Email admin'); $password=$this->secret('Kata sandi (minimal 10 karakter)');
 $v=Validator::make(compact('name','email','password'),['name'=>'required|string|max:255','email'=>'required|email|max:255|unique:users,email','password'=>'required|string|min:10']);
 if ($v->fails()) { foreach($v->errors()->all() as $error) $this->error($error); return 1; }
 User::create(['name'=>$name,'email'=>$email,'password'=>Hash::make($password)]); $this->info('Admin berhasil dibuat.');
})->purpose('Membuat akun pengelola perpustakaan');
