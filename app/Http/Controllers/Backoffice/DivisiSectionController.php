<?php

namespace App\Http\Controllers\Backoffice;

use App\Http\Controllers\Controller;
use App\Models\Divisi;
use App\Models\DivisiSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use DOMDocument;
use DOMXPath;

class DivisiSectionController extends Controller
{
    public function index($divisiId)
    {
        $divisi = Divisi::findOrFail($divisiId);
        $sections = $divisi->sections()
                           ->withoutGlobalScopes()
                           ->orderBy('urutan', 'asc')
                           ->get();
        
        return view('backoffice.divisi.sections.index', compact('divisi', 'sections'));
    }

    public function create($divisiId)
    {
        $divisi = Divisi::findOrFail($divisiId);
        
        $designOptions = [
            'light' => 'Putih (Light)',
            'dark' => 'Abu-abu (Dark)',
            'accent' => 'Warna Brand (Accent)',
        ];

        $positionOptions = $this->buildPositionOptions($divisi);
        
        return view('backoffice.divisi.sections.create', compact('divisi', 'designOptions', 'positionOptions'));
    }

    public function store(Request $request, $divisiId)
    {
        $divisi = Divisi::findOrFail($divisiId);

        $request->validate([
            'section_name' => 'required|string|max:255',
            'content' => 'required|string',
            'design_style' => 'required|in:light,dark,accent',
            'position_after' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'urutan' => 'nullable|integer|min:0',
            'is_active' => 'nullable|boolean',
        ]);

        $data = [
            'divisi_id' => $divisi->id,
            'section_name' => $request->section_name,
            'content' => $this->sanitizeHtml($request->content),
            'design_style' => $request->design_style,
            'position_after' => $request->position_after,
            'urutan' => $request->urutan ?? 0,
            'is_active' => $request->has('is_active'),
        ];

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store("divisi_{$divisi->id}_sections", 'public');
            $data['image'] = $path;
        }

        DivisiSection::create($data);

        return redirect()
                ->route('backoffice.sections.index', $divisi->id)
                ->with('success', 'Section berhasil ditambahkan!');
    }

    public function edit($divisiId, $sectionId)
    {
        $divisi = Divisi::findOrFail($divisiId);
        $section = DivisiSection::where('divisi_id', $divisi->id)
                                ->findOrFail($sectionId);
        
        $designOptions = [
            'light' => 'Putih (Light)',
            'dark' => 'Abu-abu (Dark)',
            'accent' => 'Warna Brand (Accent)',
        ];

        $positionOptions = $this->buildPositionOptions($divisi);
        
        return view('backoffice.divisi.sections.edit', compact('divisi', 'section', 'designOptions', 'positionOptions'));
    }

    public function update(Request $request, $divisiId, $sectionId)
    {
        $divisi = Divisi::findOrFail($divisiId);
        $section = DivisiSection::where('divisi_id', $divisi->id)
                                ->findOrFail($sectionId);

        $request->validate([
            'section_name' => 'required|string|max:255',
            'content' => 'required|string',
            'design_style' => 'required|in:light,dark,accent',
            'position_after' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'urutan' => 'nullable|integer|min:0',
            'is_active' => 'nullable|boolean',
        ]);

        $data = [
            'section_name' => $request->section_name,
            'content' => $this->sanitizeHtml($request->content),
            'design_style' => $request->design_style,
            'position_after' => $request->position_after,
            'urutan' => $request->urutan ?? 0,
            'is_active' => $request->has('is_active'),
        ];

        if ($request->hasFile('image')) {
            if ($section->image) {
                Storage::disk('public')->delete($section->image);
            }
            $path = $request->file('image')->store("divisi_{$divisi->id}_sections", 'public');
            $data['image'] = $path;
        }

        $section->update($data);

        return redirect()
                ->route('backoffice.sections.index', $divisi->id)
                ->with('success', 'Section berhasil diperbarui!');
    }

    public function destroy($divisiId, $sectionId)
    {
        $divisi = Divisi::findOrFail($divisiId);
        $section = DivisiSection::where('divisi_id', $divisi->id)
                                ->findOrFail($sectionId);

        if ($section->image) {
            Storage::disk('public')->delete($section->image);
        }

        $section->delete();

        return redirect()
                ->route('backoffice.sections.index', $divisi->id)
                ->with('success', 'Section berhasil dihapus!');
    }

    private function buildPositionOptions($divisi)
    {
        $positions = [
            'before_program' => 'Sebelum Program Section',
            'after_program' => 'Setelah Program Section',
        ];

        $sections = $divisi->sections()
                           ->withoutGlobalScopes()
                           ->orderBy('urutan', 'asc')
                           ->get();

        foreach ($sections as $section) {
            $positions["after_section_{$section->id}"] = "Setelah: {$section->section_name}";
        }

        return $positions;
    }

    private function sanitizeHtml(?string $html): ?string
    {
        if (empty(trim((string) $html))) {
            return $html;
        }

        libxml_use_internal_errors(true);
        $dom = new DOMDocument('1.0', 'UTF-8');
        $wrapped = '<?xml encoding="UTF-8"><div id="__root__">' . $html . '</div>';

        $dom->loadHTML($wrapped, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        libxml_clear_errors();

        $xpath = new DOMXPath($dom);
        $nestedOuterAnchors = $xpath->query('//a[ancestor::a]/ancestor::a[not(ancestor::a)]');

        foreach ($nestedOuterAnchors as $outerAnchor) {
            $this->unwrapNode($outerAnchor);
        }

        $root = $dom->getElementById('__root__');
        if (!$root) {
            $divs = $xpath->query('//div[@id="__root__"]');
            $root = $divs->length > 0 ? $divs->item(0) : null;
        }

        if (!$root) {
            return $html;
        }

        $innerHtml = '';
        foreach ($root->childNodes as $child) {
            $innerHtml .= $dom->saveHTML($child);
        }

        return $innerHtml;
    }

    private function unwrapNode(\DOMNode $node): void
    {
        $parent = $node->parentNode;
        if (!$parent) return;

        while ($node->firstChild) {
            $parent->insertBefore($node->firstChild, $node);
        }
        $parent->removeChild($node);
    }
}