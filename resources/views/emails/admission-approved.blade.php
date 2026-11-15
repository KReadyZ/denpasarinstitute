<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Program Disetujui</title>
</head>
<body style="margin: 0; padding: 0; background-color: #f1f5f9; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; color: #1e293b; line-height: 1.6;">

    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="background-color: #f1f5f9; padding: 40px 15px;">
        <tr>
            <td align="center">
                
                {{-- Main Container --}}
                <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="max-width: 620px; background-color: #ffffff; border-radius: 14px; overflow: hidden; box-shadow: 0 10px 25px rgba(0,0,0,0.06); border: 1px solid #e2e8f0;">
                    
                    {{-- Header with Brand Gradient --}}
                    <tr>
                        <td style="background: linear-gradient(135deg, #CC0000 0%, #990000 100%); padding: 36px 30px; text-align: center;">
                            <div style="font-size: 13px; font-weight: 700; letter-spacing: 2.5px; text-transform: uppercase; color: #fde047; margin-bottom: 6px;">
                                DENPASAR INSTITUTE
                            </div>
                            <h1 style="margin: 0; color: #ffffff; font-size: 24px; font-weight: 800; letter-spacing: -0.5px;">
                                Konfirmasi Pendaftaran Program
                            </h1>
                            <div style="margin-top: 14px; display: inline-block; background-color: rgba(255, 255, 255, 0.18); border: 1px solid rgba(255, 255, 255, 0.35); padding: 6px 16px; border-radius: 999px; color: #ffffff; font-size: 12px; font-weight: 600;">
                                ✓ Status: Pendaftaran Disetujui (Approved)
                            </div>
                        </td>
                    </tr>

                    {{-- Body Content --}}
                    <tr>
                        <td style="padding: 36px 32px 28px;">
                            
                            <p style="margin: 0 0 16px; font-size: 16px; color: #334155;">
                                Yth. Sdr/Sdri <strong>{{ $admission->nama_lengkap }}</strong>,
                            </p>

                            <p style="margin: 0 0 24px; font-size: 15px; color: #475569; line-height: 1.7;">
                                Terima kasih telah mendaftar di <strong>Denpasar Institute</strong>. Kami menginformasikan bahwa berkas dan pembayaran pendaftaran Anda telah diverifikasi oleh tim admin dan secara resmi dinyatakan <strong>DISETUJUI (APPROVED)</strong>.
                            </p>

                            {{-- Summary Card --}}
                            <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="background-color: #f8fafc; border: 1.5px solid #e2e8f0; border-radius: 10px; margin-bottom: 24px; overflow: hidden;">
                                <tr>
                                    <td colspan="2" style="background-color: #f1f5f9; padding: 12px 18px; border-bottom: 1.5px solid #e2e8f0; font-size: 13px; font-weight: 700; color: #334155; text-transform: uppercase; letter-spacing: 0.5px;">
                                        Rincian Pendaftaran Peserta
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 12px 18px; font-size: 13px; color: #64748b; width: 38%; border-bottom: 1px solid #e2e8f0;">
                                        Nama Lengkap
                                    </td>
                                    <td style="padding: 12px 18px; font-size: 14px; font-weight: 700; color: #0f172a; border-bottom: 1px solid #e2e8f0;">
                                        {{ $admission->nama_lengkap }}
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 12px 18px; font-size: 13px; color: #64748b; border-bottom: 1px solid #e2e8f0;">
                                        Program Kursus / Pelatihan
                                    </td>
                                    <td style="padding: 12px 18px; font-size: 14px; font-weight: 700; color: #CC0000; border-bottom: 1px solid #e2e8f0;">
                                        {{ $programNames }}
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 12px 18px; font-size: 13px; color: #64748b; border-bottom: 1px solid #e2e8f0;">
                                        Nominal Pembayaran
                                    </td>
                                    <td style="padding: 12px 18px; font-size: 14px; font-weight: 700; color: #16a34a; border-bottom: 1px solid #e2e8f0;">
                                        Rp {{ number_format($admission->nominal_pembayaran ?? 0, 0, ',', '.') }}
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 12px 18px; font-size: 13px; color: #64748b; border-bottom: 1px solid #e2e8f0;">
                                        Metode Pembayaran
                                    </td>
                                    <td style="padding: 12px 18px; font-size: 13px; color: #0f172a; border-bottom: 1px solid #e2e8f0;">
                                        {{ $admission->metode_pembayaran ?: 'Transfer Bank' }}
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 12px 18px; font-size: 13px; color: #64748b;">
                                        Nomor WhatsApp / HP
                                    </td>
                                    <td style="padding: 12px 18px; font-size: 13px; color: #0f172a;">
                                        {{ $admission->hp_wa }}
                                    </td>
                                </tr>
                            </table>

                            @if($admission->catatan_admin)
                            {{-- Catatan Khusus dari Admin --}}
                            <div style="background-color: #fefce8; border: 1px solid #fef08a; border-left: 4px solid #eab308; padding: 14px 18px; border-radius: 6px; margin-bottom: 24px;">
                                <div style="font-size: 12px; font-weight: 700; color: #854d0e; text-transform: uppercase; margin-bottom: 4px;">
                                    Catatan dari Tim Admin:
                                </div>
                                <div style="font-size: 13px; color: #713f12; line-height: 1.5;">
                                    {!! nl2br(e($admission->catatan_admin)) !!}
                                </div>
                            </div>
                            @endif

                            {{-- Steps Guidance --}}
                            <div style="background-color: #f0fdf4; border-left: 4px solid #16a34a; padding: 16px 20px; border-radius: 0 8px 8px 0; margin-bottom: 28px;">
                                <h4 style="margin: 0 0 8px; font-size: 14px; color: #166534; font-weight: 700;">
                                    Informasi & Langkah Selanjutnya:
                                </h4>
                                <ol style="margin: 0; padding-left: 18px; font-size: 13px; color: #14532d; line-height: 1.6;">
                                    <li style="margin-bottom: 6px;">Tim instruktur atau sekretariat Denpasar Institute akan segera menghubungi nomor WhatsApp Anda (<strong>{{ $admission->hp_wa }}</strong>) untuk konfirmasi jadwal kelas, silabus materi, dan orientasi program.</li>
                                    <li style="margin-bottom: 6px;">Simpan email konfirmasi ini sebagai bukti pendaftaran resmi Anda.</li>
                                    <li>Jika Anda mengambil skema DP (Uang Muka), informasi sisa pelunasan dan bukti setoran akan disampaikan saat perkuliahan/kursus dimulai.</li>
                                </ol>
                            </div>

                            <p style="margin: 0 0 8px; font-size: 14px; color: #475569;">
                                Jika Anda memiliki pertanyaan seputar jadwal atau materi program, silakan hubungi tim kami:
                            </p>
                            <p style="margin: 0 0 24px; font-size: 13px; color: #64748b; line-height: 1.8;">
                                • WhatsApp Admin: <a href="https://wa.me/6282144814593" style="color: #16a34a; text-decoration: none; font-weight: 600;">+62 821-4481-4593</a><br>
                                • WhatsApp Layanan: <a href="https://wa.me/6282318666547" style="color: #16a34a; text-decoration: none; font-weight: 600;">+62 823-1866-6547</a><br>
                                • Email: <a href="mailto:info@denpasarinstitute.id" style="color: #CC0000; text-decoration: none;">info@denpasarinstitute.id</a><br>
                                • Website: <a href="https://denpasarinstitute.id" style="color: #CC0000; text-decoration: none;">denpasarinstitute.id</a>
                            </p>

                            <p style="margin: 0; font-size: 14px; color: #334155;">
                                Salam hormat & sukses selalu,<br>
                                <strong>Sekretariat Denpasar Institute</strong><br>
                                <span style="font-size: 12px; color: #94a3b8;">"Transforming Ideas into Action"</span>
                            </p>

                        </td>
                    </tr>

                    {{-- Footer --}}
                    <tr>
                        <td style="background-color: #0f172a; padding: 22px 24px; text-align: center; color: #94a3b8; font-size: 12px; line-height: 1.6;">
                            <p style="margin: 0 0 4px; color: #cbd5e1; font-weight: 600;">
                                Denpasar Institute &bull; Bali, Indonesia
                            </p>
                            <p style="margin: 0; color: #64748b;">
                                Email ini dikirimkan secara otomatis oleh sistem penerimaan peserta resmi Denpasar Institute.
                            </p>
                        </td>
                    </tr>

                </table>

            </td>
        </tr>
    </table>

</body>
</html>

