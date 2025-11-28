<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f4f6f8; margin: 0; padding: 0; }
        .container { max-width: 600px; margin: 40px auto; background: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,0.05); }

        /* Header Dinamis */
        .header { padding: 30px; text-align: center; color: white; }
        .header.abnormal { background: linear-gradient(135deg, #ff416c, #ff4b2b); } /* Merah Gradasi */
        .header.overrange { background: linear-gradient(135deg, #654ea3, #eaafc8); } /* Ungu Gradasi */

        .icon { font-size: 48px; margin-bottom: 10px; }
        .title { font-size: 24px; font-weight: 800; letter-spacing: 1px; margin: 0; text-transform: uppercase; }
        .subtitle { opacity: 0.9; font-size: 14px; margin-top: 5px; }

        .content { padding: 30px; }
        .info-group { margin-bottom: 20px; border-bottom: 1px solid #eee; padding-bottom: 15px; }
        .info-group:last-child { border-bottom: none; }

        .label { font-size: 12px; color: #888; text-transform: uppercase; letter-spacing: 0.5px; font-weight: 600; display: block; margin-bottom: 4px; }
        .value { font-size: 16px; color: #333; font-weight: 500; }
        .value-large { font-size: 28px; font-weight: bold; color: #dc3545; }

        .btn-action { display: block; width: 100%; padding: 15px; background-color: #333; color: white; text-align: center; text-decoration: none; border-radius: 8px; font-weight: bold; margin-top: 20px; }
        .footer { background-color: #f8f9fa; padding: 20px; text-align: center; font-size: 12px; color: #999; }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header: Warnanya bisa diubah via logic controller nanti -->
        <div class="header abnormal">
            <div class="icon">⚠️</div>
            <h1 class="title">Threshold Alert</h1>
            <div class="subtitle">Data melebihi batas aman (5 Minute Interval)</div>
        </div>

        <div class="content">
            <!-- Lokasi -->
            <div class="info-group">
                <span class="label">Company & Location</span>
                <div class="value">{{ $data['company_name'] }}</div>
                <div class="value" style="color: #666;">{{ $data['stack_name'] }} ({{ $data['stack_code'] }})</div>
            </div>

            <!-- Data Utama -->
            <div class="info-group" style="display: flex; justify-content: space-between; align-items: center;">
                <div>
                    <span class="label">Parameter</span>
                    <div class="value" style="font-size: 20px;">{{ $data['parameter_name'] }}</div>
                </div>
                <div style="text-align: right;">
                    <span class="label">Current Value</span>
                    <div class="value-large">{{ $data['value'] }} <small style="font-size: 14px; color: #888;">{{ $data['unit'] }}</small></div>
                </div>
            </div>

            <!-- Detail Teknis -->
            <div class="info-group">
                <div style="display: flex; justify-content: space-between;">
                    <div>
                        <span class="label">Max Threshold</span>
                        <div class="value">{{ $data['threshold'] }} {{ $data['unit'] }}</div>
                    </div>
                    <div style="text-align: right;">
                        <span class="label">Recorded Time</span>
                        <div class="value">{{ $data['time'] }}</div>
                    </div>
                </div>
            </div>

            <a href="{{ route('dashboard') }}" class="btn-action">Open Dashboard EWS</a>
        </div>

        <div class="footer">
            &copy; {{ date('Y') }} SAMU Early Warning System.<br>
            Automated notification, please do not reply.
        </div>
    </div>
</body>
</html>