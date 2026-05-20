<?php

namespace Database\Seeders;

use App\Models\AssessmentGroup;
use App\Models\AssessmentOption;
use App\Models\AssessmentRule;
use App\Models\AssessmentSubGroup;
use Illuminate\Database\Seeder;

class AssessmentSeeder extends Seeder
{
    public function run(): void
    {
        // ─── GROUP 1: Kulit Kaki ────────────────────────────────────────
        $group1 = AssessmentGroup::create([
            'title'       => 'Kulit Kaki',
            'slug'        => 'kulit-kaki',
            'description' => 'Penilaian kondisi kulit pada kaki kiri dan kanan',
            'icon'        => null,
            'order'       => 1,
        ]);

        $sub1a = AssessmentSubGroup::create([
            'assessment_group_id' => $group1->id,
            'title'               => 'Kaki Kiri',
            'description'         => 'Kondisi kulit pada kaki kiri',
            'order'               => 1,
        ]);

        AssessmentOption::create(['assessment_sub_group_id' => $sub1a->id, 'text' => 'Kulit normal, tidak ada perubahan', 'score' => 0, 'order' => 1]);
        AssessmentOption::create(['assessment_sub_group_id' => $sub1a->id, 'text' => 'Kulit kering dan bersisik', 'score' => 1, 'order' => 2]);
        AssessmentOption::create(['assessment_sub_group_id' => $sub1a->id, 'text' => 'Kulit pecah-pecah dan retak', 'score' => 2, 'order' => 3]);
        AssessmentOption::create(['assessment_sub_group_id' => $sub1a->id, 'text' => 'Terdapat luka terbuka atau infeksi', 'score' => 3, 'order' => 4]);

        $sub1b = AssessmentSubGroup::create([
            'assessment_group_id' => $group1->id,
            'title'               => 'Kaki Kanan',
            'description'         => 'Kondisi kulit pada kaki kanan',
            'order'               => 2,
        ]);

        AssessmentOption::create(['assessment_sub_group_id' => $sub1b->id, 'text' => 'Kulit normal, tidak ada perubahan', 'score' => 0, 'order' => 1]);
        AssessmentOption::create(['assessment_sub_group_id' => $sub1b->id, 'text' => 'Kulit kering dan bersisik', 'score' => 1, 'order' => 2]);
        AssessmentOption::create(['assessment_sub_group_id' => $sub1b->id, 'text' => 'Kulit pecah-pecah dan retak', 'score' => 2, 'order' => 3]);
        AssessmentOption::create(['assessment_sub_group_id' => $sub1b->id, 'text' => 'Terdapat luka terbuka atau infeksi', 'score' => 3, 'order' => 4]);

        // ─── GROUP 2: Kuku Kaki ────────────────────────────────────────
        $group2 = AssessmentGroup::create([
            'title'       => 'Kuku Kaki',
            'slug'        => 'kuku-kaki',
            'description' => 'Penilaian kondisi kuku pada kaki kiri dan kanan',
            'icon'        => null,
            'order'       => 2,
        ]);

        $sub2a = AssessmentSubGroup::create([
            'assessment_group_id' => $group2->id,
            'title'               => 'Kaki Kiri',
            'description'         => 'Kondisi kuku pada kaki kiri',
            'order'               => 1,
        ]);

        AssessmentOption::create(['assessment_sub_group_id' => $sub2a->id, 'text' => 'Kuku normal', 'score' => 0, 'order' => 1]);
        AssessmentOption::create(['assessment_sub_group_id' => $sub2a->id, 'text' => 'Kuku menebal', 'score' => 1, 'order' => 2]);
        AssessmentOption::create(['assessment_sub_group_id' => $sub2a->id, 'text' => 'Kuku berubah warna (kekuningan/kehitaman)', 'score' => 2, 'order' => 3]);
        AssessmentOption::create(['assessment_sub_group_id' => $sub2a->id, 'text' => 'Kuku rapuh atau ingrowing nail', 'score' => 3, 'order' => 4]);

        $sub2b = AssessmentSubGroup::create([
            'assessment_group_id' => $group2->id,
            'title'               => 'Kaki Kanan',
            'description'         => 'Kondisi kuku pada kaki kanan',
            'order'               => 2,
        ]);

        AssessmentOption::create(['assessment_sub_group_id' => $sub2b->id, 'text' => 'Kuku normal', 'score' => 0, 'order' => 1]);
        AssessmentOption::create(['assessment_sub_group_id' => $sub2b->id, 'text' => 'Kuku menebal', 'score' => 1, 'order' => 2]);
        AssessmentOption::create(['assessment_sub_group_id' => $sub2b->id, 'text' => 'Kuku berubah warna (kekuningan/kehitaman)', 'score' => 2, 'order' => 3]);
        AssessmentOption::create(['assessment_sub_group_id' => $sub2b->id, 'text' => 'Kuku rapuh atau ingrowing nail', 'score' => 3, 'order' => 4]);

        // ─── RULES ─────────────────────────────────────────────────────
        AssessmentRule::create([
            'title'       => 'Indikasi Normal',
            'description' => 'Semua skor kelompok 0',
            'conditions'  => ['1' => 0, '2' => 0],
            'result_text' => 'Kondisi kaki Anda dalam keadaan normal. Tetap jaga kebersihan dan perawatan kaki.',
            'severity'    => 'normal',
            'order'       => 1,
        ]);

        AssessmentRule::create([
            'title'       => 'Indikasi Ringan',
            'description' => 'Skor minimal 2 pada kedua kelompok',
            'conditions'  => ['1' => 2, '2' => 2],
            'result_text' => 'Terdapat gejala ringan pada kulit dan kuku kaki. Disarankan untuk meningkatkan perawatan kaki dan konsultasi ke dokter.',
            'severity'    => 'ringan',
            'order'       => 2,
        ]);

        AssessmentRule::create([
            'title'       => 'Indikasi Penyakit Arteri',
            'description' => 'Skor tinggi pada kelompok Kulit Kaki',
            'conditions'  => ['1' => 3],
            'result_text' => 'Skor tinggi pada kelompok Kulit Kaki mengindikasikan kemungkinan Penyakit Arteri Perifer. Segera konsultasikan dengan dokter spesialis.',
            'severity'    => 'tinggi',
            'order'       => 3,
        ]);

        AssessmentRule::create([
            'title'       => 'Indikasi Infeksi Jamur',
            'description' => 'Skor tinggi pada kelompok Kuku Kaki',
            'conditions'  => ['2' => 3],
            'result_text' => 'Skor tinggi pada kelompok Kuku Kaki mengindikasikan kemungkinan infeksi jamur atau onikomikosis. Segera konsultasikan dengan dokter.',
            'severity'    => 'sedang',
            'order'       => 4,
        ]);
    }
}
