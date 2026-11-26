<!doctype html><html lang="es"><head><meta charset="utf-8"><title>Recupera tu acceso</title></head>
<body style="margin:0;background:#f2f6f9;font-family:Arial,sans-serif;color:#152b3b;padding:40px 16px">
<div style="max-width:520px;margin:auto;background:#fff;border-radius:20px;padding:40px">
<p style="font-size:22px;font-weight:bold;color:#007daf">ofertas<span style="font-weight:normal">tienda</span></p>
<p style="font-size:12px;color:#647887;letter-spacing:2px">MONITOR DE LEADS</p>
<h1 style="font-size:28px">Recupera tu acceso</h1>
<p style="line-height:1.7">Recibimos una solicitud para cambiar la contraseña de tu cuenta. Usa el siguiente enlace para crear una nueva.</p>
<p style="margin:30px 0"><a href="{{ $url }}" style="display:inline-block;padding:16px 24px;background:#007fad;color:#fff;text-decoration:none;border-radius:10px;font-weight:bold">Restablecer contraseña</a></p>
<p style="line-height:1.7">El enlace caduca en {{ $minutes }} minutos y solo se puede utilizar una vez. Si no solicitaste este cambio, puedes ignorar este correo.</p>
<hr style="border:0;border-top:1px solid #e5edf2;margin:28px 0"><p style="font-size:12px;color:#647887;line-height:1.6">Si el botón no funciona, abre este enlace:<br><a href="{{ $url }}" style="color:#007fad;word-break:break-all">{{ $url }}</a></p>
</div></body></html>
