{{-- Modal Tambah Transaksi Keuangan (Sesuai Foto 2 & 3) --}}
<div class="modal fade" id="modalTambahTransaksi" tabindex="-1" aria-labelledby="modalTambahTransaksiLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content rounded-4 border-0 shadow-lg overflow-hidden">
      
      {{-- Modal Header --}}
      <div class="modal-header bg-white px-4 pt-4 pb-3 border-bottom-0">
        <div>
          <span class="badge bg-danger-subtle text-danger font-monospace px-2 py-1 mb-1" style="font-size: 0.72rem;">
            Form 2. Input transaksi keuangan
          </span>
          <h5 class="modal-title fw-bold text-dark fs-5 mb-0" id="modalTambahTransaksiLabel">
            Tambah Transaksi
          </h5>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      {{-- Form Body --}}
      <form action="{{ route('backoffice.cashflow.store') }}" method="POST" enctype="multipart/form-data" id="formTambahTransaksiModal">
        @csrf
        <div class="modal-body px-4 py-2 form-transaksi-modern">

          <div class="row g-3">
            {{-- 1. Pilih Program --}}
            <div class="col-12">
              <label class="form-label fw-semibold text-dark mb-1">
                Pilih Program
              </label>
              <select name="program_id" id="modalProgramId" class="form-select">
                <option value="">Pilih program</option>
                <option value="">-- Operasional Umum Lembaga (Non-Program) --</option>
                @foreach($programs as $prog)
                  <option value="{{ $prog->id }}">{{ $prog->nama }}</option>
                @endforeach
              </select>
            </div>

            {{-- 2. Tanggal Transaksi --}}
            <div class="col-12">
              <label class="form-label fw-semibold text-dark mb-1">
                <span class="text-danger">*</span> Tanggal Transaksi
              </label>
              <div class="input-group">
                <span class="input-group-text bg-white border-end-0 text-muted">
                  <i class="far fa-calendar-alt"></i>
                </span>
                <input type="date" name="tanggal" id="modalTanggal" value="{{ date('Y-m-d') }}" class="form-control border-start-0 ps-1" required>
              </div>
            </div>

            {{-- 3. Transaksi (Radio: Pemasukan vs Pengeluaran) --}}
            <div class="col-12">
              <label class="form-label fw-semibold text-dark mb-1 d-block">
                <span class="text-danger">*</span> Transaksi
              </label>
              <div class="d-flex align-items-center gap-4 pt-1 pb-1">
                <div class="form-check custom-radio-box">
                  <input class="form-check-input" type="radio" name="tipe" id="modalRadioMasuk" value="masuk" checked onchange="handleModalTipeChange('masuk')">
                  <label class="form-check-label fw-semibold text-dark ps-1" for="modalRadioMasuk" style="cursor: pointer;">
                    Pemasukan
                  </label>
                </div>
                <div class="form-check custom-radio-box">
                  <input class="form-check-input" type="radio" name="tipe" id="modalRadioKeluar" value="keluar" onchange="handleModalTipeChange('keluar')">
                  <label class="form-check-label fw-semibold text-dark ps-1" for="modalRadioKeluar" style="cursor: pointer;">
                    Pengeluaran
                  </label>
                </div>
              </div>
            </div>

            {{-- 4. Kategori --}}
            <div class="col-12">
              <label class="form-label fw-semibold text-dark mb-1">
                <span class="text-danger">*</span> Kategori
              </label>
              <select name="kategori" id="modalKategori" class="form-select" required>
                <option value="">Pilih kategori</option>
              </select>
            </div>

            {{-- 5. Deskripsi --}}
            <div class="col-12">
              <label class="form-label fw-semibold text-dark mb-1">
                Deskripsi
              </label>
              <textarea name="deskripsi" id="modalDeskripsi" class="form-control summernote" placeholder="Uraian transaksi / rincian kegiatan..." rows="4"></textarea>
            </div>

            {{-- 6 & 7. Satuan & Volume (Side by Side) --}}
            <div class="col-12 col-md-6">
              <label class="form-label fw-semibold text-dark mb-1">
                <span class="text-danger">*</span> Satuan
              </label>
              <select name="satuan" id="modalSatuan" class="form-select" onchange="handleModalSatuanChange(this)">
                <option value="">Pilih</option>
                @foreach($satuanOptions ?? [] as $sat)
                  <option value="{{ $sat }}" {{ $sat === 'paket' ? 'selected' : '' }}>{{ $sat }}</option>
                @endforeach
                <option value="__custom__">+ Satuan Baru...</option>
              </select>
              <input type="text" name="custom_satuan" id="modalCustomSatuanInput" class="form-control form-control-sm mt-1" placeholder="Ketik satuan baru..." style="display: none;" oninput="document.getElementById('modalSatuan').value = this.value">
            </div>

            <div class="col-12 col-md-6">
              <label class="form-label fw-semibold text-dark mb-1">
                <span class="text-danger">*</span> Volume
              </label>
              <input type="number" step="any" min="0.01" name="volume" id="modalVolume" value="1" class="form-control text-center fw-bold" required oninput="recalcModalTotal()">
            </div>

            {{-- 8. Harga Satuan (Rp) --}}
            <div class="col-12">
              <label class="form-label fw-semibold text-dark mb-1">
                <span class="text-danger">*</span> Harga Satuan (Rp)
              </label>
              <div class="input-group">
                <span class="input-group-text bg-white fw-bold">Rp</span>
                <input type="text" name="harga_satuan" id="modalHargaSatuan" class="form-control fw-bold" placeholder="Harga Satuan (Rp)" required oninput="formatRupiahModal(this); recalcModalTotal()">
              </div>
            </div>

            {{-- 9. Total Transaksi (Kalkulasi Otomatis = Volume x Harga Satuan) --}}
            <div class="col-12">
              <div class="p-3 bg-light rounded-3 border d-flex flex-column flex-sm-row justify-content-between align-items-sm-center">
                <div>
                  <span class="small text-muted d-block fw-bold" style="font-size: 0.75rem;">
                    TOTAL TRANSAKSI (VOLUME &times; HARGA SATUAN):
                  </span>
                  <strong class="fs-4 text-success" id="modalLiveTotalText">
                    Rp 0
                  </strong>
                </div>
                <div class="text-muted small mt-1 mt-sm-0">
                  <span id="modalLiveFormulaText">1 paket &times; Rp 0</span>
                </div>
              </div>
              <input type="hidden" name="nominal" id="modalHiddenTotalNominal">
            </div>

            {{-- 10. Metode Pembayaran & Bukti Lampiran --}}
            <div class="col-12 col-md-6">
              <label class="form-label fw-semibold text-dark mb-1">
                Metode Pembayaran
              </label>
              <select name="metode_pembayaran" id="modalMetode" class="form-select">
                @foreach($metodeOptions ?? [] as $m)
                  <option value="{{ $m }}">{{ $m }}</option>
                @endforeach
              </select>
            </div>

            <div class="col-12 col-md-6">
              <label class="form-label fw-semibold text-dark mb-1">
                Bukti Transaksi (Struk / Nota / Transfer)
              </label>
              <input type="file" name="lampiran" id="modalLampiran" class="form-control" accept="image/jpeg,image/png,image/jpg,application/pdf">
              <div class="form-text text-muted" style="font-size: 0.72rem;">Opsional (JPG, PNG, PDF maks. 5MB)</div>
            </div>

          </div>

        </div>

        {{-- Modal Footer --}}
        <div class="modal-footer bg-white px-4 pb-4 pt-3 border-top-0 d-flex justify-content-end gap-2 flex-wrap">
          <button type="button" class="btn btn-outline-secondary px-3" data-bs-dismiss="modal">
            Batal
          </button>
          <button type="submit" name="submit_action" value="save_and_add" class="btn btn-outline-di px-3">
            <i class="fas fa-plus-circle me-1"></i> Simpan &amp; Tambah
          </button>
          <button type="submit" name="submit_action" value="save" class="btn btn-danger fw-bold px-4" style="background: #CC0000; border-color: #CC0000;">
            <i class="fas fa-save me-1"></i> Simpan Transaksi
          </button>
        </div>
      </form>

    </div>
  </div>
