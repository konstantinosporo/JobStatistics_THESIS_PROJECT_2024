<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCvsTable extends Migration
{
    public function up()
    {
        Schema::create('cvs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('first_name');
            $table->string('last_name');
            $table->date('date_of_birth');
            $table->string('phone_number');
            $table->string('proficiency');
            $table->text('description');
            $table->text('experience');
            $table->string('photo')->nullable(); // Added photo field
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('cvs');
    }
}
