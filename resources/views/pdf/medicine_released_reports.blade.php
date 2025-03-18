<!DOCTYPE html>
<html>
<head>
    <title>Medicine Inventory Report</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style>
        @page {
            size: legal;
            margin: 0.5in 0.55in;
        }

        body {
            font-family: 'Arial', Arial, sans-serif;
            font-size: 14px;
            color: #333;
            margin: 0; /* optional, if you want top-level margin control */
        }

        /* Container for the entire header */
        .header {
            text-align: center; /* Centers the inline-block elements horizontally */
            white-space: nowrap; /* Prevents line-wrapping */
            margin-bottom: 20px;
            width: 100%;
        }

        /* Logo styling */
        .logo {
            height: 90px;
            width: auto;
            margin: 0 5px;
            vertical-align: middle; /* Keep logos aligned with text */
        }

        /* Each "section" in the header on the same line */
        .left-logos,
        .header-title,
        .right-logos {
            display: inline-block;
            vertical-align: middle;
            margin: 0 10px; /* spacing between sections */
        }

        /* Title styling */
        .header-title {
            text-align: center;
            font-size: 14px;
            font-family: 'Times New Roman', Times, serif;
        }

        .report-subtitle {
            text-align: center;
            font-size: 14px;
            margin-bottom: 30px;
            font-family: 'Times New Roman', Times, serif;
            font-weight: bold;
        }

        .report-content {
            margin-bottom: 30px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: center;
            font-size: 12px;
            background-color: #f2f2f2;
        }

        td {
            padding: 12px;
            text-align: left;
            font-size: 12px;
        }
    </style>
</head>
<body>

<div class="header">
    <!-- Left Logos -->
    <div class="left-logos">
        <img src="data:image/png;base64,<?php echo base64_encode(file_get_contents(base_path('public/storage/images/Bagong_Pilipinas_logo.png'))); ?>" alt="Bagong Pilipinas logo" class="logo">
        <img src="data:image/png;base64,<?php echo base64_encode(file_get_contents(base_path('public/storage/images/makabagong_sj.png'))); ?>" alt="Makabagong San Juan logo" class="logo">
    </div>

    <!-- Title in the center -->
    <div class="header-title">
        Republic of the Philippines
        <br><b>CITY OF SAN JUAN</b>
        <br>428 F. Manalo St., Batis Health Center
        <br><b>BARANGAY BATIS</b>
        <br>Tel. No. 7744-0737
        <br>
        <span style="color: #0000FF;">
                <i>Email: <u>batis.sanjuan@gmail.com</u></i>
            </span>
    </div>

    <!-- Right Logos -->
    <div class="right-logos">
        <img src="data:image/png;base64,<?php echo base64_encode(file_get_contents(base_path('public/storage/images/sjc logo.png'))); ?>" alt="San Juan City Logo" class="logo">
        <img src="data:image/png;base64,<?php echo base64_encode(file_get_contents(base_path('public/storage/images/BATIS logo.png'))); ?>" alt="Barangay Batis Logo" class="logo">
    </div>
</div>

<div class="report-subtitle">BARANGAY BATIS HEALTH CENTER</div>
<h2 class="report-subtitle">Medicine Transaction Report</h2>
<p style="text-align: center;">Generated on: {{ now('Asia/Manila')->format('M d, Y') }}</p>

<div class="report-content">
    <table>
        <thead>
        <tr>
            <th>Generic Name</th>
            <th>Brand Name</th>
            <th>Category</th>
            <th>No. of Medicines Distributed</th>
        </tr>
        </thead>
        <tbody>
        @foreach($transactions as $transaction)
            <tr>
                <td>{{ $transaction->medicine->generic_name }}</td>
                <td>{{ $transaction->medicine->name }}</td>
                <td>{{ $transaction->medicine->category->name }}</td>
                <td>{{ $transaction->quantity }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

</body>
</html>
