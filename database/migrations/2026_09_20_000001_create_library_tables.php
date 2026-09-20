<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
 public function up(): void {
  Schema::create('categories', function(Blueprint $t) { $t->id(); $t->string('name')->unique(); $t->timestamps(); });
  Schema::create('books', function(Blueprint $t) {
   $t->id(); $t->string('code',30)->unique(); $t->string('isbn',20)->nullable()->unique();
   $t->string('title'); $t->string('author'); $t->string('publisher')->nullable();
   $t->unsignedSmallInteger('year'); $t->foreignId('category_id')->constrained()->restrictOnDelete();
   $t->string('shelf',50); $t->unsignedInteger('quantity')->default(0); $t->text('description')->nullable(); $t->timestamps();
  });
 }
 public function down(): void { Schema::dropIfExists('books'); Schema::dropIfExists('categories'); }
};
