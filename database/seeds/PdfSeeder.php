<?php

use Illuminate\Database\Seeder;

class PdfSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i = 60; $i > 0; $i--) {
            DB::table('pdfs')->insert([
                'url' => "storage/pdfs/Windows_7_beginners.pdf",
                'thumb' => "img/pdfs/Windows_7_beginners.jpg",
            ]);
        }
    }
}
