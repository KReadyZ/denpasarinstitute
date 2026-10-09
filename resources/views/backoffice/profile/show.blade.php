{{--
    PARTIAL: E-CARD ANGGOTA (DINAMIS)
    ---------------------------------
    Dipasang di resources/views/backoffice/profile/show.blade.php
    (halaman profil dengan banner merah, dipakai ProfileController::show),
    dengan:

        @include('backoffice.partials.ecard', ['user' => $user])

    $user wajib punya relasi/kolom: name, no_anggota, foto/avatar,
    tanggal_lahir, berlaku_sd, role, position/praktisi_bidang.
--}}

@php
    $user = $user ?? $konsultan;
    $fotoUrl = $user->foto
        ? asset('storage/' . $user->foto)
        : ($user->avatar
            ? asset('storage/' . $user->avatar)
            : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=CC0000&color=fff&size=300');

    $sudahPunyaKartu = !empty($user->no_anggota);
    $bisaGenerate = !empty($user->tanggal_lahir); // generateNoAnggota butuh tanggal_lahir
    $berlakuSd = $user->berlaku_sd ? \Carbon\Carbon::parse($user->berlaku_sd) : null;
    $expired = $berlakuSd ? $berlakuSd->isPast() : false;
    $isAdmin = auth()->check() && auth()->user()->role === 'superadmin';
@endphp

<div class="card" style="margin-bottom:25px;">
    <div class="card-header">
        <h3><i class="fas fa-id-card"></i> Kartu Anggota Digital</h3>
    </div>
    <div class="card-body">

        @if(!$sudahPunyaKartu)
            {{-- BELUM PUNYA NO. ANGGOTA --}}
            <div style="text-align:center; padding:30px 10px;">
                <i class="fas fa-id-badge" style="font-size:48px; color:#ccc;"></i>
                <p style="margin:15px 0; color:#666;">
                    Anda belum memiliki nomor anggota, sehingga kartu anggota belum bisa diterbitkan.
                </p>

                @if(!$bisaGenerate)
                    <p style="color:#cc0000; font-size:0.9rem;">
                        <i class="fas fa-exclamation-circle"></i>
                        @if($isAdmin)
                            Lengkapi <strong>Tanggal Lahir</strong> pada profil anggota ini terlebih dahulu sebelum menerbitkan kartu.
                        @else
                            Lengkapi <strong>Tanggal Lahir</strong> pada profil Anda terlebih dahulu, lalu hubungi admin untuk menerbitkan kartu.
                        @endif
                    </p>
                @elseif($isAdmin)
                    <form action="{{ route('backoffice.profile.ecard.generate', $user->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-magic"></i> Generate e-Card
                        </button>
                    </form>
                @else
                    <p style="color:#666; font-size:0.9rem;">
                        Kartu anggota belum diterbitkan oleh admin. Silakan hubungi admin Denpasar Institute.
                    </p>
                @endif
            </div>

        @else
            {{-- SUDAH PUNYA KARTU --}}
            <div style="display:flex; flex-wrap:wrap; gap:10px; margin-bottom:20px;">
                <button type="button" id="btn-download-ecard" class="btn btn-primary">
                    <i class="fas fa-download"></i> Unduh Kartu
                </button>

                <form action="{{ route('backoffice.profile.ecard.renew', $user->id) }}" method="POST" onsubmit="return confirm('Perpanjang masa berlaku kartu 1 tahun dari hari ini?');">
                    @csrf
                    <button type="submit" class="btn btn-warning">
                        <i class="fas fa-redo"></i> Perpanjang Masa Berlaku
                    </button>
                </form>

                @if($expired)
                    <span style="align-self:center; color:#cc0000; font-weight:600;">
                        <i class="fas fa-exclamation-triangle"></i> Kartu sudah kedaluwarsa, silakan perpanjang.
                    </span>
                @endif
            </div>

            {{-- WRAPPER YANG DI-CAPTURE UNTUK DIUNDUH --}}
            <div id="ecard-capture-area" style="display:flex; flex-wrap:wrap; gap:25px; justify-content:center;">

                {{-- ===== HALAMAN DEPAN ===== --}}
                <div id="ecard-front" style="width:380px; border-radius:16px; overflow:hidden; box-shadow:0 6px 20px rgba(0,0,0,0.12); background:#fff; font-family:'Segoe UI',Tahoma,Geneva,Verdana,sans-serif;">
                    <div style="background:#fff; padding:18px 20px 10px 20px; display:flex; align-items:center; gap:12px; border-bottom:4px solid #CC0000;">
                        <div style="width:46px; height:46px; border-radius:50%; background:#CC0000; display:flex; align-items:center; justify-content:center; color:#fff; font-weight:bold; flex-shrink:0;">
                            DI
                        </div>
                        <div>
                            <div style="font-weight:800; font-size:1.05rem; color:#111; letter-spacing:0.5px;">DENPASAR INSTITUTE</div>
                            <div style="font-size:0.65rem; color:#666; letter-spacing:0.5px;">LEMBAGA RISET &amp; PENGEMBANGAN SDM</div>
                        </div>
                    </div>

                    <div style="position:relative; padding:18px 20px 60px 20px; background:linear-gradient(135deg,#fdfdfd,#f3f3f3);">
                        <div style="font-size:0.8rem; color:#444; margin-bottom:2px;">Kartu Anggota</div>
                        <div style="font-size:0.78rem; color:#444;">Nama :</div>
                        <div style="font-size:1.15rem; font-weight:800; color:#111; margin-bottom:6px;">{{ $user->name }}</div>
                        <div style="font-size:0.78rem; color:#444;">No.</div>
                        <div style="font-size:0.95rem; font-weight:700; color:#CC0000; margin-bottom:6px;">{{ $user->no_anggota }}</div>
                        <div style="font-size:0.8rem; color:#666; text-transform:capitalize;">{{ $user->role }}</div>

                        <img src="{{ $fotoUrl }}" alt="Foto" style="position:absolute; top:16px; right:18px; width:90px; height:90px; object-fit:cover; border-radius:8px; border:3px solid #fff; box-shadow:0 3px 10px rgba(0,0,0,0.2);">

                        <div style="position:absolute; left:20px; bottom:16px; font-size:0.65rem; color:#444;">
                            Berlaku s.d<br>
                            <strong>{{ $berlakuSd ? $berlakuSd->format('d-m-Y') : '-' }}</strong>
                        </div>
                    </div>

                    <div style="background:#CC0000; color:#fff; text-align:center; font-size:0.68rem; font-weight:700; letter-spacing:0.5px; padding:8px;">
                        KARTU INI ADALAH BUKTI KEANGGOTAAN {{ strtoupper($user->role) }} DI DENPASAR INSTITUTE
                    </div>
                </div>

                {{-- ===== HALAMAN BELAKANG ===== --}}
                <div id="ecard-back" style="width:380px; border-radius:16px; overflow:hidden; box-shadow:0 6px 20px rgba(0,0,0,0.12); background:#fff; font-family:'Segoe UI',Tahoma,Geneva,Verdana,sans-serif;">
                    <div style="background:#CC0000; color:#fff; padding:18px 20px;">
                        <div style="font-weight:800; font-size:1.05rem;">DENPASAR INSTITUTE</div>
                        <div style="font-size:0.65rem; opacity:0.9;">LEMBAGA RISET &amp; PENGEMBANGAN SDM</div>
                    </div>
                    <div style="padding:20px;">
                        <strong style="font-size:0.9rem;">Ketentuan</strong>
                        <ol style="font-size:0.78rem; color:#333; padding-left:18px; margin:8px 0 20px 0; line-height:1.6;">
                            <li>Pemegang kartu ini adalah Anggota {{ ucfirst($user->role) }} Denpasar Institute</li>
                            <li>Kartu wajib dibawa saat melaksanakan kegiatan yang berkaitan dengan Denpasar Institute</li>
                            <li>Setiap anggota wajib menjaga nama baik lembaga</li>
                        </ol>
                        <div style="font-size:0.7rem; color:#666;">
                            Bagi yang menemukan kartu ini harap hubungi Denpasar Institute<br>
                            www.denpasarinstitute.com
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

@if($sudahPunyaKartu)
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script>
document.getElementById('btn-download-ecard').addEventListener('click', async function () {
    const btn = this;
    const original = btn.innerHTML;
    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Memproses...';

    try {
        const targets = [
            { el: document.getElementById('ecard-front'), name: 'kartu-anggota-depan' },
            { el: document.getElementById('ecard-back'), name: 'kartu-anggota-belakang' },
        ];

        for (const t of targets) {
            const canvas = await html2canvas(t.el, { scale: 3, backgroundColor: '#ffffff' });
            const link = document.createElement('a');
            link.download = t.name + '-{{ \Illuminate\Support\Str::slug($user->name) }}.png';
            link.href = canvas.toDataURL('image/png');
            link.click();
            await new Promise(r => setTimeout(r, 300)); // jeda antar-download
        }
    } catch (e) {
        alert('Gagal mengunduh kartu, coba lagi.');
        console.error(e);
    } finally {
        btn.disabled = false;
        btn.innerHTML = original;
    }
});
</script>
@endif