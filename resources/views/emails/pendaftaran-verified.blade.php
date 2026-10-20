<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Keanggotaan Disetujui</title>
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
                                Konfirmasi Verifikasi Keanggotaan
                            </h1>
                            <div style="margin-top: 14px; display: inline-block; background-color: rgba(255, 255, 255, 0.18); border: 1px solid rgba(255, 255, 255, 0.35); padding: 6px 16px; border-radius: 999px; color: #ffffff; font-size: 12px; font-weight: 600;">
                                ✓ Status: Disetujui & Aktif
                            </div>
                        </td>
                    </tr>

                    {{-- Body Content --}}
                    <tr>
                        <td style="padding: 36px 32px 28px;">
                            
                            <p style="margin: 0 0 16px; font-size: 16px; color: #334155;">
                                Yth. Bapak/Ibu <strong>{{ $user->name }}</strong>,
                            </p>

                            <p style="margin: 0 0 24px; font-size: 15px; color: #475569; line-height: 1.7;">
                                Selamat! Berkas dan data pendaftaran Anda sebagai <strong>{{ $roleTitle }}</strong> di <strong>Denpasar Institute</strong> telah diverifikasi oleh Tim Super Admin dan secara resmi dinyatakan <strong>DISETUJUI (APPROVED)</strong>.
                            </p>

                            {{-- Account Summary Card --}}
                            <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="background-color: #f8fafc; border: 1.5px solid #e2e8f0; border-radius: 10px; margin-bottom: 28px; overflow: hidden;">
                                <tr>
                                    <td colspan="2" style="background-color: #f1f5f9; padding: 12px 18px; border-bottom: 1.5px solid #e2e8f0; font-size: 13px; font-weight: 700; color: #334155; text-transform: uppercase; letter-spacing: 0.5px;">
                                        Rincian Keanggotaan Resmi
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 12px 18px; font-size: 13px; color: #64748b; width: 38%; border-bottom: 1px solid #e2e8f0;">
                                        Nomor Anggota (KTA)
                                    </td>
                                    <td style="padding: 12px 18px; font-size: 14px; font-weight: 800; color: #CC0000; font-family: 'Courier New', Courier, monospace; letter-spacing: 1px; border-bottom: 1px solid #e2e8f0;">
                                        {{ $user->no_anggota ?? '-' }}
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 12px 18px; font-size: 13px; color: #64748b; border-bottom: 1px solid #e2e8f0;">
                                        Peran / Divisi
                                    </td>
                                    <td style="padding: 12px 18px; font-size: 13px; font-weight: 700; color: #0f172a; border-bottom: 1px solid #e2e8f0;">
                                        {{ $roleTitle }}
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 12px 18px; font-size: 13px; color: #64748b; border-bottom: 1px solid #e2e8f0;">
                                        Masa Berlaku
                                    </td>
                                    <td style="padding: 12px 18px; font-size: 13px; color: #0f172a; border-bottom: 1px solid #e2e8f0;">
                                        {{ $user->berlaku_sd ? $user->berlaku_sd->format('d F Y') : '-' }}
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 12px 18px; font-size: 13px; color: #64748b;">
                                        Email Login
                                    </td>
                                    <td style="padding: 12px 18px; font-size: 13px; color: #0f172a;">
                                        <strong>{{ $user->email }}</strong>
                                    </td>
                                </tr>
                            </table>

                            {{-- Call To Action Button --}}
                            <div style="text-align: center; margin: 32px 0;">
                                <a href="{{ $loginUrl }}" target="_blank" rel="noopener noreferrer" style="background-color: #CC0000; color: #ffffff; padding: 14px 34px; border-radius: 8px; font-weight: 700; font-size: 15px; text-decoration: none; display: inline-block; box-shadow: 0 4px 12px rgba(204, 0, 0, 0.28); letter-spacing: 0.3px;">
                                    Login ke Dashboard &rarr;
                                </a>
                            </div>

                            {{-- Steps Guidance --}}
                            <div style="background-color: #fef2f2; border-left: 4px solid #CC0000; padding: 16px 20px; border-radius: 0 8px 8px 0; margin-bottom: 28px;">
                                <h4 style="margin: 0 0 8px; font-size: 14px; color: #991b1b; font-weight: 700;">
                                    Langkah Selanjutnya:
                                </h4>
                                <ol style="margin: 0; padding-left: 18px; font-size: 13px; color: #7f1d1d; line-height: 1.6;">
                                    <li style="margin-bottom: 6px;">Login dengan email Anda dan kata sandi yang telah Anda buat pada saat pendaftaran.</li>
                                    <li style="margin-bottom: 6px;">Buka menu <strong>Profil Saya</strong> untuk melihat dan mengunduh <strong>Kartu Tanda Anggota (e-KTA)</strong> resmi Anda.</li>
                                    <li>Lengkapi biodata keahlian, publikasi ilmiah, dan portofolio riset Anda agar dapat terhubung dengan peluang proyek dan jejaring riset.</li>
                                </ol>
                            </div>

                            <p style="margin: 0 0 8px; font-size: 14px; color: #475569;">
                                Jika Anda membutuhkan bantuan atau mengalami kendala dalam mengakses akun, silakan hubungi tim kami:
                            </p>
                            <p style="margin: 0 0 24px; font-size: 13px; color: #64748b; line-height: 1.8;">
                                • WhatsApp Admin 1: <a href="https://wa.me/6282144814593" style="color: #16a34a; text-decoration: none; font-weight: 600;">+62 821-4481-4593</a><br>
                                • WhatsApp Layanan 2: <a href="https://wa.me/6282318666547" style="color: #16a34a; text-decoration: none; font-weight: 600;">+62 823-1866-6547</a><br>
                                • Email: <a href="mailto:info@denpasarinstitute.id" style="color: #CC0000; text-decoration: none;">info@denpasarinstitute.id</a>
                            </p>

                            <p style="margin: 0; font-size: 14px; color: #334155;">
                                Salam hangat,<br>
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
                                Email ini dikirimkan secara otomatis dari sistem pendaftaran resmi Denpasar Institute. Mohon tidak membalas langsung ke alamat email sistem ini.
                            </p>
                        </td>
                    </tr>

                </table>

            </td>
        </tr>
    </table>

</body>
</html>
