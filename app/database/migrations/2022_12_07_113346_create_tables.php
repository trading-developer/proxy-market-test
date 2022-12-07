<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('providers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->tinyInteger('status')->default(\App\Models\Provider::STATUS_ACTIVE);
            $table->string('title');
            $table->string('code')->unique();
            $table->string('url');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable();
            $table->softDeletes();

            $table->foreignId('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });

        Schema::create('proxies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('port');
            $table->tinyInteger('status')->default(\App\Models\Proxy::STATUS_ACTIVE);
            $table->string('ip');
            $table->string('login');
            $table->string('password');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable();
            $table->softDeletes();

            $table->foreignId('provider_id')
                ->references('id')
                ->on('providers')
                ->onDelete('cascade');

            $table->unique(['provider_id', 'login', 'password']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('proxies');
        Schema::dropIfExists('providers');
    }
};
