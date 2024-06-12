@extends('mail.template')

@section('content')
    <tr>
        <td align="left" style="font-size:0px;padding:10px 25px;word-break:break-word;">
            <div style="font-family:helvetica;font-size:18px;font-weight:700;line-height:1.5;text-align:left;color:#262626;">
                Hai {{ $name }},
            </div>
        </td>
    </tr>
    @if ($type == 'activation')
        <tr>
            <td align="left" style="font-size:0px;padding:10px 25px;word-break:break-word;">
                <div
                    style="font-family:helvetica;font-size:18px;font-weight:400;line-height:1.5;text-align:left;color:#262626;">
                    Sebelum melanjutkan silahkan konfirmasi OTP anda sebelum
                    <br>
                    <b>{{ $expired }}</b>.
                    <br>
                    <p style="text-align: center; font-size: 32px; color: #1338b2"><b>{{ $code }}</b></p>
                </div>
            </td>
        </tr>
    @endif
    @if ($type == 'forgot-password')
        <tr>
            <td align="left" style="font-size:0px;padding:10px 25px;word-break:break-word;">
                <div
                    style="font-family:helvetica;font-size:18px;font-weight:400;line-height:1.5;text-align:left;color:#262626;">
                    Untuk memperbaharui password silahkan konfirmasi OTP anda sebelum
                    <br>
                    <b>{{ $expired }}</b>.
                    <br>
                    <p style="text-align: center; font-size: 32px; color: #1338b2"><b>{{ $code }}</b></p>
                </div>
            </td>
        </tr>
    @endif
@endsection
