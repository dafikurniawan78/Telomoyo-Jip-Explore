<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Tiket Pemesanan - {{ $pemesanan->nama }}</title>
<style>
    body {
        margin: 0;
        padding: 0;
        font-family: Arial, sans-serif;
        background: #f0f2f5;
    }

    .nomor-antrean {
        font-size: 11pt;
        font-weight: bold;
        color: #dc3545;
    }

    .ticket {
        position: relative;
        width: 500pt;
        height: 120pt;
        border: 2px dashed #dc3545;
        border-radius: 6px;
        padding: 3pt;
        box-sizing: border-box;
        background: #fff;
        display: table;
    }

    /* Watermark */
    .ticket img.watermark {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 110pt;
        opacity: 0.07;
        z-index: 0;
    }

    .ticket-row {
        display: table-row;
        position: relative;
        z-index: 1;
    }

    .ticket-left {
        display: table-cell;
        width: 70pt;
        text-align: center;
        vertical-align: middle;
    }
    .ticket-left img.logo {
        width: 70pt;
        height: auto;
    }

    .ticket-right {
        display: table-cell;
        padding-left: 4pt;
        vertical-align: top;
    }
    .ticket-right h2 {
        margin: 0;
        font-size: 12pt;
        color: #dc3545;
    }
    .ticket-right small {
        font-size: 8pt;
        color: #555;
        margin-bottom: 2pt;
        display: block;
    }

    .ticket-details {
        font-size: 9pt;
        margin-top: 2pt;
    }
    .ticket-details table {
        width: 100%;
        border-collapse: collapse;
    }
    .ticket-details th, .ticket-details td {
        padding: 1px 2px;
        text-align: left;
        vertical-align: top;
    }
    .ticket-details th {
        width: 35%;
        color: #333;
    }

    .ticket-footer {
        font-size: 7pt;
        color: #444;
        border-top: 1px dashed #ccc;
        margin-top: 2pt;
        padding-top: 1pt;
        text-align: center;
    }
</style>
</head>
<body>
    <div class="ticket">
        <!-- Watermark -->
        <img class="watermark" src="{{ public_path('asset/img/Logo TJE.png') }}" alt="Watermark">

        <div class="ticket-row">
            <!-- Logo kiri -->
            <div class="ticket-left">
                <img class="logo" src="{{ public_path('asset/img/Logo TJE.png') }}" alt="Logo TJE">
            </div>

            <!-- Detail kanan -->
            <div class="ticket-right">
                <h2>Telomoyo Jip Explore</h2>
                <small>Tiket Pemesanan Resmi</small>

                <div class="ticket-details">
                    <table>
                        <tr><th>Nama</th><td>{{ $pemesanan->nama }}</td></tr>
                        <tr><th>Nomor Antrean</th><td class="nomor-antrean">{{ $pemesanan->antrean->nomor_antrean ?? '-' }}</td></tr>
                        <tr><th>Tanggal</th><td>{{ \Carbon\Carbon::parse($pemesanan->tanggal_berangkat)->format('d-m-Y') }}</td></tr>
                        <tr><th>Paket</th><td>{{ $pemesanan->paketWisata->nama_paket }}</td></tr>
                        <tr><th>Jumlah Orang</th><td>{{ $pemesanan->jumlah_orang }} Orang</td></tr>
                        <tr><th>Lokasi Jemput</th><td>{{ $pemesanan->lokasiJemput->nama_lokasi }}</td></tr>
                        <tr><th>Total Bayar</th><td>Rp {{ number_format($pemesanan->total,0,',','.') }}</td></tr>
                    </table>
                </div>

                <div class="ticket-footer">
                    Harap tunjukkan tiket ini kepada petugas saat keberangkatan.
                </div>
            </div>
        </div>
    </div>
</body>
</html>