</div>

@push('scripts')
<script>
(function() {
  const modalKatOptions = @json($kategoriOptions ?? []);

  window.handleModalTipeChange = function(tipe) {
    const sel = document.getElementById('modalKategori');
    if (!sel) return;
    sel.innerHTML = '<option value="">Pilih kategori</option>';

    const opts = modalKatOptions[tipe] || {};
    Object.keys(opts).forEach(code => {
      const name = opts[code];
      const optEl = document.createElement('option');
      optEl.value = name;
      optEl.textContent = `[${code}] ${name}`;
      sel.appendChild(optEl);
    });
  };

  window.handleModalSatuanChange = function(sel) {
    const custom = document.getElementById('modalCustomSatuanInput');
    if (!custom) return;
    if (sel.value === '__custom__') {
      custom.style.display = 'block';
      custom.focus();
    } else {
      custom.style.display = 'none';
    }
    recalcModalTotal();
  };

  window.formatRupiahModal = function(el) {
    let val = el.value.replace(/[^0-9]/g, '');
    if (!val) {
      el.value = '';
      return;
    }
    el.value = new Intl.NumberFormat('id-ID').format(val);
  };

  window.recalcModalTotal = function() {
    const volEl = document.getElementById('modalVolume');
    const hargaEl = document.getElementById('modalHargaSatuan');
    const satEl = document.getElementById('modalSatuan');
    const totalTextEl = document.getElementById('modalLiveTotalText');
    const formulaTextEl = document.getElementById('modalLiveFormulaText');
    const hiddenTotalEl = document.getElementById('modalHiddenTotalNominal');

    if (!volEl || !hargaEl || !totalTextEl) return;

    const vol = parseFloat(volEl.value) || 0;
    const rawHarga = hargaEl.value.replace(/[^0-9]/g, '');
    const harga = parseFloat(rawHarga) || 0;
    const total = Math.round(vol * harga);

    const satuan = satEl && satEl.value === '__custom__'
      ? (document.getElementById('modalCustomSatuanInput').value || 'item')
      : (satEl ? (satEl.value || 'paket') : 'paket');

    totalTextEl.innerText = 'Rp ' + new Intl.NumberFormat('id-ID').format(total);
    if (formulaTextEl) {
      formulaTextEl.innerText = vol + ' ' + satuan + ' × Rp ' + new Intl.NumberFormat('id-ID').format(harga);
    }
    if (hiddenTotalEl) {
      hiddenTotalEl.value = total;
    }
  };

  // Inisialisasi kategori awal (penerimaan) saat dokumen siap
  document.addEventListener('DOMContentLoaded', function() {
    handleModalTipeChange('masuk');
    recalcModalTotal();
  });

  // Inisialisasi Summernote pada Modal
  $(document).ready(function() {
    $('#modalTambahTransaksi').on('shown.bs.modal', function () {
      const $desc = $('#modalDeskripsi');
      if (!$desc.next().hasClass('note-editor')) {
        $desc.summernote({
          placeholder: 'Uraian transaksi / rincian kegiatan...',
          height: 140,
          minHeight: 100,
          dialogsInBody: true,
          toolbar: [
            ['style', ['style', 'bold', 'italic', 'underline', 'clear']],
            ['font', ['strikethrough']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['insert', ['link', 'table', 'hr']],
            ['view', ['fullscreen', 'codeview']]
          ]
        });
      }
    });
  });
})();
</script>
@endpush

