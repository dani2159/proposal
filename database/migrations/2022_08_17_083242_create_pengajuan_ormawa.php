<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePengajuanOrmawa extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pengajuan_ormawa', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ormawa_id')->constrained('ormawa');;
            $table->string('nama_kegiatan');
            $table->string('jenis_kegiatan');
            $table->string('tema_kegiatan');
            $table->dateTime('tanggal_kegiatan');
            $table->double('total_dana', 8, 2);
            $table->string('lampiran');
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
        Schema::dropIfExists('pengajuan_ormawa');
    }
}
