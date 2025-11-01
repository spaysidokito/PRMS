<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print - {{ $formSubmission->original_filename }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f3f4f6;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 20px;
        }

        .container {
            max-width: 100%;
            background-color: white;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px solid #e5e7eb;
        }

        .header h1 {
            font-size: 24px;
            color: #1e40af;
            margin-bottom: 5px;
        }

        .header p {
            font-size: 14px;
            color: #6b7280;
        }

        .image-container {
            text-align: center;
            margin: 20px 0;
        }

        .image-container img {
            max-width: 100%;
            height: auto;
            border: 1px solid #e5e7eb;
            border-radius: 4px;
        }

        .print-button {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 12px 24px;
            background-color: #2563eb;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 600;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            z-index: 1000;
        }

        .print-button:hover {
            background-color: #1e40af;
        }

        @media print {
            body {
                background-color: white;
                padding: 0;
            }

            .container {
                box-shadow: none;
                padding: 0;
            }

            .print-button {
                display: none;
            }

            .header {
                display: none;
            }

            .image-container img {
                max-width: 100%;
                page-break-inside: avoid;
            }

            @page {
                margin: 0.5cm;
            }
        }
    </style>
</head>
<body>
    <button onclick="window.print()" class="print-button">
        🖨️ Print Image
    </button>

    <div class="container">
        <div class="header">
            <h1>{{ $formSubmission->form_type_name }}</h1>
            <p>{{ $formSubmission->original_filename }}</p>
        </div>

        <div class="image-container">
            <img src="{{ asset('storage/' . $formSubmission->file_path) }}"
                 alt="{{ $formSubmission->original_filename }}">
        </div>
    </div>

    <script>
        // Auto-print option (uncomment if you want automatic print dialog)
        // window.onload = function() {
        //     window.print();
        // };
    </script>
</body>
</html>
