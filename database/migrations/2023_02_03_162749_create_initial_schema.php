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
        Schema::rename('users', 'user');

        Schema::table('personal_access_tokens', function (Blueprint $table) {
            $table->unsignedBigInteger('tokenable_id')->nullable(true)->change();
        });

        Schema::create('tenant', function (Blueprint $table) {
            $table->id()->unsigned();
            $table->bigInteger('primary_user_id')->unsigned()->nullable(false);
            $table->string('title', 255)->nullable(false);
            $table->bigInteger('parent_tenant_id')->unsigned()->nullable(true);
            $table->enum('type', ['enterprise','trial','basic','partner']);
            $table->datetime('created_at')->nullable(false);
            $table->datetime('updated_at')->nullable(false);

            $table->foreign('primary_user_id', 'fk_tenant_primary_user')->references('id')->on('user');
            $table->foreign('parent_tenant_id', 'fk_tenant_parent_tenant')->references('id')->on('tenant');
        });

        Schema::create('member', function (Blueprint $table) {
            $table->id()->unsigned();
            $table->bigInteger('user_id')->unsigned()->nullable(false);
            $table->bigInteger('tenant_id')->unsigned()->nullable(false);
            $table->boolean('is_active')->nullable(false)->default(true);

            $table->foreign('tenant_id', 'fk_member_tenant')->references('id')->on('tenant');
            $table->foreign('user_id', 'fk_member_user')->references('id')->on('user');
            $table->datetime('created_at')->nullable(false);
            $table->datetime('updated_at')->nullable(false);
        });

        Schema::create('legal_entity', function (Blueprint $table) {
            $table->id()->unsigned();
            $table->bigInteger('tenant_id')->unsigned()->nullable(false);
            $table->bigInteger('created_by_member_id')->unsigned()->nullable(false);
            $table->string('title', 255)->nullable(false);
            $table->enum('type', ['llc','corp','501c'])->nullable(false);

            $table->foreign('tenant_id', 'fk_legal_entity_tenant')->references('id')->on('tenant');
            $table->foreign('created_by_member_id', 'fk_legal_entity_created_by_member')->references('id')->on('member');
            $table->datetime('created_at')->nullable(false);
            $table->datetime('updated_at')->nullable(false);
        });

        Schema::create('site', function (Blueprint $table) {
            $table->id()->unsigned();
            $table->bigInteger('tenant_id')->unsigned()->nullable(false);
            $table->bigInteger('created_by_member_id')->unsigned()->nullable(false);
            $table->string('title', 255)->nullable(false);
            $table->string('address_full', 255)->nullable(true);
            $table->decimal('lat', 11, 8)->nullable(true);
            $table->float('lng', 11, 8)->nullable(true);
            $table->bigInteger('legal_entity_id')->unsigned();

            $table->foreign('tenant_id', 'fk_site_tenant')->references('id')->on('tenant');
            $table->foreign('created_by_member_id', 'fk_site_created_by_member')->references('id')->on('member');
            $table->foreign('legal_entity_id', 'fk_site_legal_entity')->references('id')->on('legal_entity');
            $table->datetime('created_at')->nullable(false);
            $table->datetime('updated_at')->nullable(false);
        });

        Schema::create('entity_access', function (Blueprint $table) {
            $table->id()->unsigned();
            $table->enum('entity_type', ['legal_entity','site'])->nullable(false);
            $table->bigInteger('entity_id')->unsigned()->nullable(false);
            $table->bigInteger('member_id')->unsigned()->nullable(false);
            $table->bigInteger('created_by_member_id')->unsigned()->nullable(false);

            $table->foreign('member_id', 'fk_entity_access_member')->references('id')->on('member');
            $table->unique(['member_id','entity_id','entity_type'], 'uc_entity_access_entity_type_id_member');
            $table->datetime('created_at')->nullable(false);
            $table->datetime('updated_at')->nullable(false);
        });

        /*
        Schema::create('task', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
        });
        */
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('entity_access');
        Schema::dropIfExists('site');
        Schema::dropIfExists('legal_entity');
        Schema::dropIfExists('member');
        Schema::dropIfExists('tenant');
    }
};
