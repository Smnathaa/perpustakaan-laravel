<?php
namespace Tests\Feature;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\{User,Category,Book};
class LibraryTest extends TestCase {
 use RefreshDatabase;
 private function payload(): array { return ['code'=>'B001','title'=>'Belajar Laravel','author'=>'Sidiq','year'=>2025,'category_id'=>Category::create(['name'=>'Teknologi'])->id,'shelf'=>'A1','quantity'=>4]; }
 public function test_guest_cannot_access_catalog(): void { $this->get('/books')->assertRedirect('/login'); $this->post('/books',[])->assertRedirect('/login'); }
 public function test_admin_can_manage_books_and_print_report(): void {
  $this->actingAs(User::factory()->create()); $data=$this->payload();
  $this->post('/books',$data)->assertRedirect('/books'); $this->assertDatabaseHas('books',['code'=>'B001']);
  $book=Book::first(); $this->get('/')->assertOk(); $this->get('/books/'.$book->id)->assertOk(); $this->get('/books/'.$book->id.'/edit')->assertOk();
  $this->get('/books?q=Laravel')->assertSee('Belajar Laravel');
  $this->put('/books/'.$book->id,array_merge($data,['quantity'=>8]))->assertRedirect('/books');
  $this->assertDatabaseHas('books',['id'=>$book->id,'quantity'=>8]); $this->get('/laporan')->assertOk()->assertSee('Belajar Laravel');
  $this->delete('/books/'.$book->id)->assertRedirect('/books'); $this->assertDatabaseMissing('books',['id'=>$book->id]);
 }
 public function test_invalid_stock_and_duplicate_code_are_rejected(): void {
  $this->actingAs(User::factory()->create()); $data=$this->payload(); Book::create($data);
  $this->post('/books',array_merge($data,['quantity'=>-1]))->assertSessionHasErrors(['code','quantity']);
 }
 public function test_used_category_cannot_be_deleted(): void {
  $this->actingAs(User::factory()->create()); $data=$this->payload(); Book::create($data);
  $this->delete('/categories/'.$data['category_id'])->assertSessionHasErrors('category'); $this->assertDatabaseCount('categories',1);
 }
 public function test_login_and_logout(): void {
  User::factory()->create(['email'=>'admin@example.test','password'=>bcrypt('long-password')]);
  $this->post('/login',['email'=>'admin@example.test','password'=>'incorrect'])->assertSessionHasErrors('email');
  $this->post('/login',['email'=>'admin@example.test','password'=>'long-password'])->assertRedirect('/'); $this->assertAuthenticated();
  $this->post('/logout')->assertRedirect('/login'); $this->assertGuest();
 }
 public function test_category_filter_does_not_leak_other_results(): void {
  $this->actingAs(User::factory()->create()); $data=$this->payload(); Book::create($data);
  $other=Category::create(['name'=>'Sastra']);
  $this->get('/books?category='.$other->id.'&q=Laravel')->assertDontSee('Belajar Laravel');
 }
}
