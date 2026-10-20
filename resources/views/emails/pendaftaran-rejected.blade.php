<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pemberitahuan Status Pendaftaran</title>
</head>
<body style="margin: 0; padding: 0; background-color: #f1f5f9; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; color: #1e293b; line-height: 1.6;">

    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="background-color: #f1f5f9; padding: 40px 15px;">
        <tr>
            <td align="center">
                
                <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="max-width: 620px; background-color: #ffffff; border-radius: 14px; overflow: hidden; box-shadow: 0 10px 25px rgba(0,0,0,0.06); border: 1px solid #e2e8f0;">
                    
                    {{-- Header --}}
                    <tr>
                        <td style="background: linear-gradient(135deg, #475569 0%, #334155 100%); padding: 36px 30px; text-align: center;">
                            <div style="font-size: 13px; font-weight: 700; letter-spacing: 2.5px; text-transform: uppercase; color: #fde047; margin-bottom: 6px;">
                                DENPASAR INSTITUTE
                            </div>
                            <h1 style="margin: 0; color: #ffffff; font-size: 22px; font-weight: 800; letter-spacing: -0.5px;">
                                Pemberitahuan Status Pendaftaran
                            </h1>
                        </td>
                    </tr>

                    {{-- Body Content --}}
                    <tr>
                        <td style="padding: 36px 32px 28px;">
                            
                            <p style="margin: 0 0 16px; font-size: 16px; color: #334155;">
                                Yth. Bapak/Ibu <strong>{{ $user->name }}</strong>,
                            </p>

                            <p style="margin: 0 0 20px; font-size: 15px; color: #475569; line-height: 1.7;">
                                Terima kasih atas minat Anda untuk bergabung sebagai <strong>{{ $roleTitle }}</strong> di Denpasar Institute.
                            </p>

                            <p style="margin: 0 0 20px; font-size: 15px; color: #475569; line-height: 1.7;">
                                Setelah melalui proses peninjauan dan verifikasi berkas oleh Tim Super Admin, kami menyampaikan permohonan maaf bahwa pendaftaran Anda saat ini <strong>belum dapat disetujui</strong> dengan alasan sebagai berikut:
                            </p>

                            {{-- Rejection Reason Box --}}
                            <div style="background-color: #fef2f2; border: 1.5px solid #fecaca; border-radius: 8px; padding: 18px 20px; margin-bottom: 24px;">
                                <div style="font-size: 13px; font-weight: 700; color: #991b1b; text-transform: uppercase; margin-bottom: 6px;">
                                    Catatan / Alasan Verifikasi:
                                </div>
                                <div style="font-size: 14px; color: #7f1d1d; font-style: italic;">
                                    "{{ $reason }}"
                                </div>
                            </div>

                            <p style="margin: 0 0 24px; font-size: 14px; color: #475569; line-height: 1.7;">
                                Anda dapat melakukan perbaikan berkas dan mendaftar kembali melalui formulir pendaftaran resmi pada tautan berikut:
                            </p>

                            <div style="text-align: center; margin: 24px 0;">
                                <a href="{{ $registerUrl }}" target="_blank" rel="noopener noreferrer" style="background-color: #CC0000; color: #ffffff; padding: 12px 28px; border-radius: 6px; font-weight: 700; font-size: 14px; text-decoration: none; display: inline-block;">
                                    Daftar Kembali &rarr;
                                </a>
                            </div>

                            <p style="margin: 0 0 8px; font-size: 14px; color: #475569;">
                                Apabila Anda memiliki pertanyaan lebih lanjut, silakan hubungi tim kami:
                            </p>
                            <p style="margin: 0 0 24px; font-size: 13px; color: #64748b; line-height: 1.8;">
                                • WhatsApp Admin 1: <a href="https://wa.me/6282144814593" style="color: #16a34a; text-decoration: none; font-weight: 600;">+62 821-4481-4593</a><br>
                                • WhatsApp Layanan 2: <a href="https://wa.me/6282318666547" style="color: #16a34a; text-decoration: none; font-weight: 600;">+62 823-1866-6547</a><br>
                                • Email: <a href="mailto:info@denpasarinstitute.id" style="color: #CC0000; text-decoration: none;">info@denpasarinstitute.id</a>
                            </p>

                            <p style="margin: 0; font-size: 14px; color: #334155;">
                                Salam hormat,<br>
                                <strong>Sekretariat Denpasar Institute</strong>
                            </p>

                        </td>
                    </tr>

                    {{-- Footer --}}
                    <tr>
                        <td style="background-color: #0f172a; padding: 20px 24px; text-align: center; color: #94a3b8; font-size: 12px;">
                            <p style="margin: 0; color: #cbd5e1;">Denpasar Institute &bull; Bali, Indonesia</p>
                        </td>
                    </tr>

                </table>

            </td>
        </tr>
    </table>

</body>
</html>
