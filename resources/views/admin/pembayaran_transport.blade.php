<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        * {
        box-sizing: border-box;
        }

        @page{
            margin: 5px 15px 5px 20px;
        }

        @page{
            margin: 5px 30px 5px 15px;
            padding: 0;
        }
        
        /* Create two equal columns that floats next to each other */
        .column {
            float: left;
            width: 100%;
            padding: 10px;
        }
        /* Clear floats after the columns */
        .row:after {
            content: "";
            display: table;
            clear: both;
        }

        .currency {
            text-align: right;
        }

        .currency:before {
            content: "Rp. ";
            float: left;
        }

        .text-left{
            text-align: left;
        }

        .text-right{
            text-align: right;
        }

        .text-center{
            text-align: center;
        }

        .float-left{
            float: left;
        }

        .inline{
            display: inline;
        }

        .m-0{
            margin: 0;
        }

        table {
            border: 1px solid black;
            border-collapse: collapse;
            width: 100%;
        }

        td {
            padding: 5px;
        }
    
        .border{
            border: 1px solid black;
        }

        p{
            font-size: 16px;
        }


        td p{
            margin: 0;
            padding-left: 2px;
        }

        .wrap-text {
            text-align:center;
            display: inline-block;
            font-weight: bold;
        }

        .container-text {
            text-align: right;
            padding-right: 10%;
        }

        .wrap-kota {
            text-align:right;
            display: inline-block;
        }

        .container-kota {
            text-align: right;
            padding-right: 20%;
        }

        .tb-m{
            margin-bottom: 87px;
        }

        .bold{
            font-weight: bold;
        }

        .capitalize{
            text-transform: capitalize;
        }

        .uppercase{
            text-transform: uppercase;
        }

        .ttd{
            border: none;
            width: 100%;
        }

        .ttd tr{
            border: none;
        }

        .ttd tr td{
            border: none;
            width: 50%;
        }

        .hidden{
            visibility: hidden;
        }

        .plan {
            border: none;
        }

        .pr-50{
            padding-right: 50px;
        }

        .mtb{
            padding: 10px 5px;
        }
    </style>
</head>


<body>
<div class="row">
  <div class="column">
    <section class="content">
        <div class="container-fluid p-5">
            <div class="row mb-5">
            <div style="text-align: center; margin-top: 0; margin-bottom:0;" >
                <p class="bold">DAFTAR PEMBAYARAN UANG TRANSPORTASI BELANJA PERJALANAN DINAS</p>
                <p class="text-center">ke {{ $perjadin[0]->destination }}, pada tanggal {{ \Carbon\Carbon::parse($perjadin[0]->leave_date)->isoFormat('D MMMM Y')}} {{ $perjadin[0]->plan }}</p>
            </div>
            <div class="row">
                <table>
                    <tr class="border">
                        <td class="border text-center bold" style="width: 5%;"> No </td>
                        <td class="border text-center bold" style="width: 30%;">Nama</td>
                        <td class="border text-center bold" style="width: 20%;">Pangkat/Gol</td>
                        <td class="border text-center bold" style="width: 10%;">Tarif</td>
                        <td class="border text-center bold" style="width: 5%;">Lama (hari)</td>
                        <td class="border text-center bold" style="width: 10%;">Jumlah yang Diterima</td>
                        <td class="border text-center bold" style="width: 20%;">Tanda Tangan Penerima</td>
                    </tr>
                    @foreach($members as $member)
                    <tr class="border">
                        <td class="border text-center mtb">{{ $loop->iteration }}</td>
                        <td class="border mtb">{{ $user->find($member)->name }}</td>
                        <td class="border text-center">
                        @if ( $user->find($member)->pangkat )
                            {{ $user->find($member)->pangkat }}
                        @else
                            -
                        @endif
                        <span>/</span>
                        @if ( $user->find($member)->golongan )
                            {{ $user->find($member)->golongan }}
                        @else
                            -
                        @endif
                        </td>
                        <td class="border currency">{{ number_format($cost_per_id / $selisihHari, 0, ',', '.') }}</td>
                        <td class="border text-center">{{ $selisihHari }}</td>
                        <td class="border currency">{{ number_format($cost_per_id, 0, ',', '.') }}</td>
                        <td class="border"></td>
                    </tr>
                    @endforeach
                    <tr class="border">
                        <td class="border bold text-center" colspan="5">JUMLAH</td>
                        <td class="border bold currency">{{ $perjadin[0]->kuitansi->formatRupiah('cost_total') }}</td>
                        <td class="border"></td>
                    </tr>
                    <td class="border text-center" colspan="7"><p style="font-weight: bold; text-transform: capitalize;"><i> {{ $terbilang }} </i></p></td>
                </table>
                <table class="ttd">
                    <br/>
                    <tr>
                        <td>
                            <p class="hidden">x</p>
                        </td>
                        <td>
                            <p class="text-center" style="padding-right: 40px;">Cimahi, {{ \Carbon\Carbon::parse($perjadin[0]->kuitansi->kuitansi_date)->isoFormat('D MMMM Y')}}</p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p class="text-center">Mengetahui/Menyetujui</p> 
                        </td>
                        <td>
                            <p class="text-center">Yang Menyerahkan</p>
                            
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p class="bold text-center">BENDAHARA PENGELUARAN PEMBANTU,</p>
                        </td>
                        <td>
                            <p class="bold text-center">KOORDINATOR,</P>
                        </td>
                    </tr>
                    
                    <tr>
                        <td>
                            <p class="bold text-center" style="margin-top:75px;"><u>{{ Setting::getValue('app_treasurer') }}</u></p>
                            <p class="text-center">NIP. {{ Setting::getValue('app_treasurer_nip') }}</p>
                        </td>
                        <td>
                            <p class="bold text-center" style="margin-top:75px;"> <u> {{ $user->find($perjadin[0]->coordinator)->name }} </u> </p>
                            @if($user->find($perjadin[0]->coordinator)->nip == '')
                                <p class="text-center">NIP. -</p>
                            @else
                                <p class="text-center">NIP. {{ $user->find($perjadin[0]->coordinator)->nip }}</p>
                            @endif
                        </td>
                    </tr>
                </table>
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
  </div>
</div>

</body>
</html>
