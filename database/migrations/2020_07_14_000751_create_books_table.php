<?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    class CreateBooksTable extends Migration
    {
        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up()
        {
            Schema::create('books', function (Blueprint $table) {
                $table->id();
                $table->string('title');
                $table->longText('description');
                $table->char('ISBN', 13);
                $table->integer('author_id')->unsigned();
                $table->timestamps();

                $table->foreign('author_id')->references('id')->on('authors')->onDelete('cascade');

            });
        }

        /**
         * Reverse the migrations.
         *
         * @return void
         */
        public function down()
        {
            Schema::dropIfExists('books');
        }
    }
