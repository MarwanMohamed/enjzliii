<?php global $setting; ?>{{-- <body class="" style="font-family: sans-serif; -webkit-font-smoothing: antialiased; font-size: 14px; line-height: 1.4; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; background-color: #f6f6f6; margin: 0; padding: 0;"><table border="0" cellpadding="0" cellspacing="0" class="body" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%; background-color: #f6f6f6;" width="100%" bgcolor="#f6f6f6"><tr><td style="font-family: sans-serif; font-size: 14px; vertical-align: top;" valign="top">&nbsp;</td><td class="container" style="font-family: sans-serif; font-size: 14px; vertical-align: top; display: block; Margin: 0 auto !important; max-width: 580px; padding: 10px; width: 580px;" width="580" valign="top"><div class="content" style="box-sizing: border-box; display: block; Margin: 0 auto; max-width: 580px; padding: 10px;"><span class="preheader" style="color: transparent; display: none; height: 0; max-height: 0; max-width: 0; opacity: 0; overflow: hidden; mso-hide: all; visibility: hidden; width: 0;">{{ $title }}</span><table class="main" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%; background: #fff; border-radius: 3px;" width="100%"><tr><td class="wrapper" style="font-family: sans-serif; font-size: 14px; vertical-align: top; box-sizing: border-box; padding: 20px;" valign="top"><table border="0" cellpadding="0" cellspacing="0" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;" width="100%"><tr><td style="text-align: right; font-family: sans-serif; font-size: 14px; vertical-align: top;" valign="top"><p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; Margin-bottom: 15px;">{{ $title }}</p><p style="text-align: right; font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; Margin-bottom: 15px;">{!! $msg !!}</p></td></tr></table></td></tr></table><div class="footer" style="clear: both; padding-top: 10px; text-align: center; width: 100%;"><table border="0" cellpadding="0" cellspacing="0" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;" width="100%"><tr><td class="content-block" style="font-family: sans-serif; vertical-align: top; padding-top: 10px; padding-bottom: 10px; font-size: 12px; color: #999999; text-align: center;" valign="top" align="center"><span class="apple-link" style="color: #999999; font-size: 12px; text-align: center;">{{$setting['copyRights_text']}}123123<br></bre>{!! $copy_right !!}</span></td></tr><tr><td class="content-block powered-by" style="font-family: sans-serif; vertical-align: top; padding-top: 10px; padding-bottom: 10px; font-size: 12px; color: #999999; text-align: center;" valign="top" align="center"><a href="{{ url('/') }}" style="color: #999999; font-size: 12px; text-align: center; text-decoration: none;">{{ $site_name }}</a></td></tr></table></div></div></td><td style="font-family: sans-serif; font-size: 14px; vertical-align: top;" valign="top">&nbsp;</td></tr></table></body>

 --}}
