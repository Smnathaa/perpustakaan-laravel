<?php
namespace App\Http\Controllers;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Database\QueryException;
class CategoryController extends Controller {
 public function index() { return view('categories.index',['categories'=>Category::withCount('books')->orderBy('name')->get()]); }
 public function store(Request $r) { Category::create($r->validate(['name'=>'required|string|max:255|unique:categories,name'])); return back()->with('success','Kategori ditambahkan.'); }
 public function update(Request $r,Category $category) { $category->update($r->validate(['name'=>['required','string','max:255',Rule::unique('categories')->ignore($category)]])); return back()->with('success','Kategori diperbarui.'); }
 public function destroy(Category $category) {
  if ($category->books()->exists()) return back()->withErrors(['category'=>'Kategori masih digunakan oleh buku. Pindahkan bukunya terlebih dahulu.']);
  try { $category->delete(); } catch (QueryException $e) { if (str_starts_with((string)$e->getCode(),'23')) return back()->withErrors(['category'=>'Kategori masih digunakan oleh buku.']); throw $e; }
  return back()->with('success','Kategori dihapus.');
 }
}
