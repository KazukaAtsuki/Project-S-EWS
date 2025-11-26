<!DOCTYPE html>
<html>
<head>
    <title>EWS Alert</title>
</head>
<body style="font-family: Arial, sans-serif; color: #333;">
    <div style="border: 1px solid #ff3e1d; padding: 20px; border-radius: 8px;">
        <h2 style="color: #ff3e1d;">🚨 EWS THRESHOLD ALERT!</h2>
        <p>Sistem mendeteksi nilai parameter melebihi batas aman.</p>

        <table style="width: 100%; border-collapse: collapse; margin-top: 20px;">
            <tr>
                <td style="padding: 8px; font-weight: bold;">Company:</td>
                <td style="padding: 8px;">{{ $data['company_name'] }}</td>
            </tr>
            <tr>
                <td style="padding: 8px; font-weight: bold;">Stack (Lokasi):</td>
                <td style="padding: 8px;">{{ $data['stack_name'] }} ({{ $data['stack_code'] }})</td>
            </tr>
            <tr>
                <td style="padding: 8px; font-weight: bold;">Parameter:</td>
                <td style="padding: 8px;">{{ $data['parameter_name'] }}</td>
            </tr>
            <tr style="background-color: #ffe5e5;">
                <td style="padding: 8px; font-weight: bold;">Nilai Terbaca:</td>
                <td style="padding: 8px; color: #ff3e1d; font-weight: bold;">{{ $data['value'] }} {{ $data['unit'] }}</td>
            </tr>
            <tr>
                <td style="padding: 8px; font-weight: bold;">Batas Aman:</td>
                <td style="padding: 8px;">{{ $data['threshold'] }} {{ $data['unit'] }}</td>
            </tr>
            <tr>
                <td style="padding: 8px; font-weight: bold;">Waktu:</td>
                <td style="padding: 8px;">{{ $data['time'] }}</td>
            </tr>
        </table>

        <p style="margin-top: 20px;">Mohon segera dilakukan pengecekan di lapangan.</p>
        <hr>
        <small>SAMU EWS Notification System</small>
    </div>
</body>
</html>