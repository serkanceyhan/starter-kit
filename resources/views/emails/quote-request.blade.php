<!DOCTYPE html>
<html>
<head>
    <title>Yeni Teklif Talebi</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <div style="background-color: #f4f4f4; padding: 20px;">
        <div style="background-color: #fff; padding: 20px; border-radius: 5px; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
            <h2 style="color: #2463eb; border-bottom: 2px solid #2463eb; padding-bottom: 10px;">Yeni Teklif Talebi</h2>
            
            <p><strong>Şirket Adı:</strong> {{ data_get($details, 'company_name', '-') }}</p>
            <p><strong>Ad Soyad:</strong> {{ data_get($details, 'name', '-') }}</p>
            <p><strong>E-posta:</strong> {{ data_get($details, 'email', '-') }}</p>
            <p><strong>Hizmet Türü:</strong> {{ data_get($details, 'service_type', '-') }}</p>
            
            <div style="margin-top: 20px; background-color: #f9f9f9; padding: 15px; border-radius: 5px;">
                <strong>Mesaj / Detaylar:</strong><br>
                {!! nl2br(e(data_get($details, 'message') ?? 'Mesaj yok')) !!}
            </div>

            <p style="margin-top: 20px; font-size: 0.9em; color: #777;">Bu e-posta Tamirat.com üzerinden gönderilmiştir.</p>
        </div>
    </div>
</body>
</html>
