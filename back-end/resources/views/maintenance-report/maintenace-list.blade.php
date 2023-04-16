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
            <div class="form-title">LIST OF SERVICES CONDUCTED</div>
        </div>

        <div class="mx-10">
            As of <u>{{ $startDate }}</u> to <u>{{ $endDate }}</u>
        </div>

        <div class="mx-5">
            <table width="100%" class="table" style="font-size: 12px;">
                <thead>
                    <tr>
                        <th>Date Filed</th>
                        <th>Equipment</th>
                        <th>Details</th>
                        <th>Requested by</th>
                        <th>Office</th>
                        <th>Date Served</th>
                        <th>Served by</th>
                        <th>Service</th>
                        <th>Status</th>
                        <th>Evaluation Rating</th>
                        <th>Remarks</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($maintain as $row) : ?>
                        <tr>
                            <td><?= $row->date_filed; ?></td>
                            <td><?= $row->equipment->equipment; ?></td>
                            <td><?= $row->reason; ?></td>
                            <td><?= $row->request_by->designation; ?> <?= $row->request_by->last_name ?>, <?= $row->request_by->first_name ?></td>
                            <td><?= $row->office->office; ?></td>
                            <td><?= $row->date_served; ?></td>
                            <td><?php echo($row->served_by ? $row->served_by->designation. ' '. $row->served_by->last_name. ', ' .$row->served_by->first_name : '') ?></td>
                            <td><?= $row->service->service; ?></td>
                            <td><?= $row->request_status; ?></td>
                            <td><?= $row->satisfaction; ?></td>
                            <td><?= $row->remarks; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div class="mt-20">
            <strong>Prepared by:</strong>
            <div class="mt-10">
                <div style="margin-top: 30px; height: 1px;width: 250px; background-color: black;"></div>
            </div>
        </div>
    </div>
</body>

</html>