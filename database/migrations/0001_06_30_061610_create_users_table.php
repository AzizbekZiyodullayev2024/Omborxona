<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('role_id')->unsigned();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->string('password_hash');
            $table->bigInteger('warehouse_id')->unsigned()->nullable();
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->comment('Foydalanuvchilar: Tizim adminlari, omborxona adminlari va mahsulot egalari');

            $table->foreign('role_id', 'user_roles')->references('id')->on('roles')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('warehouse_id', 'user_warehouses')->references('id')->on('warehouses')->onDelete('set null')->onUpdate('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};