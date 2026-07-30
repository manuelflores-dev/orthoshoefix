<?php

namespace Database\Seeders;

use App\Enums\PortfolioLayout;
use App\Models\PortfolioItem;
use Illuminate\Database\Seeder;

class PortfolioSeeder extends Seeder
{
    /**
     * Load the cases that used to be hard coded in the landing page.
     *
     * Safe to run in production: it only creates the cases if they are missing,
     * and it points at the images already shipped under public/images/shoes.
     */
    public function run(): void
    {
        $cases = [
            [
                'title' => 'Diadora — Sole Lift: Complete Process',
                'summary' => 'Diadora athletic shoe with orthopedic lift. The 4 photos show the complete process of a doctor-prescribed modification.',
                'layout' => PortfolioLayout::Process,
                'badge' => 'Real Case',
                'tags' => ['Leg Length Discrepancy', 'Sole Lift Build-Up', 'Rx Required', 'Diadora Athletic'],
                'sort_order' => 1,
                'photos' => [
                    ['path' => 'images/shoes/process-1.jpg', 'label' => 'Original', 'caption' => 'No modification'],
                    ['path' => 'images/shoes/process-4.jpg', 'label' => 'Evaluation', 'caption' => 'Measurements & Rx'],
                    ['path' => 'images/shoes/process-3.jpg', 'label' => 'Lift Applied', 'caption' => 'Under construction'],
                    ['path' => 'images/shoes/process-2.jpg', 'label' => 'Final Result', 'caption' => 'Lift integrated'],
                ],
            ],
            [
                'title' => 'New Balance — 1.5" Sole Lift',
                'summary' => 'Invisible lift integrated directly into the midsole. Prescribed by a podiatrist to correct leg length discrepancy.',
                'layout' => PortfolioLayout::BeforeAfter,
                'badge' => null,
                'tags' => ['Leg Length', '1.5" Lift', 'Rx Required'],
                'sort_order' => 2,
                'photos' => [
                    ['path' => 'images/shoes/shoe-nb-back.jpg', 'label' => 'BEFORE', 'caption' => null],
                    ['path' => 'images/shoes/shoe-nb-side.jpg', 'label' => 'AFTER', 'caption' => null],
                ],
            ],
            [
                'title' => 'Medical Clogs — Arch & Pressure Relief',
                'summary' => 'Custom stitched insoles added to professional medical clogs. Plantar fasciitis support with metatarsal pad and full-length cushioning for healthcare workers.',
                'layout' => PortfolioLayout::BeforeAfter,
                'badge' => null,
                'tags' => ['Plantar Support', 'Custom Insole', 'Healthcare'],
                'sort_order' => 3,
                'photos' => [
                    ['path' => 'images/shoes/clog-smooth.jpg', 'label' => 'BEFORE', 'caption' => null],
                    ['path' => 'images/shoes/clog-perforated.jpg', 'label' => 'AFTER', 'caption' => null],
                ],
            ],
        ];

        foreach ($cases as $case) {
            $photos = $case['photos'];
            unset($case['photos']);

            $item = PortfolioItem::firstOrCreate(
                ['title' => $case['title']],
                [...$case, 'is_published' => true],
            );

            if ($item->photos()->exists()) {
                continue;
            }

            foreach ($photos as $position => $photo) {
                $item->photos()->create([...$photo, 'sort_order' => $position + 1]);
            }
        }
    }
}
