<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verificação de Email — ETECGames</title>
</head>
<body style="margin:0;padding:0;background:#0f1117;font-family:'Helvetica Neue',Helvetica,Arial,sans-serif;">

    <table width="100%" cellpadding="0" cellspacing="0" style="background:#0f1117;padding:40px 16px;">
        <tr>
            <td align="center">
                <table width="100%" cellpadding="0" cellspacing="0" style="max-width:520px;">

                    <!-- LOGO -->
                    <tr>
                        <td align="center" style="padding-bottom:32px;">
                            <span style="font-size:1.2rem;font-weight:800;color:#f0f0f8;letter-spacing:-0.01em;">
                                <span style="color:#6e42ca;">[</span>ETEC<span style="color:#a67eec;">Games</span><span style="color:#6e42ca;">]</span>
                            </span>
                        </td>
                    </tr>

                    <!-- CARD -->
                    <tr>
                        <td style="background:#13151f;border:1px solid #1c1e2e;border-radius:16px;padding:40px 36px;">

                            <!-- ICON -->
                            <table width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td align="center" style="padding-bottom:24px;">
                                        <div style="display:inline-block;width:56px;height:56px;background:rgba(110,66,202,0.12);border:1px solid rgba(110,66,202,0.25);border-radius:50%;text-align:center;line-height:56px;font-size:24px;">
                                            ✉️
                                        </div>
                                    </td>
                                </tr>
                            </table>

                            <!-- TÍTULO -->
                            <h1 style="margin:0 0 8px;font-size:1.5rem;font-weight:800;color:#f0f0f8;text-align:center;letter-spacing:-0.02em;">
                                Verifique seu email
                            </h1>
                            <p style="margin:0 0 32px;font-size:0.9rem;color:#7b7f96;text-align:center;line-height:1.6;">
                                Olá, <strong style="color:#f0f0f8;">{{ $user->name }}</strong>! Use o código abaixo para confirmar seu email institucional no ETECGames.
                            </p>

                            <!-- CÓDIGO OTP -->
                            <table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom:32px;">
                                <tr>
                                    <td align="center">
                                        <div style="display:inline-block;background:#0a0b10;border:1px solid #2a2d3e;border-radius:12px;padding:20px 40px;">
                                            <span style="font-size:2.2rem;font-weight:800;color:#a67eec;letter-spacing:0.25em;font-family:'Courier New',monospace;">
                                                {{ $otp }}
                                            </span>
                                        </div>
                                    </td>
                                </tr>
                            </table>

                            <!-- AVISO EXPIRAÇÃO -->
                            <table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom:32px;">
                                <tr>
                                    <td style="background:rgba(110,66,202,0.08);border:1px solid rgba(110,66,202,0.2);border-radius:8px;padding:12px 16px;">
                                        <p style="margin:0;font-size:0.82rem;color:#7b7f96;text-align:center;">
                                            ⏱️ Este código expira em <strong style="color:#a67eec;">5 minutos</strong>. Não compartilhe com ninguém.
                                        </p>
                                    </td>
                                </tr>
                            </table>

                            <!-- DIVISOR -->
                            <hr style="border:none;border-top:1px solid #1c1e2e;margin:0 0 24px;">

                            <!-- RODAPÉ DO CARD -->
                            <p style="margin:0;font-size:0.78rem;color:#555878;text-align:center;line-height:1.6;">
                                Se você não criou uma conta no ETECGames, ignore este email.
                            </p>

                        </td>
                    </tr>

                    <!-- RODAPÉ -->
                    <tr>
                        <td align="center" style="padding-top:24px;">
                            <p style="margin:0;font-size:0.75rem;color:#3a3d52;">
                                ETECGames · Plataforma de jogos das ETECs de São Paulo
                            </p>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>

</body>
</html>