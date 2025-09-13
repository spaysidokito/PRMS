<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SOA - Student Organization & Activities - Print View</title>
    <style>
        @media print {
            body { margin: 0; }
            .no-print { display: none !important; }
        }

        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 20px;
        }

        .header {
            text-align: center;
            border-bottom: 2px solid #333;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }

        .title {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .subtitle {
            font-size: 16px;
            color: #666;
        }

        .form-section {
            margin-bottom: 30px;
        }

        .form-section h3 {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 15px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 5px;
        }

        .form-content {
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 5px;
            text-align: center;
        }

        .placeholder-text {
            color: #666;
            font-style: italic;
        }

        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 12px;
            color: #666;
        }

                .print-button, .download-button {
            background-color: #007bff;
            color: white;
            padding: 6px 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-bottom: 20px;
            margin-right: 10px;
            font-size: 12px;
            text-decoration: none;
            display: inline-block;
        }

        .download-button {
            background-color: #28a745;
        }

        .print-button:hover, .download-button:hover {
            opacity: 0.9;
        }

        .button-container {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="no-print button-container">
        <button class="print-button" onclick="window.print()">Print Form</button>
        <a href="{{ route('resources.soa.download') }}" class="download-button">Download PDF</a>
        <a href="{{ route('resources.soa') }}" style="color: #007bff;">Back to Form</a>
    </div>

    <div class="header">
        <div class="title">Student Organization & Activities (SOA)</div>
        <div class="subtitle">Resource Management Form</div>
    </div>

    <div class="form-section">
        <h3>Form Details</h3>
        <div class="form-content">
            <p class="placeholder-text">
                Form content will be displayed here when the actual form is provided.
            </p>
        </div>
    </div>

    <div class="footer">
        <p>Generated on: {{ now()->format('F j, Y \a\t g:i A') }}</p>
        <p>PRMS - Student Resource Management System</p>
    </div>
</body>
</html>
