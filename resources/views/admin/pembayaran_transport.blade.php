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
    </style>
</head>


<body>
<div class="row">
  <div class="column">
    <section class="content">
        <div class="container-fluid p-5">
            <div class="row mb-5">
            <div style="text-align: center; margin-top: 0; margin-bottom:0;" >
                <p class="uppercase bold">Daftar Pembayaran Uang Transport belanja perjalanan dinas (SPD)</p>
                <p class="text-center">Perjalanan Dinas ke {{ $perjadin[0]->destination }}, selama {{ $selisihHari }} hari {{ $perjadin[0]->plan }}</p>
            </div>
            <div class="row">
                <table>
                    <tr class="border">
                        <td class="border text-center bold"><p> No </p></td>
                        <td class="border text-center bold"><p>Nama</p></td>
                        <td class="border text-center bold"><p>Pangkat/Gol</p></td>
                        <td class="border text-center bold"><p>Tarif</p></td>
                        <td class="border text-center bold"><p>Lama(hari)</p></td>
                        <td class="border text-center bold"><p>Jumlah yang Diterima</p></td>
                        <td class="border text-center bold"><p>Tanda Tangan Penerima</p></td>
                    </tr>
                    @foreach($members as $member)
                    <tr class="border">
                        <td class="border text-center"><p>{{ $loop->iteration }}</p></td>
                        <td class="border uppercase"><p>{{ $user->find($member)->name }}</p></td>
                        @if( $user->find($member)->golongan == '')
                        <td class="border text-center"><p> {{ $user->find($member)->jabatan }} / -</p></td>
                        @else
                            <td class="border text-center"><p> {{ $user->find($member)->jabatan }} / {{ $user->find($member)->golongan }}</p></td>
                        @endif
                        <td class="border text-right"><p>{{ number_format($cost_per_id, 0, ',', '.') }}</p></td>
                        <td class="border text-center"><p>{{ $selisihHari }}</p></td>
                        <td class="border text-right"><p>{{ number_format($cost_per_id, 0, ',', '.') }}</p></td>
                        <td class="border"></td>
                    </tr>
                    @endforeach
                    <tr class="border">
                        <td class="border bold text-center uppercase" colspan="5"><p>Jumlah</p></td>
                        <td class="border bold text-right"><p>{{ $perjadin[0]->kuitansi->formatRupiah('cost_total') }}</p></td>
                        <td class="border"></td>
                    </tr>
                    <td class="border" colspan="7"><p style="font-weight: bold; text-transform: capitalize;"><i> {{ $terbilang }} </i></p></td>
                </table>
                <table class="ttd">
                    <br/>
                    <tr>
                        <td>
                            <p class="hidden">x</p>
                        </td>
                        <td>
                            <p class="text-center" style="padding-right: 40px;">Cimahi, {{ \Carbon\Carbon::parse($perjadin[0]->surat->document_date)->isoFormat('D MMMM Y')}}</p>
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
                            <p class="bold text-center">Bendahara Pengeluaran Pembantu,</p>
                        </td>
                        <td>
                            <p class="bold text-center">Koordinator</p>
                        </td>
                    </tr>
                    
                    <tr>
                        <td>
                            <p class="bold text-center uppercase" style="margin-top:75px;"> <u> Mulyadi </u></p>
                            <p class="bold text-center">NIP. 198209142010011001</p>
                        </td>
                        <td>
                            <p class="bold text-center uppercase" style="margin-top:75px;"> <u> {{ $user->find($perjadin[0]->coordinator)->name }} </u> </p>
                            @if($user->find($perjadin[0]->coordinator)->nip == '')
                                <p class="bold text-center">NIP. -</p>
                            @else
                                <p class="bold text-center">NIP. {{ $user->find($perjadin[0]->coordinator)->nip }}</p>
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