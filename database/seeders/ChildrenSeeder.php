<?php

namespace Database\Seeders;

use App\Models\Child;
use Illuminate\Database\Seeder;

class ChildrenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $children = [
            [
                'name' => 'Andi Wijaya',
                'nickname' => 'Andi',
                'birth_date' => '2010-05-15',
                'gender' => 'laki-laki',
                'background_story' => 'Andi datang ke panti asuhan setelah orang tuanya meninggal dalam kecelakaan. Dia adalah anak yang ceria dan suka bermain sepak bola.',
                'education_level' => 'smp',
                'school_name' => 'SMP Negeri 1 Jakarta',
                'health_condition' => 'Sehat',
                'status' => 'aktif',
                'entry_date' => '2015-08-01',
                'notes' => 'Anak yang pintar dan aktif dalam kegiatan olahraga.'
            ],
            [
                'name' => 'Sari Indah',
                'nickname' => 'Sari',
                'birth_date' => '2012-03-22',
                'gender' => 'perempuan',
                'background_story' => 'Sari dititipkan ke panti asuhan karena kondisi ekonomi keluarga yang sulit. Orang tuanya masih hidup namun tidak mampu merawat.',
                'education_level' => 'sd',
                'school_name' => 'SD Negeri 2 Jakarta',
                'health_condition' => 'Sehat',
                'status' => 'aktif',
                'entry_date' => '2017-01-15',
                'notes' => 'Anak yang pendiam namun rajin belajar. Suka menggambar dan membaca.'
            ],
            [
                'name' => 'Budi Santoso',
                'nickname' => 'Budi',
                'birth_date' => '2008-11-08',
                'gender' => 'laki-laki',
                'background_story' => 'Budi adalah anak yatim piatu yang diselamatkan dari jalanan. Dia sangat berbakat dalam bidang musik.',
                'education_level' => 'sma',
                'school_name' => 'SMA Negeri 3 Jakarta',
                'health_condition' => 'Sehat',
                'status' => 'aktif',
                'entry_date' => '2013-06-10',
                'notes' => 'Sangat berbakat dalam musik, bisa bermain gitar dan keyboard.'
            ],
            [
                'name' => 'Maya Putri',
                'nickname' => 'Maya',
                'birth_date' => '2014-07-30',
                'gender' => 'perempuan',
                'background_story' => 'Maya ditemukan di depan panti asuhan saat masih bayi. Tidak diketahui identitas orang tuanya.',
                'education_level' => 'sd',
                'school_name' => 'SD Negeri 4 Jakarta',
                'health_condition' => 'Sehat',
                'status' => 'aktif',
                'entry_date' => '2014-08-01',
                'notes' => 'Anak yang sangat ceria dan suka menyanyi. Mudah bergaul dengan teman-teman.'
            ],
            [
                'name' => 'Rendi Pratama',
                'nickname' => 'Rendi',
                'birth_date' => '2016-02-14',
                'gender' => 'laki-laki',
                'background_story' => 'Rendi diserahkan ke panti asuhan karena orang tuanya meninggal akibat bencana alam.',
                'education_level' => 'tk',
                'school_name' => 'TK Harapan Bangsa',
                'health_condition' => 'Sehat',
                'status' => 'aktif',
                'entry_date' => '2018-03-01',
                'notes' => 'Anak yang masih kecil namun sudah menunjukkan kecerdasan di atas rata-rata.'
            ]
        ];

        foreach ($children as $child) {
            Child::firstOrCreate(['name' => $child['name']], $child);
        }
    }
}