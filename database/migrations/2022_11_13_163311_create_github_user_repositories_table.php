<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGithubUserRepositoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('github_user_repositories', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('github_user_id')->unsigned();
            $table->integer('repository_id')->unique();
            $table->string('repository_name');
            $table->string('repository_fullname');
            $table->timestamp('repository_pushed_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('github_user_id')->references('id')->on('github_users');
            $table->index('repository_pushed_at');
            $table->index(['github_user_id', 'repository_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('github_user_repositories');
    }
}
