<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\{Category,Book};
class DatabaseSeeder extends Seeder {
 public function run(): void {
  foreach(['Teknologi','Sains','Sastra','Pendidikan','Sejarah'] as $name) Category::firstOrCreate(['name'=>$name]);
  $category=Category::where('name','Teknologi')->first();
  foreach(['Dasar Pemrograman Web','Pengantar Basis Data','Algoritma dan Pemrograman'] as $i=>$title) {
   Book::firstOrCreate(['code'=>'DEMO-00'.($i+1)],['title'=>$title,'author'=>'Penulis Contoh','publisher'=>'Penerbit Contoh','year'=>2025,'category_id'=>$category->id,'shelf'=>'A-01','quantity'=>5+$i,'description'=>'Data contoh untuk demonstrasi. Silakan ganti dengan koleksi perpustakaan.']);
  }
 }
}
