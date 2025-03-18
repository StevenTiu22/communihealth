<!DOCTYPE html>
<html>
    <head>
    <title>Medicine Inventory Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            color: #333;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            padding: 0 50px;
        }
        .logo {
            height: 120px;
            width: auto;
        }
        .header-title {
            text-align: center;
            font-size: 18px;
            flex-grow: 1;
            margin: 20px;
            font-family: 'Times New Roman', Times, serif;
        }
        .report-subtitle {
            text-align: center;
            font-size: 20px;
            margin-bottom: 30px;
            font-family: 'Times New Roman', Times, serif;
            font-weight: bold;
        }
        .report-date {
            text-align: right;
            margin-bottom: 20px;
        }
        .report-content {
            margin-bottom: 30px;
        }
        .report-footer {
            margin-top: 50px;
            text-align: center;
            font-size: 12px;
            color: #666;
            border-top: 1px solid #ccc;
            padding-top: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
    </head>
    <body>
    <div class="header">
        <img src="{{ Storage::URL('images/Bagong_Pilipinas_logo.png') }}" alt="Bagong Pilipinas logo" class="logo">
        <img src="{{ Storage::URL('images/makabagong_sj.png') }}" alt="Makabagong San Juan logo" class="logo">
        <div class="header-title">Republic of the Philippines
            <br><b>CITY OF SAN JUAN</b>
            <br>428 F. Manalo Street, Barangay Batis Health Center
            <br><b>BARANGAY BATIS</b>
            <br>Telephone No. 7744-0737
            <br><span style="color: #0000FF;"><i>Email add: <u>batis.sanjuan@gmail.com</u></i></span>
        </div>
        <img src="{{ Storage::URL('images/sjc logo.png') }}" alt="San Juan City Logo" class="logo">
        <img src="{{ Storage::URL('images/BATIS logo.png') }}" alt="Barangay Batis Logo" class="logo">
    </div>

    <div class="report-subtitle">BARANGAY BATIS HEALTH CENTER</div>

    <h2 class="report-subtitle">Medicine Inventory Report</h2>
    <p style="text-align: center;">Generated on: {{ now('Asia/Manila')->format('M d, Y') }}</p>

    <h2 class="report-subtitle">TB Cases and Medicine Distribution Report</h2>
    <p style="text-align: center;">Generated on: {{ now()->format('M d, Y') }}</p>

	<div class="report-content">
		<table>
			<thead>
				<tr>
					<th>Daily TB Cases</th>
					<th>TB Medicine Distributed</th>
				</tr>
			</thead>
			<tbody>
				@foreach($tb as $tb)
					<tr>
						<td>{{ $tb->daily_cases }}</td>
						<td>{{ $tb->distributed_tbmeds }}</td>
					</tr>
				@endforeach
			</tbody>
		</table>
	</body>
</html>
