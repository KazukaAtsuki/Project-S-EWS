<!DOCTYPE html>
<html>
<head>
    <title>New Ticket</title>
</head>
<body style="font-family: Arial, sans-serif; color: #333;">
    <div style="border: 1px solid #1E6BA8; padding: 20px; border-radius: 8px;">
        <h2 style="color: #1E6BA8;">🎫 New Support Ticket Created</h2>
        <p>Halo Admin, ada laporan tiket baru yang perlu ditinjau.</p>

        <ul style="line-height: 1.6;">
            <li><strong>Subject:</strong> {{ $ticket['subject'] }}</li>
            <li><strong>Issuer:</strong> {{ $ticket['issuer_name'] }}</li>
            <li><strong>Priority:</strong> {{ $ticket['priority'] }}</li>
            <li><strong>Date:</strong> {{ $ticket['created_at'] }}</li>
        </ul>

        <p style="background-color: #f8f9fa; padding: 15px; border-radius: 5px;">
            <em>"{{ $ticket['description'] }}"</em>
        </p>

        <p>Silakan login ke dashboard untuk menindaklanjuti.</p>
        <hr>
        <small>SAMU Helpdesk System</small>
    </div>
</body>
</html>