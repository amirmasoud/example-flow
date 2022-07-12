<?php

use Domain\Users\Models\User;
use Domain\Sites\Enums\RamUnitEnum;
use Domain\Sites\Enums\DiskUnitEnum;
use Domain\Sites\Enums\OsFlavorEnum;
use Domain\Sites\Enums\DiskTypeEnum;
use Illuminate\Support\Facades\Schema;
use Domain\Sites\Enums\ServerStatusEnum;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('servers', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->constrained();
            $table->string('name');
            $table->unsignedBigInteger('price')->default(0);
            $table->ipAddress('ip')->default('127.0.0.1');
            $table->string('port')->default(80);
            $table->string('ram')->default(1);
            $table->string('ram_unit')->default(RamUnitEnum::GB->value);
            $table->string('cpu')->default(1);
            $table->string('disk')->default(1);
            $table->string('disk_type')->default(DiskTypeEnum::SSD->value);
            $table->string('disk_unit')->default(DiskUnitEnum::GB->value);
            $table->string('os')->default(OsFlavorEnum::ALPINE->value);
            $table->string('os_version')->default('0.0.0');
            $table->string('status')->default(ServerStatusEnum::OFFLINE->value);
            $table->string('notes')->nullable();
            // Polymorph tags with Spatie/laravel-tags
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('servers');
    }
};
