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
            <div class="form-title">LIST OF BORROWED ITEMS</div>
        </div>

        <div class="mx-10">
            As of <u>{{ $startDate }}</u> to <u>{{ $endDate }}</u>
        </div>

        <div class="mx-5">
            <table width="100%" class="table" style="font-size: 12px;">
                <thead>
                    <tr>
                        <th>Date Borrowed</th>
                        <th>Equipment</th>
                        <th>Quantity</th>
                        <th>Borrower</th>
                        <th>Office</th>
                        <th>Purpose</th>
                        <th>Approved by</th>
                        <th>Date returned</th>
                        <th>Status</th>
                        <th>Rejection Remarks</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($borrows as $row): ?>
                    <tr>
                        <td><?= $row->date_borrowed; ?></td>
                        <td><?= $row->equipment->code; ?></td>
                        <td><?= $row->qty; ?></td>
                        <td><?php echo($row->borrower->designation ? $row->borrower->designation : ''); echo(". ".$row->borrower->last_name); echo(', ' .$row->borrower->first_name); ?></td>
                        <td><?= $row->office->office; ?></td>
                        <td><?= $row->purpose; ?></td>
                        <td><?php  echo( $row->approver ? $row->approver->last_name.', ' .$row->approver->first_name : ''); ?></td>
                        <td><?= $row->date_returned; ?></td>
                        <td><?= $row->approval_status; ?></td>
                        <td><?= $row->rejection_remarks; ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div class="mt-20">
            <strong>Prepared by:</strong>
            <div  class="mt-10">
            <div style="margin-top: 30px; height: 1px;width: 250px; background-color: black;"></div>
            </div>
        </div>
    </div>
</body>

</html>