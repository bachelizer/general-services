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
                <div class="form-title">GENERAL SERVICES MAINTENANCE FORM</div>
            </div>
            <div class="mt-10 mb-10">
                <div class="form-sub-title">REQUEST</div>
            </div>
            <div>
                <table width=100%>
                    <tr>
                        <td width="50%"><span class="title">Status: &nbsp;</span> {{ $request_status }} </span></td>
                        <td><span class="title">Date filed: &nbsp;</span>{{ $date_filed }}</td>
                    </tr>
                </table>
                
            </div>

            <div class="mt-10">
                <span class="title"> Office/Department: &nbsp;</span> {{ $office['office'] }}
            </div>
            <div class="mt-10">
                <table width=100%>
                    <tr>
                        <td width="50%">
                            <span class="title">Type of Service Requested: &nbsp;</span> {{ $service['service'] }}
                        </td>
                        <td>
                            <span class="title">Equipment: &nbsp;</span> {{ $equipment['equipment'] }}
                        </td>
                    </tr>
                </table>
            </div>
            <div class="mt-10">
                <span class="title">Details:</span>
                <div>
                    <textarea name="" id="" cols="30" rows="10">
  &nbsp; {{ $reason }}</textarea
                    >
                </div>
            </div>
            <div class="mt-20">
                <i class="mt-10">To be filled up by General Services personnel ONLY</i>
               <fieldset>
                <span class="title">Action Taken:</span>
                <div>
                    <textarea name="" id="" cols="30" rows="5"> {{ $action_taken }}</textarea>
                </div>
                    <div>
                        <table width=100%>
                            <tr>
                                <td width="50%"><span class="title">Time Started: &nbsp; </span> {{ $time_start }}</td>
                                <td><span class="title">Time Ended: &nbsp;</span> {{ $time_end }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="mb-10">
                        <span class="title">Date Served: &nbsp; </span> {{ $date_served }}
                    </div>
                   
               </fieldset>
               
            </div>
            <div class="mt-10 mb-10">
                <div class="form-sub-title">EVALUATION</div>
            </div>
            <div>
                <span>HOW SATISFIED ARE YOU WITH OUR SERVICE? </span>&nbsp; <span class="title">{{ $satisfaction }}</span>
            </div>
            <div class="mt-10 mb-10">
                <span class="title">Remarks/Recommendations:</span>
            <div>
                <textarea name="" id="" cols="30" rows="5"> {{ $remarks }} </textarea>
            </div>
            </div>
            
          
            <hr class="mt-10" />
            <footer>
                <div class="mt-20">
                    <table width=100%>
                        <tr>
                            <td width="50%">
                                Requested and Evaluated by:
                                <h4 class="mt-10">{{ $request_by['first_name'] }} {{ $request_by['last_name'] }}</h4>
                            </td>
                            <td>
                                Served by:
                                <?php if($served_by_3rd_party != null) { ?>
                                    <h4 class="mt-10">{{ $served_by_3rd_party['institution_name'] }}</h4>
                                 <?php } else { ?>
                                    <h4 class="mt-10">{{ $served_by['first_name'] }} {{ $served_by['last_name'] }}</h4>
                                <?php } ?>
                            </td>
                        </tr>
                    </table>
                </div>
            </footer>
        </div>
    </body>
</html>