<!doctype html>
<html dir="rtl">
<head>
    <?php global $setting ?>
    <meta name="viewport" content="width=device-width">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>{{$setting['siteTitle']}}</title>
    <style media="all" type="text/css">
        @media screen {
            /* arabic */
            @font-face {
                font-family: 'Cairo';
                font-style: normal;
                font-weight: 400;
                src: local('Cairo'), local('Cairo-Regular'), url(https://fonts.gstatic.com/s/cairo/v1/MoGpUcTu_oZLf0bsrG2xFQ.woff2) format('woff2');
                unicode-range: U+0600-06FF, U+200C-200E, U+2010-2011, U+FB50-FDFF, U+FE80-FEFC;
            }
            /* latin-ext */
            @font-face {
                font-family: 'Cairo';
                font-style: normal;
                font-weight: 400;
                src: local('Cairo'), local('Cairo-Regular'), url(https://fonts.gstatic.com/s/cairo/v1/iZqLGfCYEEkWEsr6HQRnSQ.woff2) format('woff2');
                unicode-range: U+0100-024F, U+1E00-1EFF, U+20A0-20AB, U+20AD-20CF, U+2C60-2C7F, U+A720-A7FF;
            }
            /* latin */
            @font-face {
                font-family: 'Cairo';
                font-style: normal;
                font-weight: 400;
                src: local('Cairo'), local('Cairo-Regular'), url(https://fonts.gstatic.com/s/cairo/v1/gtxIPk0-ZE5IZ2RrdsRLuQ.woff2) format('woff2');
                unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2212, U+2215;
            }
        }

        @media only screen and (max-width: 620px) {
            .span-2,
            .span-3 {
                max-width: none !important;
                width: 100% !important;
            }

            .span-2 > table,
            .span-3 > table {
                max-width: 100% !important;
                width: 100% !important;
            }
        }

        @media all {
            .btn-primary table td:hover {
                background-color: #34495e !important;
            }

            .btn-primary a:hover {
                background-color: #34495e !important;
                border-color: #34495e !important;
            }
        }

        @media all {
            .btn-secondary a:hover {
                border-color: #34495e !important;
                color: #34495e !important;
            }
        }

        @media only screen and (max-width: 620px) {
            h1 {
                font-size: 28px !important;
                margin-bottom: 10px !important;
            }

            h2 {
                font-size: 22px !important;
                margin-bottom: 10px !important;
            }

            h3 {
                font-size: 16px !important;
                margin-bottom: 10px !important;
            }

            p,
            ul,
            ol,
            td,
            span,
            a {
                font-size: 16px !important;
            }

            .wrapper,
            .article {
                padding: 10px !important;
            }

            .content {
                padding: 0 !important;
            }

            .container {
                padding: 0 !important;
                width: 100% !important;
            }

            .header {
                margin-bottom: 10px !important;
            }

            .main {
                border-left-width: 0 !important;
                border-radius: 0 !important;
                border-right-width: 0 !important;
            }

            .btn table {
                width: 100% !important;
            }

            .btn a {
                width: 100% !important;
            }

            .img-responsive {
                height: auto !important;
                max-width: 100% !important;
                width: auto !important;
            }

            .alert td {
                border-radius: 0 !important;
                padding: 10px !important;
            }

            .receipt {
                width: 100% !important;
            }
        }

        @media all {
            .ExternalClass {
                width: 100%;
            }

            .ExternalClass,
            .ExternalClass p,
            .ExternalClass span,
            .ExternalClass font,
            .ExternalClass td,
            .ExternalClass div {
                line-height: 100%;
            }

            .apple-link a {
                color: inherit !important;
                font-family: inherit !important;
                font-size: inherit !important;
                font-weight: inherit !important;
                line-height: inherit !important;
                text-decoration: none !important;
            }
        }

        h2.logo-img {
            float: right;
            font-size: 24px;
            color: #fff;
            border-bottom: 2px solid #fe5339;
            line-height: 35px;
            margin-top: -2px;
        }

        td {
            direction: rtl;
            font-family: 'Cairo', sans-serif !important;
        }

    </style>
    <link href="https://fonts.googleapis.com/css?family=Cairo" rel="stylesheet">

    <!--[if gte mso 9]>
    <xml>
        <o:OfficeDocumentSettings>
            <o:AllowPNG/>
            <o:PixelsPerInch>96</o:PixelsPerInch>
        </o:OfficeDocumentSettings>
    </xml>
    <![endif]-->
    <!--
 _     _             _                      _ _   _       
| |   | |           | |                    (_) | (_)      
| |__ | |_ _ __ ___ | | ___ _ __ ___   __ _ _| |  _  ___  
| '_ \| __| '_ ` _ \| |/ _ \ '_ ` _ \ / _` | | | | |/ _ \ 
| | | | |_| | | | | | |  __/ | | | | | (_| | | |_| | (_) |
|_| |_|\__|_| |_| |_|_|\___|_| |_| |_|\__,_|_|_(_)_|\___/ 
                                                          
-->
</head>
<body class=""
      style="font-family: tahoma, sans-serif; -webkit-font-smoothing: antialiased; font-size: 14px; line-height: 1.4; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; background-color: #f6f6f6; margin: 0; padding: 0;">
<table border="0" cellpadding="0" cellspacing="0" class="body"
       style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%; background-color: #f6f6f6;"
       width="100%" bgcolor="#f6f6f6">
    <tr>
        <td style="font-family: tahoma, sans-serif; font-size: 14px; vertical-align: top;" valign="top">&nbsp;</td>
        <td class="container"
            style="font-family: tahoma, sans-serif; font-size: 14px; vertical-align: top; Margin: 0 auto !important; padding: 10px; width: 89%;"
            width="580" valign="top">
            <div class="content"
                 style="box-sizing: border-box; display: block; Margin: 0 auto; max-width: 89% padding: 10px;">

                <!-- START CENTERED WHITE CONTAINER -->
                <span class="preheader"
                      style="color: transparent; display: none; height: 0; max-height: 0; max-width: 0; opacity: 0; overflow: hidden; mso-hide: all; visibility: hidden; width: 0;">{{$setting['siteTitle']}}</span>

                <!-- START HEADER -->
                <div class="" style=" Margin-top: 10px; width: 100%;    height: 100px;">
                    <table border="0" cellpadding="0" cellspacing="0"
                           style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%; min-width: 100%;"
                           width="100%">
                        <tr>
                            <td class="align-center"
                                style="font-family: tahoma, sans-serif;height:100px;position:relative; font-size: 14px;background:#000; vertical-align: top; text-align: center;"
                                valign="top" align="center">
                                <img src='{{url('image/200x100/logo_email.png')}}'
                                     style='margin: auto; right: 0;left: 0;  position: absolute;'/>
                                                  <a  href="{{url('')}}" target="_blank" style="color: #3498db; text-decoration: underline;">
                    <!--<h2  class="logo-img">انجزلي</h2>-->
                    <img style="width: 62%; height: 81%; margin-top: 10px;" src="{{url('assets/img/logo.png')}}"/>
                    </a>
                            </td>
                        </tr>
                    </table>
                </div>

                <!-- END HEADER -->
                <table border="0" cellpadding="0" cellspacing="0" class="main"
                       style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%; background: #fff; border-radius: 3px;"
                       width="100%">

                    <!-- START NOTIFICATION BANNER -->
                    <tr>
                        <td style="font-family: tahoma, sans-serif; font-size: 14px; vertical-align: top;" valign="top">
                            <table border="0" cellpadding="0" cellspacing="0" class="alert alert-danger"
                                   style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%; min-width: 100%;"
                                   width="100%">
                               <tr>
                                    <td align="center"
                                        style="font-family: 'Cairo', sans-serif; vertical-align: top; font-size: 20px; border-radius: 3px 3px 0 0; color: #ffffff; font-weight: bold; padding: 10px; text-align: center; background-color:#fe5339;"
                                        valign="top" bgcolor="#fff"> {{$msg}} </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- END NOTIFICATION BANNER -->

                    <!-- START MAIN CONTENT AREA -->
                    <tr>
                       
                            <td class="wrapper"
                                style="font-family: tahoma, sans-serif; font-size: 14px; vertical-align: top; box-sizing: border-box; padding: 20px;"
                                valign="top">
                                <table border="0" cellpadding="0" cellspacing="0"
                                       style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;"
                                       width="100%">
                                    <tr>
                                        <td style="font-family: tahoma, sans-serif; font-size: 14px; vertical-align: top;"
                                            valign="top"></td>
                                                <p style="font-family: tahoma, sans-serif; font-size: 14px; font-weight: normal; Margin: 0; Margin-bottom: 15px;"> مرحبا , {{$msg}} فى </p>
                                                <p style="font-family: tahoma, sans-serif; font-size: 14px; font-weight: normal; Margin: 0; Margin-bottom: 15px;"> {!! $title !!}</p>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                    </tr>

                    <!-- END MAIN CONTENT AREA -->
                </table>

                <!-- START FOOTER -->
                <div class="footer"
                     style="clear: both; padding-top: 10px; text-align: center; width: 100%;background: #e6e6e6 ;">
                    <table border="0" cellpadding="0" cellspacing="0"
                           style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;"
                           width="100%">

                        <tr>
                            <td class="content-block powered-by"
                                style="font-family: tahoma, sans-serif; vertical-align: top; padding-top: 10px; padding-bottom: 10px; font-size: 12px; color: #999999; text-align: center;"
                                valign="top" align="center">
                                <a href="{{url('')}}"
                                   style="color: #999999; font-size: 12px; text-align: center; text-decoration: none;">{{$setting['copyRights_text']}}
                                    <br>{{$setting['copyRights']}} © {{date('Y')}}</a>.
                            </td>
                        </tr>
                    </table>
                </div>

                <!-- END FOOTER -->

                <!-- END CENTERED WHITE CONTAINER --></div>
        </td>
        <td style="font-family: tahoma, sans-serif; font-size: 14px; vertical-align: top;" valign="top">&nbsp;</td>
    </tr>
</table>
</body>
</html>