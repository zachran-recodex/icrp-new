<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('nickname')->nullable();
            $table->string('slug')->unique();
            $table->date('birth_date');
            $table->date('death_date')->nullable();
            $table->string('birth_place');
            $table->string('known_as');
            $table->text('quote')->nullable();
            $table->text('biography');
            $table->string('image')->nullable();
            $table->integer('order')->default(0);
            $table->string('position');
            $table->enum('dewan', ['Directure Excecutive', 'Pengurus', 'Kehormatan', 'Pembina', 'Pengawas', 'Pengurus Harian']);
            $table->timestamps();
        });

        // Membuat tabel untuk kontribusi member
        Schema::create('member_contributions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->text('description');
            $table->integer('order')->default(0);
            $table->timestamps();
        });

        // Membuat tabel untuk warisan pemikiran member
        Schema::create('member_legacies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')->constrained()->cascadeOnDelete();
            $table->text('content');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('member_legacies');
        Schema::dropIfExists('member_contributions');
        Schema::dropIfExists('member');
    }
};
