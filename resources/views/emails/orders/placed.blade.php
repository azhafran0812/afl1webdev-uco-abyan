<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konfirmasi Pesanan - TaleSpindle Studio</title>
    <style>
        /* Reset CSS sederhana untuk Email */
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 0; -webkit-font-smoothing: antialiased; }
        .wrapper { width: 100%; background-color: #f4f4f4; padding: 20px 0; }
        .container { max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.05); }

        /* Header */
        .header { background-color: #000000; padding: 20px; text-align: center; }
        .header h1 { color: #ffffff; margin: 0; font-size: 24px; font-weight: bold; letter-spacing: 1px; }

        /* Content */
        .content { padding: 30px; }
        .greeting { font-size: 16px; color: #333333; margin-bottom: 20px; }
        .order-info { background-color: #f9f9f9; padding: 15px; border-radius: 6px; margin-bottom: 25px; border-left: 4px solid #000; }
        .order-info p { margin: 5px 0; font-size: 14px; color: #555; }

        /* Table */
        .table-container { width: 100%; margin-bottom: 25px; }
        table { width: 100%; border-collapse: collapse; }
        th { text-align: left; padding: 10px; border-bottom: 2px solid #eee; color: #777; font-size: 12px; text-transform: uppercase; }
        td { padding: 10px; border-bottom: 1px solid #eee; color: #333; font-size: 14px; }
        .total-row td { border-top: 2px solid #333; border-bottom: none; font-weight: bold; font-size: 16px; padding-top: 15px; }

        /* Footer */
        .footer { background-color: #f4f4f4; padding: 20px; text-align: center; font-size: 12px; color: #999; }
        .btn { display: inline-block; background-color: #000; color: #fff; padding: 10px 20px; text-decoration: none; border-radius: 4px; margin-top: 20px; font-weight: bold; }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container">
            {{-- Header --}}
            <div class="header">
                <h1>TaleSpindle Studio</h1>
            </div>

            {{-- Body --}}
            <div class="content">
                <div class="greeting">
                    Halo, <strong>{{ $order->user->name }}</strong>!
                    <br>
                    Terima kasih telah berbelanja di TaleSpindle Studio. Pesanan Anda telah kami terima dan sedang diproses.
                </div>

                {{-- Info Order Singkat --}}
                <div class="order-info">
                    <p><strong>No. Order:</strong> #{{ $order->id }}</p>
                    <p><strong>Tanggal:</strong> {{ $order->created_at->format('d M Y, H:i') }}</p>
                    <p><strong>Metode Bayar:</strong> {{ strtoupper(str_replace('_', ' ', $order->payment_method)) }}</p>
                    <p><strong>Status:</strong> <span style="color: #e67e22; font-weight:bold;">{{ ucfirst($order->status) }}</span></p>
                </div>

                {{-- Tampilkan Instruksi Pembayaran (FITUR BARU) --}}
                <div style="background-color: #f3f4f6; padding: 15px; border-radius: 8px; margin: 20px 0;">
                    <h3 style="margin-top: 0;">Instruksi Pembayaran</h3>
                    <p>Silakan selesaikan pembayaran Anda melalui:</p>

                    @if($order->payment_method == 'transfer_bank')
                        <p><strong>Bank BCA</strong><br>
                        No. Rekening: <strong>5855161360</strong><br>
                        Atas Nama: <strong>Abyan Zhafran</strong></p>
                    @elseif($order->payment_method == 'e-wallet')
                        <p><strong>GoPay / OVO / Dana</strong><br>
                        Nomor: <strong>0818-0998-3956</strong><br>
                        Atas Nama: <strong>Abyan Zhafran</strong></p>
                    @else
                        <p><strong>Cash on Delivery (COD)</strong><br>
                        Silakan siapkan uang tunai sejumlah total tagihan saat kurir tiba.</p>
                    @endif

                    <p><em>*Harap lakukan pembayaran dalam 1x24 jam.</em></p>
                </div>

                {{-- Tabel Produk --}}
                <div class="table-container">
                    <table cellpadding="0" cellspacing="0">
                        <thead>
                            <tr>
                                <th width="50%">Produk</th>
                                <th width="15%" style="text-align: center;">Qty</th>
                                <th width="35%" style="text-align: right;">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->items as $item)
                            <tr>
                                <td>
                                    <strong>{{ $item->product->name }}</strong>
                                    <br>
                                    <span style="font-size: 12px; color: #777;">Rp {{ number_format($item->price, 0, ',', '.') }}</span>
                                </td>
                                <td style="text-align: center;">{{ $item->quantity }}</td>
                                <td style="text-align: right;">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</td>
                            </tr>
                            @endforeach

                            {{-- Baris Total --}}
                            <tr class="total-row">
                                <td colspan="2" style="text-align: right; padding-right: 20px;">Total Pembayaran</td>
                                <td style="text-align: right;">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div style="margin-top: 30px;">
                    <p style="font-size: 14px; color: #555;"><strong>Alamat Pengiriman:</strong></p>
                    <p style="background: #f9f9f9; padding: 10px; border-radius: 4px; font-size: 14px;">
                        {{ $order->shipping_address }}
                    </p>
                </div>

                <div style="text-align: center;">
                    <a href="{{ route('orders.history') }}" class="btn">Lihat Riwayat Pesanan</a>
                </div>
            </div>

            {{-- Footer --}}
            <div class="footer">
                &copy; {{ date('Y') }} TaleSpindle Studio. All rights reserved.<br>
                Ini adalah email otomatis, mohon tidak membalas email ini.
            </div>
        </div>
    </div>
</body>
</html>
