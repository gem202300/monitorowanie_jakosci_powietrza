<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('emails.device_report.title') }}</title>
    <style>
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-color: #f5f5f5;
        margin: 0;
        padding: 0;
    }

    .email-container {
        max-width: 600px;
        margin: 20px auto;
        background-color: #ffffff;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        overflow: hidden;
    }

    .header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 30px 20px;
        text-align: center;
    }

    .header h1 {
        margin: 0;
        font-size: 24px;
    }

    .content {
        padding: 30px 20px;
    }

    .greeting {
        font-size: 16px;
        margin-bottom: 20px;
        color: #333;
    }

    .report-section {
        background-color: #f9f9f9;
        border-left: 4px solid #667eea;
        padding: 15px;
        margin: 20px 0;
        border-radius: 4px;
    }

    .report-section h3 {
        margin-top: 0;
        color: #667eea;
        font-size: 14px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .report-item {
        margin: 10px 0;
        font-size: 14px;
        color: #555;
    }

    .report-item strong {
        color: #333;
        display: inline-block;
        width: 120px;
    }

    .reason-badge {
        display: inline-block;
        background-color: #667eea;
        color: white;
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: bold;
    }

    .description-box {
        background-color: #fafafa;
        border: 1px solid #e0e0e0;
        padding: 12px;
        border-radius: 4px;
        margin-top: 10px;
        font-size: 14px;
        color: #666;
        line-height: 1.6;
    }

    .footer {
        background-color: #f5f5f5;
        padding: 20px;
        text-align: center;
        font-size: 12px;
        color: #999;
        border-top: 1px solid #eee;
    }

    .button {
        display: inline-block;
        background-color: #667eea;
        color: white;
        padding: 12px 30px;
        border-radius: 4px;
        text-decoration: none;
        font-size: 14px;
        font-weight: bold;
        margin-top: 20px;
    }

    .button:hover {
        background-color: #764ba2;
    }
    </style>
</head>

<body>
    <div class="email-container">
        <div class="header">
            <h1>{{ __('emails.device_report.title') }}</h1>
            @if(!empty($type))
                <p style="margin-top:8px;font-size:13px;opacity:0.95">
                <strong>{{ __('emails.device_report.type_label') }}:</strong>
                <span style="display:inline-block;padding:4px 10px;border-radius:12px;background-color:#fff;color:#333;font-weight:600;margin-left:8px;">
                    {{ strtoupper($type) }}
                </span>
            </p>
            @endif
        </div>

        <div class="content">
            <p class="greeting">{{ __('emails.greeting', ['name' => $serviceman_name]) }}</p>
            <p>{{ __('emails.device_report.intro') }}</p>

            <div class="report-section">
                <h3>{{ __('emails.device_report.device_data') }}</h3>
                <div class="report-item">
                    <strong>{{ __('emails.device_report.name') }}:</strong> {{ $device->name }}
                </div>
                <div class="report-item">
                    <strong>{{ __('emails.device_report.address') }}:</strong> {{ $device->address ?? __('devices.measurements.no_data') }}
                </div>
                <div class="report-item">
                    <strong>{{ __('emails.device_report.status') }}:</strong> {{ $device->status }}
                </div>
            </div>

            <div class="report-section">
                <h3>{{ __('emails.device_report.details') }}</h3>
                <div class="report-item">
                    <strong>{{ __('emails.device_report.reported_at') }}:</strong> {{ $deviceReport->created_at->format('d.m.Y H:i') }}
                </div>
                <div class="report-item">
                    <strong>{{ __('emails.device_report.reporter') }}:</strong> {{ $reporter->name }} ({{ $reporter->email }})
                </div>
                <div class="report-item">
                    <strong>{{ __('emails.device_report.reason') }}:</strong> <span class="reason-badge">{{ $deviceReport->reason }}</span>
                </div>
                @if($deviceReport->description)
                <div class="report-item">
                    <strong>{{ __('emails.device_report.description') }}:</strong>
                    <div class="description-box">
                        {{ $deviceReport->description }}
                    </div>
                </div>
                @endif
            </div>

            <p>{{ __('emails.device_report.please_respond') }}</p>

            <center>
                <a href="{{ config('app.url') }}/device-reports" class="button">
                    {{ __('emails.device_report.go_to_reports') }}
                </a>
            </center>
        </div>

        <div class="footer">
            <p>{{ __('emails.email.auto_notice') }}</p>
            <p>&copy; {{ date('Y') }} {{ config('app.name', 'Laravel') }}. {{ __('emails.email.copyright') }}</p>
        </div>
    </div>
</body>

</html>