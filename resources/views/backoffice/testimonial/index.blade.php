@extends('backoffice.layouts.app')

@section('title', 'Manajemen Testimoni')
@section('page-title', 'Manajemen Testimoni')

@section('content')
<style>
    .testi-table th { font-size: 0.75rem; font-weight: 600; color: #9ca3af; text-transform: uppercase; letter-spacing: 0.5px; padding: 12px 16px; background: #fff; border-bottom: 1px solid #f0f0f0; }
    .testi-table td { padding: 14px 16px; border-bottom: 1px solid #f9f9f9; vertical-align: middle; }
    .testi-table tr:last-child td { border-bottom: none; }
    .testi-table tr:hover td { background: #fafafa; }

    .testi-avatar { width: 40px; height: 40px; border-radius: 50%; object-fit: cover; }
    .testi-avatar-init { width: 40px; height: 40px; border-radius: 50%; background: #f3f4f6; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 0.9rem; color: #374151; }

    .testi-name { font-size: 0.88rem; font-weight: 600; color: #111; }
    .testi-role { font-size: 0.75rem; color: #9ca3af; margin-top: 2px; }

    .testi-quote { font-size: 0.8rem; color: #6b7280; line-height: 1.5; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; max-width: 200px; }

    .testi-stars { display: flex; gap: 2px; }
    .testi-stars i { font-size: 0.7rem; }

    .testi-tag { display: inline-block; padding: 2px 10px; border-radius: 20px; font-size: 0.7rem; font-weight: 600; background: #f3f4f6; color: #6b7280; margin-top: 3px; }

    .status-dot { display: inline-flex; align-items: center; gap: 6px; font-size: 0.78rem; font-weight: 500; }
    .status-dot::before { content: ''; width: 7px; height: 7px; border-radius: 50%; display: inline-block; }
    .status-dot.aktif { color: #16a34a; }
    .status-dot.aktif::before { background: #16a34a; }
    .status-dot.nonaktif { color: #9ca3af; }
    .status-dot.nonaktif::before { background: #d1d5db; }

    .btn-ghost { background: transparent; border: 1px solid #e5e7eb; color: #374151; padding: 6px 10px; border-radius: 6px; font-size: 0.78rem; font-weight: 500; cursor: pointer; display: inline-flex; align-items: center; gap: 5px; transition: 0.15s; font-family: Poppins, sans-serif; }
    .btn-ghost:hover { background: #f9fafb; border-color: #d1d5db; }
    .btn-ghost.danger:hover { background: #fef2f2; border-color: #fca5a5; color: #dc2626; }
    .btn-ghost.success:hover { background: #f0fdf4; border-color: #86efac; color: #16a34a; }

    .page-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 20px; }
    .page-header h2 { font-size: 1rem; font-weight: 700; color: #111; margin: 0; }
    .page-header small { font-size: 0.78rem; color: #9ca3af; display: block; margin-top: 2px; font-weight: 400; }
</style>

<div class="page-header">
    <div>
        <h2>Testimoni</h2>
        <small>Kelola kutipan dan ulasan yang tampil di website</small>
    </div>
    <a href="{{ route('backoffice.testimonial.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Tambah
    </a>
</div>

<div class="card">
    <div class="table-wrap">
        <table class="testi-table" style="width:100%;border-collapse:collapse;">
            <thead>
                <tr>
                    <th style="width:40px;">#</th>
                    <th style="width:48px;"></th>
                    <th>Nama</th>
                    <th>Kutipan</th>
                    <th style="width:90px;">Rating</th>
                    <th style="width:70px;text-align:center;">Urutan</th>
                    <th style="width:110px;">Status</th>
                    <th style="width:130px;"></th>
                </tr>
            </thead>
            <tbody>
                @forelse($testimonials as $t)
                <tr>
                    <td style="color:#9ca3af;font-size:0.78rem;">{{ $loop->iteration }}</td>
                    <td>
                        @if($t->avatar)
                            <img src="{{ asset('storage/' . $t->avatar) }}" class="testi-avatar">
                        @else
                            <div class="testi-avatar-init">{{ strtoupper(substr($t->name, 0, 1)) }}</div>
                        @endif
                    </td>
                    <td>
                        <div class="testi-name">{{ $t->name }}</div>
                        <div class="testi-role">{{ $t->role ?? '' }}</div>
                        @if($t->tag)
                            <span class="testi-tag">{{ $t->tag }}</span>
                        @endif
                    </td>
                    <td>
                        <div class="testi-quote">"{{ $t->quote }}"</div>
                    </td>
                    <td>
                        <div class="testi-stars">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="fas fa-star" style="color:{{ $i <= $t->rating ? '#F5C400' : '#e5e7eb' }};"></i>
                            @endfor
                        </div>
                    </td>
                    <td style="text-align:center;font-size:0.82rem;color:#6b7280;">{{ $t->order }}</td>
                    <td>
                        @if($t->is_approved)
                            <span class="status-dot aktif">Ditampilkan</span>
                        @else
                            <span class="status-dot nonaktif">Tersembunyi</span>
                        @endif
                    </td>
                    <td>
                        <div style="display:flex;gap:6px;align-items:center;">
                            <a href="{{ route('backoffice.testimonial.edit', $t->id) }}" class="btn-ghost">
                                <i class="fas fa-pen"></i> Edit
                            </a>
                            <form action="{{ route('backoffice.testimonial.approve', $t->id) }}" method="POST">
                                @csrf @method('PATCH')
                                <button type="submit" class="btn-ghost {{ $t->is_approved ? '' : 'success' }}" title="{{ $t->is_approved ? 'Sembunyikan' : 'Tampilkan' }}">
                                    <i class="fas fa-{{ $t->is_approved ? 'eye' : 'eye-slash' }}"></i>
                                </button>
                            </form>
                            <form action="{{ route('backoffice.testimonial.destroy', $t->id) }}" method="POST"
                                  onsubmit="return confirm('Hapus testimoni ini?');">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-ghost danger">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                @endforelse
            </tbody>
        </table>
    </div>

    @if($testimonials->hasPages())
    <div style="display:flex;justify-content:space-between;align-items:center;padding:14px 16px;border-top:1px solid #f0f0f0;">
        <small style="color:#9ca3af;font-size:0.75rem;">
            Menampilkan {{ $testimonials->firstItem() }}–{{ $testimonials->lastItem() }} dari {{ $testimonials->total() }} data
        </small>
        {{ $testimonials->links() }}
    </div>
    @endif
</div>
@endsection