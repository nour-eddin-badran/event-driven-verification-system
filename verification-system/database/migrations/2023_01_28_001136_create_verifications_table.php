<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('verifications', function (Blueprint $table) {
            $table->uuid('uuid')->primary();
            $table->string('identity')->index();
            $table->string('type')->index();
            $table->boolean('confirmed')->default(false)->index();
            $table->timestamp('confirmed_at')->nullable();
            $table->boolean('is_expired')->default(false)->index();
            $table->string('code', 8)->index();
            $table->tinyInteger('attempts_count')->default(0);
            $table->text('user_info');
            $table->timestamps();
            $table->index('created_at');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('verifications');
    }
};
