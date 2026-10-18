@extends('layouts.app')

@section('title', 'Event - Denpasar Institute')

@push('styles')
<style>
    .news-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 30px;
    }
    .news-card {
        display: block;
        background: #fff;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 2px 12px rgba(0,0,0,.05);
        transition: transform .2s, box-shadow .2s;
        text-decoration: none;
        position: relative;
    }
    .news-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 24px rgba(0,0,0,.1);
    }
    .news-card img {
        width: 100%;
        height: 200px;
        object-fit: cover;
    }
    .news-card-body { padding: 20px 20px 10px 20px; }
    .news-card-cat {
        display: inline-block;
        background: #fff0f0;
        color: #dc3545;
        font-size: .7rem;
        font-weight: 700;
        text-transform: uppercase;
        padding: 2px 10px;
        border-radius: 12px;
        margin-bottom: 8px;
    }
    .news-card-title {
        font-size: 1.1rem;
        font-weight: 700;
        line-height: 1.4;
        margin-bottom: 8px;
        color: #1a1a1a;
    }
    .news-card-excerpt {
        font-size: .88rem;
        color: #666;
        line-height: 1.6;
        margin-bottom: 16px;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    .news-meta-top {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 10px;
        font-size: .78rem;
        color: #999;
        margin-bottom: 6px;
    }
    .news-meta-top i { margin-right: 2px; }
    .news-meta-top .penulis { color: #777; }

    .news-card-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-top: 16px;
        border-top: 1px solid #f3f3f3;
        padding-bottom: 4px;
    }
    
    .news-meta-bottom {
        display: flex;
        align-items: center;
        gap: 14px;
        font-size: .78rem;
        color: #999;
    }
    .news-meta-bottom i { font-size: .75rem; margin-right: 2px; }

    .news-actions {
        display: flex;
        align-items: center;
        gap: 10px;
        position: relative;
    }

    .btn-read {
        background: #dc3545;
        color: #fff;
        padding: 6px 16px;
        border-radius: 6px;
        font-size: .78rem;
        font-weight: 600;
        transition: background .2s;
        cursor: pointer;
        text-decoration: none;
        display: inline-block;
    }
    .news-card:hover .btn-read { background: #b8202f; }

    .btn-share-icon {
        background: #f1f1f1;
        color: #555;
        width: 30px;
        height: 30px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: .8rem;
        cursor: pointer;
        transition: all .2s;
        border: none;
        position: relative;
        z-index: 5;
    }
    .btn-share-icon:hover {
        background: #dc3545;
        color: #fff;
    }
    .btn-share-icon.active {
        background: #dc3545;
        color: #fff;
    }

    .share-dropdown-horizontal {
        position: absolute;
        top: 50%;
        right: calc(100% + 8px);
        transform: translateY(-50%) scaleX(0);
        transform-origin: right center;
        background: #fff;
        border-radius: 30px;
        box-shadow: 0 4px 16px rgba(0,0,0,.15);
        padding: 6px 12px;
        display: flex;
        align-items: center;
        gap: 12px;
        z-index: 10;
        opacity: 0;
        transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        white-space: nowrap;
        pointer-events: none;
    }
    .share-dropdown-horizontal.show {
        opacity: 1;
        transform: translateY(-50%) scaleX(1);
        pointer-events: auto;
    }
    
    .share-dropdown-horizontal a, 
    .share-dropdown-horizontal button {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 32px;
        height: 32px;
        border-radius: 50%;
        font-size: 1rem;
        color: #666;
        text-decoration: none;
        background: transparent;
        border: none;
        cursor: pointer;
        transition: background 0.2s, color 0.2s, transform 0.2s;
    }
    .share-dropdown-horizontal a:hover, 
    .share-dropdown-horizontal button:hover {
        background: #f5f5f5;
        transform: scale(1.1);
    }
    .share-dropdown-horizontal .ic-wa { color: #25D366; }
    .share-dropdown-horizontal .ic-fb { color: #1877F2; }
    .share-dropdown-horizontal .ic-copy { color: #777; }
    .share-dropdown-horizontal .ic-copy:hover { color: #333; }

    .btn-header {
        display: flex;
        justify-content: flex-end;
        margin-bottom: 32px;
    }
    .btn-toggle-form {
        background: #CC0000;
        color: #fff;
        padding: 10px 24px;
        border-radius: 6px;
        border: none;
        cursor: pointer;
        font-weight: 600;
        font-size: 0.95rem;
        transition: all 0.2s;
    }
    .btn-toggle-form:hover {
        background: #b8202f;
    }

    /* Modal Overlay - REVISI */
    .modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        display: none;
        align-items: flex-start;
        justify-content: center;
        z-index: 999;
        opacity: 0;
        transition: opacity 0.3s ease;
        padding: 20px;
        padding-top: 200px;
        overflow-y: auto;
    }
    .modal-overlay.show {
        display: flex;
        opacity: 1;
    }

    .modal-content {
        background: #fff;
        border-radius: 12px;
        width: 100%;
        max-width: 450px;
        max-height: 85vh;
        overflow-y: auto;
        box-shadow: 0 8px 32px rgba(0,0,0,.2);
        animation: slideUp 0.3s ease-out;
        position: relative;
        flex-shrink: 0;
    }
    @keyframes slideUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .modal-header {
        padding: 24px;
        border-bottom: 1px solid #f0f0f0;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .modal-header h2 {
        font-size: 1.4rem;
        font-weight: 800;
        color: #333;
        margin: 0;
    }
    .modal-close-btn {
        background: none;
        border: none;
        font-size: 1.5rem;
        color: #999;
        cursor: pointer;
        transition: color 0.2s;
    }
    .modal-close-btn:hover {
        color: #333;
    }

    .modal-body {
        padding: 24px;
    }
    .modal-body p {
        color: #666;
        font-size: 0.9rem;
        margin-bottom: 16px;
    }

    .form-group {
        display: flex;
        flex-direction: column;
        margin-bottom: 16px;
    }
    .form-group label {
        display: block;
        margin-bottom: 6px;
        font-weight: 600;
        color: #333;
        font-size: 0.9rem;
    }
    .form-group label span {
        color: red;
    }
    .form-group input,
    .form-group select,
    .form-group textarea {
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 6px;
        font-family: inherit;
        font-size: 0.9rem;
        transition: border-color 0.2s;
    }
    .form-group input:focus,
    .form-group select:focus,
    .form-group textarea:focus {
        outline: none;
        border-color: #CC0000;
        box-shadow: 0 0 0 3px rgba(204,0,0,.1);
    }
    .form-group small {
        margin-top: 4px;
        color: #666;
        font-size: 0.8rem;
    }
    .form-group .error {
        color: #dc3545;
        font-size: 0.8rem;
        margin-top: 4px;
    }

    .info-box {
        background: #f0f8ff;
        border-left: 4px solid #0066cc;
        padding: 12px;
        border-radius: 6px;
        margin-bottom: 16px;
        font-size: 0.85rem;
        color: #333;
    }
    .info-box i {
        color: #0066cc;
        margin-right: 6px;
    }

    .form-actions {
        display: flex;
        gap: 12px;
        margin-top: 16px;
        padding-top: 16px;
        border-top: 1px solid #eee;
    }
    .form-actions button,
    .form-actions .btn-cancel {
        flex: 1;
        padding: 10px;
        border-radius: 6px;
        font-weight: 600;
        border: none;
        cursor: pointer;
        font-size: 0.9rem;
        transition: all 0.2s;
    }
    .form-actions .btn-submit {
        background: #CC0000;
        color: #fff;
    }
    .form-actions .btn-submit:hover {
        background: #b8202f;
    }
    .form-actions .btn-cancel {
        background: #e9ecef;
        color: #333;
    }
    .form-actions .btn-cancel:hover {
        background: #dee2e6;
    }

    .alert {
        padding: 12px;
        border-radius: 6px;
        margin-bottom: 16px;
        font-size: 0.9rem;
    }
    .alert-danger {
        background: #f8d7da;
        border: 1px solid #f5c6cb;
        color: #721c24;
    }
    .alert-danger ul {
        margin: 6px 0 0 0;
        padding-left: 20px;
    }
    .alert-success {
        background: #d4edda;
        border: 1px solid #c3e6cb;
        color: #155724;
    }

    /* ==== PAGINATION FIX ==== */
    .pagination {
        display: flex;
        list-style: none;
        margin: 0;
        padding: 0;
        gap: 6px;
        flex-wrap: wrap;
        justify-content: center;
    }
    .pagination .page-item {
        display: inline-flex;
    }
    .pagination .page-link {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 38px;
        height: 38px;
        padding: 0 10px;
        color: #dc3545;
        background: #fff;
        border: 1px solid #eee;
        border-radius: 6px;
        font-size: .85rem;
        font-weight: 600;
        text-decoration: none;
        transition: all .2s;
        line-height: 1;
    }
    .pagination .page-link:hover {
        background: #fff0f0;
        color: #b8202f;
        border-color: #dc3545;
    }
    .pagination .page-item.active .page-link {
        background: #dc3545;
        border-color: #dc3545;
        color: #fff;
    }
    .pagination .page-item.disabled .page-link {
        color: #ccc;
        background: #fafafa;
        cursor: not-allowed;
    }

    @media (max-width: 450px) {
        .share-dropdown-horizontal {
            right: 0;
            top: auto;
            bottom: calc(100% + 10px);
            transform: translateY(0) scaleY(0);
            transform-origin: bottom center;
            border-radius: 20px;
            flex-direction: row;
        }
        .share-dropdown-horizontal.show {
            transform: translateY(0) scaleY(1);
        }
        .modal-content {
            max-width: 100%;
        }
    .page-content-wrapper {
        padding: 180px 0 60px;
    }
    @media (max-width: 991px) and (min-width: 769px) {
        .page-content-wrapper {
            padding: 110px 0 50px !important;
        }
    }
    @media (max-width: 768px) {
        .page-content-wrapper {
            padding: 40px 0 50px !important;
        }
    }
</style>
@endpush

@section('content')
<div class="page-content-wrapper" style="padding: 180px 0 60px; background:var(--gray);">
  <div class="container">

    <div class="section-header" style="margin-bottom:32px;">
      <span class="section-tag">Event</span>
      <h2>Event</h2>
      <div class="section-line"></div>
    </div>

    <!-- Button Tambah Event -->
    <div class="btn-header">
      <button type="button" class="btn-toggle-form" onclick="openEventModal()">
        <i class="fas fa-plus"></i> Ajukan Event
      </button>
    </div>

    <!-- Grid Event Cards -->
    <div class="news-grid">
      @forelse($events as $item)
        <div class="news-card">
          <a href="{{ route('event.show', $item->id) }}" style="color:inherit;text-decoration:none;display:block;">
            <img src="{{ $item->image ? asset('storage/'.$item->image) : 'https://images.unsplash.com/photo-1552664730-d307ca884978?w=600&auto=format&fit=crop' }}" alt="{{ $item->title }}">
            <div class="news-card-body">
              <span class="news-card-cat">{{ $item->kategori }}</span>
              <h3 class="news-card-title">{{ $item->title }}</h3>
              
              <div class="news-meta-top">
                  <span class="penulis"><i class="far fa-user"></i> {{ $item->kontributor }}</span>
              </div>

              <p class="news-card-excerpt">{{ Str::limit(strip_tags($item->content), 110) }}</p>
            </div>
          </a>
          
          <div style="padding: 0 20px 20px 20px;">
            <div class="news-card-footer">
              <div class="news-meta-bottom">
                  <span class="news-date">
                    <i class="far fa-calendar-alt"></i>
                    {{ $item->published_at ? $item->published_at->format('d M Y') : $item->created_at->format('d M Y') }}
                  </span>
                  <span class="news-views">
                    <i class="far fa-eye"></i> {{ number_format($item->views) }}
                  </span>
              </div>
              
              <div class="news-actions">
                  <div class="share-container" style="position:relative; display:flex; align-items:center;">
                      <button class="btn-share-icon" onclick="toggleShareHorizontal(this)" title="Bagikan">
                          <i class="fas fa-share-alt"></i>
                      </button>
                      
                      <div class="share-dropdown-horizontal">
                          <a href="https://wa.me/?text={{ urlencode($item->title . ' - ' . route('event.show', $item->id)) }}" target="_blank" title="Bagikan ke WhatsApp">
                              <i class="fab fa-whatsapp ic-wa"></i>
                          </a>
                          <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('event.show', $item->id)) }}" target="_blank" title="Bagikan ke Facebook">
                              <i class="fab fa-facebook ic-fb"></i>
                          </a>
                          <button type="button" onclick="copyShareLinkHorizontal('{{ route('event.show', $item->id) }}', this)" title="Salin Link">
                              <i class="fas fa-link ic-copy"></i>
                          </button>
                      </div>
                  </div>

                  <a href="{{ route('event.show', $item->id) }}" class="btn-read">Baca</a>
              </div>
            </div>
          </div>
        </div>
      @empty
        <p style="grid-column:1/-1;text-align:center;color:#999;padding:40px 0;">Belum ada event.</p>
      @endforelse
    </div>

    @if ($events->hasPages())
      <div style="margin-top:40px;display:flex;justify-content:center;">
        <ul class="pagination">
          @if ($events->onFirstPage())
            <li class="page-item disabled"><span class="page-link">&lsaquo;</span></li>
          @else
            <li class="page-item"><a class="page-link" href="{{ $events->previousPageUrl() }}" rel="prev">&lsaquo;</a></li>
          @endif

          @foreach ($events->getUrlRange(1, $events->lastPage()) as $page => $url)
            @if ($page == $events->currentPage())
              <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
            @else
              <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
            @endif
          @endforeach

          @if ($events->hasMorePages())
            <li class="page-item"><a class="page-link" href="{{ $events->nextPageUrl() }}" rel="next">&rsaquo;</a></li>
          @else
            <li class="page-item disabled"><span class="page-link">&rsaquo;</span></li>
          @endif
        </ul>
      </div>
    @endif

  </div>
</div>

<!-- Modal Overlay -->
<div class="modal-overlay" id="eventModal">
  <div class="modal-content">
    <div class="modal-header">
      <h2>Ajukan Event Baru</h2>
      <button type="button" class="modal-close-btn" onclick="closeEventModal()">
        <i class="fas fa-times"></i>
      </button>
    </div>

    <div class="modal-body">
      <p>Bagikan event Anda dengan komunitas Denpasar Institute</p>

      @if ($errors->any())
        <div class="alert alert-danger">
          <strong><i class="fas fa-exclamation-circle"></i> Terjadi kesalahan!</strong>
          <ul>
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      @if (session('success'))
        <div class="alert alert-success">
          <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
      @endif

      <form action="{{ route('event.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
          <label for="kategori">Kategori <span>*</span></label>
          <select name="kategori" id="kategori" required>
            <option value="">Pilih Kategori</option>
            @foreach($kategoriList as $kat)
              <option value="{{ $kat->nama }}" {{ old('kategori') == $kat->nama ? 'selected' : '' }}>
                {{ $kat->nama }}
              </option>
            @endforeach
          </select>
          @error('kategori') <span class="error">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
          <label for="kontributor">Nama Anda / Organisasi <span>*</span></label>
          <input type="text" name="kontributor" id="kontributor" value="{{ old('kontributor') }}" required placeholder="Siapa yang mengajukan event ini?">
          @error('kontributor') <span class="error">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
          <label for="no_anggota">No. Anggota (Opsional)</label>
          <input type="text" name="no_anggota" id="no_anggota" value="{{ old('no_anggota') }}" placeholder="Contoh: 123456">
        </div>

        <div class="form-group">
          <label for="published_at">Tanggal Event</label>
          <input type="date" name="published_at" id="published_at" value="{{ old('published_at') }}">
        </div>

        <div class="form-group">
          <label for="title">Judul Event <span>*</span></label>
          <input type="text" name="title" id="title" value="{{ old('title') }}" required placeholder="Judul event yang menarik">
          @error('title') <span class="error">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
          <label for="image">Gambar Event</label>
          <input type="file" name="image" id="image" accept="image/*">
          <small><strong>Max:</strong> 2MB | <strong>Format:</strong> JPG, PNG</small>
        </div>

        <div class="form-group">
          <label for="content">Deskripsi Event <span>*</span></label>
          <textarea name="content" id="content" class="summernote" rows="10" required>{{ old('content') }}</textarea>
          @error('content') <span class="error">{{ $message }}</span> @enderror
        </div>

        <div class="info-box">
          <i class="fas fa-info-circle"></i>
          Event Anda akan melewati proses verifikasi admin sebelum ditayangkan.
        </div>

        <div class="form-actions">
          <button type="button" class="btn-cancel" onclick="closeEventModal()">
            Batal
          </button>
          <button type="submit" class="btn-submit">
            <i class="fas fa-paper-plane"></i> Ajukan
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

@endsection

@push('scripts')
<script>
    const eventModal = document.getElementById('eventModal');

    function openEventModal() {
        eventModal.classList.add('show');
        document.body.style.overflow = 'hidden';
    }

    function closeEventModal() {
        eventModal.classList.remove('show');
        document.body.style.overflow = 'auto';
    }

    eventModal.addEventListener('click', function(e) {
        if (e.target === eventModal) {
            closeEventModal();
        }
    });

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && eventModal.classList.contains('show')) {
            closeEventModal();
        }
    });

    function toggleShareHorizontal(btn) {
        document.querySelectorAll('.share-dropdown-horizontal.show').forEach(el => {
            if(el !== btn.nextElementSibling) {
                el.classList.remove('show');
                el.previousElementSibling.classList.remove('active');
            }
        });
        
        const dropdown = btn.nextElementSibling;
        dropdown.classList.toggle('show');
        btn.classList.toggle('active');
    }

    function copyShareLinkHorizontal(url, btn) {
        navigator.clipboard.writeText(url).then(function () {
            const icon = btn.querySelector('i');
            const originalClass = icon.className;
            
            icon.className = 'fas fa-check';
            icon.style.color = '#28a745';
            
            setTimeout(function () {
                icon.className = originalClass;
                icon.style.color = '';
            }, 2000);
        });
    }

    document.addEventListener('click', function (e) {
        if (!e.target.closest('.share-container')) {
            document.querySelectorAll('.share-dropdown-horizontal.show').forEach(el => {
                el.classList.remove('show');
                el.previousElementSibling.classList.remove('active');
            });
        }
    });

    $(document).ready(function() {
        $('.summernote').summernote({
            height: 300,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'italic', 'underline', 'clear']],
                ['fontname', ['fontname']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link', 'picture', 'video']],
                ['view', ['fullscreen', 'codeview', 'help']]
            ]
        });
    });
</script>
@endpush