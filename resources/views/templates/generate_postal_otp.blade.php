<!doctype html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <link href="https://fonts.googleapis.com/css2?family=Noto+Sans:wght@400;700&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;900&display=swap" rel="stylesheet">
        <style type="text/css">
            @font-face {
                font-family: 'Roboto', sans-serif;
            }
            @media print {
                html, body {
                  height:100vh; 
                  margin: 0 !important; 
                  padding: 0 !important;
                  overflow: hidden;
                }
            }
            .hindi {
                font-family: 'Noto Sans', sans-serif !important;
                font-style: normal;
                font-weight: 400;
                letter-spacing: .56px;
                font-size: 16px;
                margin-bottom: 50px;
            }
            @page {
                width: 794px;
                height: 1123px;
                margin-top: 0cm;
                margin-bottom: 0cm;
                margin-left: 0cm;
                margin-right: 0cm;
                border: 1px solid blue;
            }
            body {
                font-family: 'Roboto', sans-serif;
                font-style: normal;
                font-weight: 400;
                background-color: #fff !important;
                position: relative;
                margin: 0px;
                padding: 0px;
                width: 794px;
                height: 1123px;
            }
            .wrapper {
                position: relative;
                width: 794px;
                height: 1123px;
            }
            .wrapper .footer {
                position: absolute;
                width: 100%;
            }
            .page-body {
                padding: 40px;
            }
            .regards {
                position: absolute;
                bottom: 100px;
            }
            .matter_en {
                margin-top: 50px;
            }
            p {
                font-size: 18px;
            }
            .regards p {
                margin: 0px;
                padding: 0px;
                margin-bottom: 8px;
                color: #000;
            }
            .candidate_info {
                font-weight: 600;
            }
            strong {
                font-weight: 900;
            }
        </style>
        <title>{{ $employees->first_name }} Address Verification Postal Template</title>
    </head>
    <body>
        <div class="wrapper">
            <div class="header">
                <img src="{{ url('/reports/image/otp-header.jpg') }}" style="width: 100%;">
            </div>
            <div class="page-body">
                <div class="candidate_info">
                    <strong>
                        <p style="margin: 0px; padding: 0px;">Mr. {{ $employees->first_name }} {{ $employees->middle_name }} {{ $employees->last_name }}</p>
                        <p>S/O {{ $employees->co_name }}</p>
                        <p style="margin: 0px; padding: 0px;">
                            @if(isset($addresses))
                                {{ $addresses->street_addr1 }}, {{ $addresses->street_addr2 }} 
                        </p>
                        <p style="margin: 0px; padding: 0px;">
                                {{ $addresses->village }}
                                {{ $addresses->post_office }}
                                {{ $addresses->police_station }}
                                {{ $addresses->district }}
                                {{ $addresses->near_by }}
                        </p>
                        <p style="margin: 0px; padding: 0px;">
                                {{ $addresses->city }}
                                {{ $addresses->state }}
                                {{ $addresses->pincode }}
                            @endif
                        </p>
                    </strong>
                </div>
                <div class="matter_en">
                    <p>
                        Dear Sir, pursuant to your association with <strong>@if(!empty($employers->b2b_brand_name))
                          {{ $employers->b2b_brand_name }}
                        @else
                          {{ $employers->first_name }} {{ $employers->middle_name }} {{ $employers->last_name }}
                        @endif</strong> we have been appointed as a verification company to verify the address. To that extent, please note that your OTP number to verify this communication is <strong>{{ $otp }}</strong>. Please call our operations at <strong>+91 8010980572</strong> and provide this OTP to conclude this verification. If you are not <strong>{{ $employees->first_name }} {{ $employees->middle_name }} {{ $employees->last_name }}</strong> or you have received this mail in error, please disregard.
                    </p>
                    <p style="clear: both;"></p>

                    <p class="hindi" style="padding-top: 100px;">
                        प्रिय महोदय, <strong>@if(!empty($employers->b2b_brand_name))
                          {{ $employers->b2b_brand_name }}
                        @else
                          {{ $employers->first_name }} {{ $employers->middle_name }} {{ $employers->last_name }}
                        @endif</strong> के साथ आपके सहयोग के कारण हमें पते को सत्यापित करने के लिए एक सत्यापन कंपनी के रूप में नियुक्त किया गया है। उस सीमा तक, कृपया ध्यान दें कि इस संचार को सत्यापित करने के लिए आपका ओटीपी नंबर <strong>{{ $otp }}</strong> है। कृपया हमारे कार्यों को <strong>+91 8010980572</strong> पर कॉल करें और इस सत्यापन को समाप्त करने के लिए यह ओटीपी प्रदान करें। यदि आप <strong>{{ $employees->first_name }} {{ $employees->middle_name }} {{ $employees->last_name }}</strong> नहीं हैं या आपको यह मेल गलती से प्राप्त हुआ है, तो कृपया अवहेलना करें।
                    </p>
                 
                    
                </div>

                <div class="regards" style="position: absolute; bottom: 150px;">
                    <p>Thanking You</p>
                    <p>TrueHelp Verification Team</p>
                </div>
            </div>
            <div class="footer" style="position: absolute; bottom: -1px; ">
                <img src="{{ url('/reports/image/otp-footer.jpg') }}" style="width: 100%;">
            </div>
        </div>
        <script type="text/javascript">
            window.print();
        </script>
    </body>
</html>