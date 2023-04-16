<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Document</title>
        <link rel="stylesheet" href="{{ public_path('css/style.css') }}" />
    </head>
    <body>
    <div style="padding: 40px"> 
            <div class="row">
            <table width="100%">
                    <tr>
                        <td width="6%"><span class="head-logo">
                            <img src="{{ public_path('images/logo.png') }}" alt="logo" />
                        </span></td>
                        <td>
                            <span>
                                <div class="head-title">
                                    Agusan del Sur State College of Agriculture and
                                    Technology
                                </div>
                                <div>
                                    <div>Bunawan, Agusan del Sur</div>
                                    <div>website: https://asscat.edu.ph</div>
                                    <div>
                                        email address: op@asscat.edu.ph; mobile no.:
                                        +639486379266
                                    </div>
                                </div>
                            </span>
                        </td>
                    </tr>
                </table>
            </div>

            <div class="mt-10">
                <div class="form-title">GENERAL SERVICES BORROW FORM</div>
            </div>

            <div>
                <table width=100%>
                    <tr>
                        <td width="50%"><span class="title">Status: &nbsp;</span> {{ $approval_status }} </span></td>
                        <td><span class="title">Date filed: &nbsp;</span> {{ $date_borrowed }}</td>
                    </tr>
                </table>
                
            </div>

            <div class="mt-10">
                <span class="title"> Office/Department: &nbsp;</span>{{ $office['office']}}
            </div>
            <div class="mt-10">
                <table width=100%>
                    <tr>
                        <td width="50%">
                            <span class="title">Equipment: &nbsp;</span> {{ $equipment['code'] }}
                        </td>
                        <td>
                            <span class="title">Qty: &nbsp;</span> {{ $qty}}
                        </td>
                    </tr>
                </table>
            </div>
            <div class="mt-10">
                <span class="title">Purpose:</span>
                <div>
                    <textarea name="" id="" cols="30" rows="10">
  &nbsp; {{ $purpose }}</textarea
                    >
                </div>
            </div>
            <div class="mt-10">
                <span class="title">Rejection Remarks:</span>
                <div>
                    <textarea name="" id="" cols="30" rows="10">
  &nbsp; {{ $rejection_remarks }}</textarea
                    >
                </div>
            </div>
            <hr class="mt-10" />
            <footer class="mt-20">
                <div class="mt-20">
                    <table width=100%>
                        <tr>
                            <td width="50%">
                                Requested by:
                                <h4 class="mt-10">{{ $borrower['first_name']}} {{ $borrower['last_name']}}</h4>
                            </td>
                            <td>
                                Approved by:
                                <h4 class="mt-10">{{ $approver['first_name']}} {{ $approver['last_name']}}</h4>
                            </td>
                        </tr>
                    </table>
                </div>
            </footer>
        </div>
    </body>
</html>

