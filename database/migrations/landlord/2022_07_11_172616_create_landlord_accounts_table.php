<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique()->index();
            $table->string('long_name')->nullable()->default(null);
            $table->string('logo')->nullable();
            $table->integer('total_users')->default(10);
            $table->unsignedBigInteger('blueprint_id')->nullable()->default(null);
            $table->json('database');
            $table->string('mailgun_route')->nullable();
            $table->timestamps();
        });
    }
};

