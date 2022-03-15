<?php

use App\Models\EstadoRepublica;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDelegacionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('delegacions', function (Blueprint $table) {
            $table->id();
            $table->string('delegacion' , 40);
            $table->foreignIdFor(EstadoRepublica::class, 'id_estado');
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
        Schema::dropIfExists('delegacions');
    }
}
