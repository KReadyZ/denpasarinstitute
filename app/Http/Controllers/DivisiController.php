<?php

namespace App\Http\Controllers;

use App\Models\Divisi;
use App\Models\DivisiSection;
use Illuminate\Http\Request;

class DivisiController extends Controller
{
    public function show($slug)
    {
        $divisi = Divisi::where('slug', $slug)
                        ->where('is_active', true)
                        ->firstOrFail();

        $programs = $divisi->programs()
                        ->where('is_active', true)
                        ->orderBy('urutan', 'asc')
                        ->get();

        $sections = $divisi->sections()
                          ->where('is_active', true)
                          ->orderBy('urutan', 'asc')
                          ->get() ?? collect();

        $prevDivisi = Divisi::where('is_active', true)
                            ->where('urutan', '<', $divisi->urutan)
                            ->orderBy('urutan', 'desc')
                            ->first();

        $nextDivisi = Divisi::where('is_active', true)
                            ->where('urutan', '>', $divisi->urutan)
                            ->orderBy('urutan', 'asc')
                            ->first();

        $sectionsByPosition = $this->organizeSectionsByPosition($sections);

        return view('divisi.show', compact('divisi', 'programs', 'sections', 'sectionsByPosition', 'prevDivisi', 'nextDivisi'));
    }

    private function organizeSectionsByPosition($sections)
    {
        $organized = [
            'before_program' => collect(),
            'after_program' => collect(),
            'after_section' => collect(),
        ];

        if (!$sections || $sections->isEmpty()) {
            return $organized;
        }

        foreach ($sections as $section) {
            if ($section->position_after === 'before_program') {
                $organized['before_program']->push($section);
            } elseif ($section->position_after === 'after_program') {
                $organized['after_program']->push($section);
            } elseif (strpos($section->position_after, 'after_section_') === 0) {
                $organized['after_section']->push($section);
            }
        }

        return $organized;
    }
}