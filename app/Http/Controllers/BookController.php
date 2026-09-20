<?php
namespace App\Http\Controllers;
use App\Models\{Book,Category};
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
class BookController extends Controller {
 private function query(Request $r) {
  $v=$r->validate(['q'=>'nullable|string|max:200','category'=>'nullable|integer|exists:categories,id']);
  return Book::with('category')->when($v['q']??null,function($q,$s) {
   $q->where(function($q) use($s) { foreach(['title','author','code','isbn'] as $field) $q->orWhere($field,'like','%'.$s.'%'); });
  })->when($v['category']??null,fn($q,$id)=>$q->where('category_id',$id));
 }
 public function index(Request $r) { return view('books.index',['books'=>$this->query($r)->latest()->paginate(10)->withQueryString(),'categories'=>Category::orderBy('name')->get()]); }
 public function report(Request $r) { return view('books.report',['books'=>$this->query($r)->orderBy('title')->get()]); }
 public function create() { return view('books.form',['book'=>new Book,'categories'=>Category::orderBy('name')->get()]); }
 public function edit(Book $book) { return view('books.form',['book'=>$book,'categories'=>Category::orderBy('name')->get()]); }
 public function show(Book $book) { return view('books.show',['book'=>$book->load('category')]); }
 private function data(Request $r, ?Book $book=null): array {
  return $r->validate([
   'code'=>['required','string','max:30',Rule::unique('books','code')->ignore($book)],
   'isbn'=>['nullable','string','max:20',Rule::unique('books','isbn')->ignore($book)],
   'title'=>'required|string|max:255','author'=>'required|string|max:255','publisher'=>'nullable|string|max:255',
   'year'=>'required|integer|min:1000|max:'.(date('Y')+1),'category_id'=>'required|exists:categories,id',
   'shelf'=>'required|string|max:50','quantity'=>'required|integer|min:0|max:1000000','description'=>'nullable|string|max:5000'
  ],['required'=>':attribute wajib diisi.','unique'=>':attribute sudah digunakan.','integer'=>':attribute harus berupa bilangan bulat.'],
  ['code'=>'Kode buku','title'=>'Judul','author'=>'Penulis','year'=>'Tahun terbit','category_id'=>'Kategori','shelf'=>'Rak','quantity'=>'Jumlah','isbn'=>'ISBN']);
 }
 public function store(Request $r) { Book::create($this->data($r)); return redirect()->route('books.index')->with('success','Buku berhasil ditambahkan.'); }
 public function update(Request $r,Book $book) { $book->update($this->data($r,$book)); return redirect()->route('books.index')->with('success','Buku berhasil diperbarui.'); }
 public function destroy(Book $book) { $book->delete(); return redirect()->route('books.index')->with('success','Buku berhasil dihapus.'); }
}
