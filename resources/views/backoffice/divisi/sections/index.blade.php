@extends('backoffice.layouts.app')

@section('title', 'Sections - ' . $divisi->nama)
@section('page-title', 'Kelola Sections: ' . $divisi->nama)

@section('content')

<div class="card">
    <div class="card-header">
        <h3>Daftar Section</h3>
        <div style="display: flex; gap: 8px;">
            <a href="{{ route('backoffice.sections.create', $divisi->id) }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah Section
            </a>
            <a href="{{ route('backoffice.divisi.edit', $divisi->id) }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali ke Divisi
            </a>
        </div>
    </div>
    <div class="card-body">
        
        @if($sections->count() > 0)
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Section</th>
                            <th>Design</th>
                            <th>Posisi</th>
                            <th>Urutan</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($sections as $section)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <strong>{{ $section->section_name }}</strong>
                                @if($section->image)
                                    <br><small style="color: #666;">📷 Ada gambar</small>
                                @endif
                            </td>
                            <td>
                                <span class="badge" style="background: {{ $section->design_style === 'light' ? '#f0f0f0' : ($section->design_style === 'dark' ? '#333' : '#CC0000') }}; color: {{ $section->design_style === 'dark' ? '#fff' : '#000' }}; padding: 4px 8px;">
                                    {{ $section->design_style === 'light' ? 'Putih' : ($section->design_style === 'dark' ? 'Abu-abu' : 'Accent') }}
                                </span>
                            </td>
                            <td>
                                @php
                                    $posMap = [
                                        'before_program' => 'Sebelum Program',
                                        'after_program' => 'Setelah Program',
                                        'after_about' => 'Setelah Tentang',
                                        'after_layanan' => 'Setelah Layanan',
                                        'after_pusat_kajian' => 'Setelah Pusat Kajian',
                                    ];
                                @endphp
                                <small>{{ $posMap[$section->position_after] ?? $section->position_after }}</small>
                            </td>
                            <td>{{ $section->urutan }}</td>
                            <td>
                                <span class="badge {{ $section->is_active ? 'badge-active' : 'badge-inactive' }}">
                                    {{ $section->is_active ? 'Aktif' : 'Tidak Aktif' }}
                                </span>
                            </td>
                            <td>
                                <div class="action-group">
                                    <a href="{{ route('backoffice.sections.edit', [$divisi->id, $section->id]) }}" class="btn btn-warning btn-icon" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('backoffice.sections.destroy', [$divisi->id, $section->id]) }}" method="POST" onsubmit="return confirm('Yakin hapus section ini?')" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-icon" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div style="text-align: center; padding: 40px; color: #666;">
                <i class="fas fa-inbox" style="font-size: 2rem; opacity: 0.5;"></i>
                <p style="margin-top: 12px;">Belum ada section. Klik <strong>"Tambah Section"</strong> untuk membuat yang baru.</p>
            </div>
        @endif
        
    </div>
</div>

@endsection