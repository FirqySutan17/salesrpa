<style>
    .pre-posttest h3 {
        font-weight: 700;
        border-bottom: 2px solid #000;
        padding-bottom: 10px;
        margin-bottom: 10px;
    }

    .pre-posttest h4 {
        font-weight: 500;
        font-style: italic
    }

    .qna {
        margin-bottom: 20px
    }

    .qna label {
        font-weight: 500 !important;
    }

    .answer {
        margin-top: 10px
    }

    input {
        display: inline-block;
        vertical-align: middle;
        margin-top: 2px !important;
        margin-right: 8px !important;
    }

    .question {
        font-size: 17px;
        font-weight: 600
    }

    h3.sub-title {
        font-size: 16px;
        text-decoration: none;
        margin-top: 10px;
        /* margin-bottom: 20px; */
        border-bottom: 1px solid #000;
        text-transform: uppercase;
        font-weight: 700;
        padding-bottom: 15px;
        font-size: 14px !important;
    }

    .box-att {
        background: #007bff;
        color: #fff;
        padding: 20px;
        border-radius: 10px
    }

    .divi-delayed-button-2 {
        text-align: center;
        padding: 15px;
        font-weight: 800;
        font-size: 18px;
        border: none;
        /* border-top-right-radius: 10px; */
        background: #007bff;
        color: #fff;
        border-radius: 8px;
        margin-bottom: 20px
    }

    .divi-delayed-button-2:hover {
        background: #58a9ff
    }

    .content-task {
        /* border-top: 1px solid #000;
        border-bottom: 1px solid #000; */
        /* margin-bottom: 10px; */
        margin-top: 15px !important;
        border-bottom: 1px solid #000;
    }

    .answer {
        margin-left: 25px;
        display: flex;
        justify-content: left;
        align-content: center;
    }

    [type="checkbox"],
    [type="radio"] {
        width: 15px !important;
    }

    @media(max-width: 600px) {
        .answer {
            margin-left: 0px
        }

        input {
            margin-right: 10px !important
        }

        [type="checkbox"],
        [type="radio"] {
            width: 30px !important;
        }

        .question {
            line-height: 25px;
            font-size: 18px
        }
    }
</style>

<style>
    table.dataTable th {
        position: relative;
        text-align: center
    }

    table.dataTable thead .sorting:after,
    table.dataTable thead .sorting_asc:after,
    table.dataTable thead .sorting_desc:after,
    table.dataTable thead .sorting_asc_disabled:after,
    table.dataTable thead .sorting_desc_disabled:after {
        position: absolute;
        bottom: 5px;
        right: 5px;
    }

    table.dataTable thead>tr>th.sorting_asc,
    table.dataTable thead>tr>th.sorting_desc,
    table.dataTable thead>tr>th.sorting,
    table.dataTable thead>tr>td.sorting_asc,
    table.dataTable thead>tr>td.sorting_desc,
    table.dataTable thead>tr>td.sorting {
        padding: 10px 20px;
    }

    .table>tbody>tr>td,
    .table>tbody>tr>th,
    .table>tfoot>tr>td,
    .table>tfoot>tr>th,
    .table>thead>tr>td,
    .table>thead>tr>th {
        vertical-align: middle;
    }

    select.input-sm {
        height: 40px;
        line-height: 30px;
        text-align: center;
    }

    .box-header {
        background: #3c8dbc;
        border: 4px solid #000;
        border-radius: 10px 10px 0px 0px;
        padding: 25px 0px;
    }

    .box.box-solid.box-primary {
        border-top: none;
        border: 0px solid transparent
    }

    .box-title {
        font-size: 24px;
        font-weight: 700;
        text-transform: uppercase;
        color: #fff;
    }

    .box.box-info {
        border-top-color: transparent;
    }

    .content {
        padding: 0px
    }

    .date-range {
        background-color: #000;
        color: #fff;
        text-align: center;
        width: 100%;
        padding: 8px 16px;
        border-radius: 0px 0px 10px 10px;
        border: 2px solid #000;
        font-weight: 600
    }

    .box-header.with-border {
        border-bottom: 1px solid #f4f4f4;
    }

    .b-style {
        font-family: cjFont;
        font-size: 14px;
        color: #0f172a;
        margin-bottom: 0px;
        background: transparent;
        padding: 0px;
        padding-top: 5px
    }

    table.table-bordered.dataTable th, table.table-bordered.dataTable td {
        font-size: 10px !important
    }

    table.dataTable thead .sorting:after, table.dataTable thead .sorting_asc:after, table.dataTable thead .sorting_desc:after, table.dataTable thead .sorting_asc_disabled:after, table.dataTable thead .sorting_desc_disabled:after {
        bottom: 10px !important;
    }

    select.input-sm {
        height: 30px;
        line-height: 20px;
        margin: 0px 5px
    }

    div.dataTables_wrapper div.dataTables_length select {
        width: 50px;
    }
    div.dataTables_wrapper div.dataTables_info {
        padding-top: 8px;
        white-space: nowrap;
        font-size: 10px !important;
    }
    .pagination>.disabled>a, .pagination>.disabled>a:focus, .pagination>.disabled>a:hover, .pagination>.disabled>span, .pagination>.disabled>span:focus, .pagination>.disabled>span:hover {
        font-size: 11px
    }
    .pagination>.active>a, .pagination>.active>a:focus, .pagination>.active>a:hover, .pagination>.active>span, .pagination>.active>span:focus, .pagination>.active>span:hover {
        font-size: 11px;
    }
    div.dataTables_wrapper div.dataTables_length label {
        font-size: 11px;
    }
    td {
        height: auto;
        padding: 10px !important
    }
    div.dataTables_wrapper div.dataTables_filter label {
        font-weight: normal;
        white-space: nowrap;
        text-align: left;
        font-size: 11px;
        display: inline-block;
        vertical-align: middle;
    }
    .pagination>li>a, .pagination>li>span {
        position: relative;
        float: left;
        padding: 6px 12px;
        margin-left: -1px;
        line-height: 1.42857143;
        color: #337ab7;
        text-decoration: none;
        background-color: #fff;
        border: 1px solid #ddd;
        font-size: 11px;
    }
    .table-responsive {
        width: 100%
    }
    .table-w-message {
        width: 1330px;
    }
    .c-form {
        max-width: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .cust-btn-back {
        color: red;
        border: 1px solid red;
        background: #fff;
    }
    .cust-btn-back:hover {
        background: red;
        color: #fff;
        border: 1px solid red;
    }
    .row {
        margin: 0px !important;
    }
    #customerdetail td {
        background-color: #eee;
    }

    th, td {
        font-size: 10px !important;
        text-align: center;
    }
    input {
        font-size: 12px !important;
        text-align: center;
    }
    .wrapper-reason {
        display: grid;
        grid-template-columns: repeat(8, 1fr);
        width: 100%;
    }
    .wrapper-reason .col-item {
        grid-column: span 4;
    }
    .cust-btn-add {
        background: green;
        color: #fff;
        width: 120px;
        padding: 5px;
        border: 1px solid transparent;
        font-weight: 700
    }
    .cust-btn-add:hover {
        border: 1px solid green;
    }
    .select2-container .select2-selection--single .select2-selection__rendered {
        font-size: 13px !important;
        margin-top: 3px !important;
    }
    .select2-container--bootstrap4 .select2-results__option {
        font-size: 12px
    }

    .maps-frame {
        border:2px solid #C1C1C1; 
        border-radius: 10px;
        width: 100%;
        height: 350px;
    }

    @media (max-width: 1024px) {
        #region_entry {
            margin-bottom: 20px
        }
        .wrapper-reason .col-item {
            grid-column: span 8;
        }
        h3.sub-title {
            line-height: 25px;
        }
    }
</style>
<style>
    .pre-posttest h3 {
        font-weight: 700;
        border-bottom: 2px solid #000;
        padding-bottom: 10px;
        margin-bottom: 10px;
    }

    .pre-posttest h4 {
        font-weight: 500;
        font-style: italic
    }

    .qna {
        margin-bottom: 20px
    }

    .qna label {
        font-weight: 500 !important;
    }

    .answer {
        margin-top: 10px
    }

    input {
        display: inline-block;
        vertical-align: middle;
        margin-top: 2px !important;
        margin-right: 8px !important;
    }

    .question {
        font-size: 17px;
        font-weight: 600
    }

    h3.sub-title {
        font-size: 16px;
        text-decoration: none;
        margin-top: 10px;
        /* margin-bottom: 20px; */
        border-bottom: 1px solid #000;
        text-transform: uppercase;
        font-weight: 700;
        padding-bottom: 15px;
        font-size: 14px !important;
    }

    .box-att {
        background: #007bff;
        color: #fff;
        padding: 20px;
        border-radius: 10px
    }

    .divi-delayed-button-2 {
        text-align: center;
        padding: 15px;
        font-weight: 800;
        font-size: 18px;
        border: none;
        /* border-top-right-radius: 10px; */
        background: #007bff;
        color: #fff;
        border-radius: 8px;
        margin-bottom: 20px
    }

    .divi-delayed-button-2:hover {
        background: #58a9ff
    }

    .content-task {
        /* border-top: 1px solid #000;
        border-bottom: 1px solid #000; */
        /* margin-bottom: 10px; */
        margin-top: 15px !important;
        border-bottom: 1px solid #000;
    }

    .answer {
        margin-left: 25px;
        display: flex;
        justify-content: left;
        align-content: center;
    }

    [type="checkbox"],
    [type="radio"] {
        width: 15px !important;
    }

    .text-mobile {
        display: none;
    }

    
</style>

<style>
    table.dataTable th {
        position: relative;
        text-align: center
    }

    table.dataTable thead .sorting:after,
    table.dataTable thead .sorting_asc:after,
    table.dataTable thead .sorting_desc:after,
    table.dataTable thead .sorting_asc_disabled:after,
    table.dataTable thead .sorting_desc_disabled:after {
        position: absolute;
        bottom: 5px;
        right: 5px;
    }

    table.dataTable thead>tr>th.sorting_asc,
    table.dataTable thead>tr>th.sorting_desc,
    table.dataTable thead>tr>th.sorting,
    table.dataTable thead>tr>td.sorting_asc,
    table.dataTable thead>tr>td.sorting_desc,
    table.dataTable thead>tr>td.sorting {
        padding: 10px 20px;
    }

    .table>tbody>tr>td,
    .table>tbody>tr>th,
    .table>tfoot>tr>td,
    .table>tfoot>tr>th,
    .table>thead>tr>td,
    .table>thead>tr>th {
        vertical-align: middle;
    }

    select.input-sm {
        height: 40px;
        line-height: 30px;
        text-align: center;
    }

    .box-header {
        background: #3c8dbc;
        border: 4px solid #000;
        border-radius: 10px 10px 0px 0px;
        padding: 25px 0px;
    }

    .box.box-solid.box-primary {
        border-top: none;
        border: 0px solid transparent
    }

    .box-title {
        font-size: 24px;
        font-weight: 700;
        text-transform: uppercase;
        color: #fff;
    }

    .box.box-info {
        border-top-color: transparent;
    }

    .content {
        padding: 0px
    }

    .date-range {
        background-color: #000;
        color: #fff;
        text-align: center;
        width: 100%;
        padding: 8px 16px;
        border-radius: 0px 0px 10px 10px;
        border: 2px solid #000;
        font-weight: 600
    }

    .box-header.with-border {
        border-bottom: 1px solid #f4f4f4;
    }

    .b-style {
        font-family: cjFont;
        font-size: 14px;
        color: #0f172a;
        margin-bottom: 0px;
        background: transparent;
        padding: 0px;
        padding-top: 5px
    }

    table.table-bordered.dataTable th, table.table-bordered.dataTable td {
        font-size: 10px !important
    }

    table.dataTable thead .sorting:after, table.dataTable thead .sorting_asc:after, table.dataTable thead .sorting_desc:after, table.dataTable thead .sorting_asc_disabled:after, table.dataTable thead .sorting_desc_disabled:after {
        bottom: 10px !important;
    }

    select.input-sm {
        height: 30px;
        line-height: 20px;
        margin: 0px 5px
    }

    div.dataTables_wrapper div.dataTables_length select {
        width: 50px;
    }
    div.dataTables_wrapper div.dataTables_info {
        padding-top: 8px;
        white-space: nowrap;
        font-size: 10px !important;
    }
    .pagination>.disabled>a, .pagination>.disabled>a:focus, .pagination>.disabled>a:hover, .pagination>.disabled>span, .pagination>.disabled>span:focus, .pagination>.disabled>span:hover {
        font-size: 11px
    }
    .pagination>.active>a, .pagination>.active>a:focus, .pagination>.active>a:hover, .pagination>.active>span, .pagination>.active>span:focus, .pagination>.active>span:hover {
        font-size: 11px;
    }
    div.dataTables_wrapper div.dataTables_length label {
        font-size: 11px;
    }
    td {
        height: auto;
        padding: 10px !important
    }
    div.dataTables_wrapper div.dataTables_filter label {
        font-weight: normal;
        white-space: nowrap;
        text-align: left;
        font-size: 11px;
        display: inline-block;
        vertical-align: middle;
    }
    .pagination>li>a, .pagination>li>span {
        position: relative;
        float: left;
        padding: 6px 12px;
        margin-left: -1px;
        line-height: 1.42857143;
        color: #337ab7;
        text-decoration: none;
        background-color: #fff;
        border: 1px solid #ddd;
        font-size: 11px;
    }
    .table-responsive {
        width: 100%
    }
    .table-w-message {
        width: 1330px;
    }
    .c-form {
        max-width: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .cust-btn-back {
        color: red;
        border: 1px solid red;
        background: #fff;
    }
    .cust-btn-back:hover {
        background: red;
        color: #fff;
        border: 1px solid red;
    }
    .row {
        margin: 0px !important;
    }
    #customerdetail td {
        background-color: #eee;
    }

    th, td {
        font-size: 10px !important;
        text-align: center;
    }
    input {
        font-size: 12px !important;
        text-align: center;
    }
    .wrapper-reason {
        display: grid;
        grid-template-columns: repeat(8, 1fr);
        width: 100%;
    }
    .wrapper-reason .col-item {
        grid-column: span 4;
    }
    .cust-btn-add {
        background: green;
        color: #fff;
        width: 120px;
        padding: 5px;
        border: 1px solid transparent;
        font-weight: 700
    }
    .cust-btn-add:hover {
        border: 1px solid green;
    }
    .select2-container .select2-selection--single .select2-selection__rendered {
        font-size: 12px !important;
        margin-top: 3px !important;
    }
    .select2-container--bootstrap4 .select2-results__option {
        font-size: 12px
    }

    #customersinfo .cust-btn-add {
        display: none;
    }
    #segment .cust-btn-add {
        display: none;
    }
    #marketprice .cust-btn-add {
        display: none;
    }
    #visitimages .cust-btn-add {
        display: none;
    }
    .w-25 {
        width: 25% !important;
    }
    textarea {
        min-height: 115px;
        overflow: auto;
    }
    .th-mobile {
        display: none;
    }

    @media (max-width: 1024px) {
        #region_entry {
            margin-bottom: 20px
        }
        .wrapper-reason .col-item {
            grid-column: span 8;
        }
        h3.sub-title {
            line-height: 25px;
        }
    }

    @media(max-width: 600px) {
        .th-mobile {
            display: block;
        }
        .w-25 {
            width: 100% !important;
        }
        .w-25 textarea {
            min-height: 115px;
            overflow: auto;
        }
        .answer {
            margin-left: 0px
        }

        input {
            margin-right: 10px !important
        }
        input[type=date].form-control, input[type=time].form-control, input[type=datetime-local].form-control, input[type=month].form-control {
            line-height: 20px;
        }

        [type="checkbox"],
        [type="radio"] {
            width: 30px !important;
        }

        .question {
            line-height: 25px;
            font-size: 18px
        }
        table thead {
            display: none;
        }
        table, table tbody, table tr, table td {
            display: flex;
            flex-direction: column;
            width: 100%;
        } 
        th, td {
            font-size: 12px !important;
            text-align: center;
        }
        table tbody tr td {
            text-align: center;
            padding-left: 50%;
            position: relative;
            white-space: normal !important;
            font-size: 12px !important;

        }
        input {
            font-size: 14px !important;
        }
        select {
            font-size: 12px !important;
        }
        textarea {
            font-size: 12px !important;
        }
        table td:before {
            content: attr(data-label);
            width: 100%;
            font-weight: 600;
            font-size: 13px;
            text-align: left;
            text-transform: uppercase;
            margin-bottom: 5px;
        } 
        .ts-asm {
            display: none;
        }
        .h-it {
            height: auto !important;
        }
        .text-desktop {
            display: none;
        }
        .text-mobile {
            display: block;
            font-size: 14px !important;
            font-weight: 600;
            text-transform: uppercase;
            padding: 15px 0px;
            vertical-align: middle !important;
        }
        th {
            height: auto !important;
            padding: 15px !important;
        }
        #customersinfo .cust-btn-add {
            display: block;
        }
        #segment .cust-btn-add {
            display: block;
        }
        #marketprice .cust-btn-add {
            display: block;
        }
        #visitimages .cust-btn-add {
            display: block;
        }
        .select2-container .select2-selection--single .select2-selection__rendered {
            font-size: 14px !important;
        }
        .select2-container--bootstrap4 .select2-selection--single {
            height: calc(2.5em + .75rem + 2px) !important;
        }
        .btn-group-sm>.btn, .btn-sm {
            font-size: 18px !important;
        }
        .btn.cust-btn-add {
            width: 100%;
            font-size: 22px;
            padding: 10px;
        }
        .th-mobile {
            width: 100%
        }
    }
</style>

<div class="main-content pre-posttest">
    <h3 class="card-title">
        <strong>PLAN ACTIVITY</strong>
    </h3>
    <div class="row">
        <form action="<?= admin_url('sales/activity/save-plan') ?>" method="POST" enctype="multipart/form-data">
            <div class="content-task mt-5">
                    <div class="table-responsive">
                         <table class="table table-bordered" style="margin-bottom: 20px">
                            <thead>
                                <tr>
                                    <th style="text-align: left" width="20%">ACTIVITY NUMBER</th>
                                    <th style="text-align: left" width="30%">DATE</th>
                                    <th style="text-align: left" width="50%">SALES</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td data-label="ACTIVITY NUMBER">
                                        <input type="text" class="form-control" style="font-size: 14px; width: 100%" name="activity_no" value="<?= $plan['ACTIVITY_NO'] ?>" readonly>
                                    </td> 
                                    <td data-label="DATE">
                                        <input type="text" class="form-control" style="font-size: 14px; width: 100%" name="activity_date" value="<?= date('d-m-Y', strtotime($plan['ACTIVITY_DATE'])) ?>" readonly>
                                    </td> 
                                    <td data-label="SALES NAME">
                                        <input type="hidden" name="sales_npk" value="<?= $plan['SALES_NPK'] ?>">
                                        <input type="text" name="sales_name" class="form-control" style="font-size: 14px; width: 100%" value="<?= $plan['SALES_NAME'] ?>" readonly>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <h3 class="sub-title" style="margin-top: 20px; padding: 20px 10px; background: #eee; border: 1px solid #ddd; margin-bottom: 0px !important;">CUSTOMER CJ</h3>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th colspan="5" style="text-align: right; background: #fff; border: 0px"><button type="button" class="btn cust-btn-add" onclick="addCustomers()">+</button></th>
                                </tr>
                                <tr>
                                    <th>CUSTOMER</th>
                                    <th>PHONE NUMBER</th>
                                    <th>ALAMAT</th>
                                    <th>PLAN</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody id="customersinfo">
                                <?php foreach ($plan_activities as $key => $cust): ?>
                                <tr style="align-items: flex-end">
                                    <th class="th-mobile" style="text-align: left; background: #fff; border: 0px;"><button type="button" class="btn cust-btn-add" onclick="addCustomers()">+</button></th>
                                </tr>
                                <tr>
                                    <td data-label="CUSTOMER">
                                        <select name="cust[]" class="form-control customer-select" style="width: 100%;" required>
                                            <option value="">- PILIH CUSTOMER -</option>
                                            <?php foreach ($customer as $item): ?>
                                                <option value="<?= $item['CUST'] ?>" <?= ($item['CUST'] == $cust['CUST']) ? 'selected' : '' ?>>
                                                    <?= $item['CUST'] ?> - <?= $item['FULL_NAME'] ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                        <!-- Simpan nama juga jika perlu -->
                                        <input type="hidden" name="cust_name[]" value="<?= $cust['CUST_NAME'] ?>" class="form-control name-field">
                                    </td>
                                    <td data-label="CONTACT PHONE">
                                        <input type="text" name="phone[]" value="<?= $cust['PHONE'] ?>" class="form-control phone-field" style="font-size: 14px;" readonly>
                                    </td>
                                    <td data-label="ADDRESS">
                                        <textarea name="address[]" class="address-field" style="width: 100%;padding: 10px; border-radius: 5px !important; background-color: #eee; border-color: #d2d6de; text-transform: uppercase; color: #555;" rows="3" readonly><?= $cust['ADDRESS'] ?></textarea>
                                    </td>
                                    <td data-label="PLAN">
                                        <textarea required name="target_plan[]" placeholder="CTH : MENAWARKAN PENJUALAN AYAM...." style="width: 100%;padding: 10px; border-radius: 5px !important; border-color: #d2d6de; text-transform: uppercase;" id="" rows="3" required><?= $cust['TARGET_PLAN'] ?></textarea>
                                    </td>
                                    <td><a onclick="deleteRow(this)" href="javascript:void(0)" class="btn btn-sm" title="Hapus"><i class="fas fa-trash text-danger" style="width: 18px"></i></a></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>

                        <h3 class="sub-title" style="margin-top: 20px; padding: 20px; background: #eee; border: 1px solid #ddd; margin-bottom: 0px !important;">NEW CUSTOMER</h3>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th colspan="6" style="text-align: right; background: #fff; border: 0px"><button type="button" class="btn cust-btn-add" onclick="addOthers()">+</button></th>
                                </tr>
                                <tr>
                                    <th>CUSTOMER</th>
                                    <th>PHONE</th>
                                    <th>ADDRESS</th>
                                    <th>PLAN</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody id="othersinfo">
                                <input type="hidden" id="deleted_other_id" name="deleted_other_id[]" value="" />
                                <?php foreach ($other_activities as $key => $other): ?>
                                <tr style="align-items: flex-end">
                                    <th class="th-mobile" style="text-align: left; background: #fff; border: 0px;"><button type="button" class="btn cust-btn-add" onclick="addOthers()">+</button></th>
                                </tr>
                                <tr>
                                    <td data-label="CUSTOMER">
                                        <input type="hidden" name="other_id[]" value="<?= $other['ID'] ?>">
                                        <input type="text" name="other_customer[]" class="form-control" placeholder="CTH: PT. SUPER UNGGAS JAYA" value="<?= $other['CUSTOMER'] ?>" />
                                    </td>
                                    <td data-label="CONTACT PHONE">
                                        <input type="text" name="other_phone[]" placeholder="CTH : 08XXXXXX" class="form-control" style="font-size: 14px;"  value="<?= $other['PHONE'] ?>" />
                                    </td>
                                    <td data-label="ADDRESS">
                                        <textarea name="other_address_plan[]" placeholder="CTH : MENARA JAMSOSTEK, JAKARTA SELATAN" style="width: 100%;padding: 10px; border-radius: 5px !important; border-color: #d2d6de; text-transform: uppercase; color: #555;" rows="3" ><?= $other['ADDRESS_PLAN'] ?></textarea>
                                    </td>
                                    <td data-label="PLAN">
                                        <textarea name="other_target[]" class="form-control" placeholder="CTH: Menawarkan penjualan ayam..." style="width: 100%;padding: 10px; border-radius: 5px !important; border-color: #d2d6de; text-transform: uppercase;" id="" rows="3"><?= $other['TARGET_PLAN'] ?></textarea>
                                    </td>
                                    <td>
                                        <a href="javascript:void(0)" onclick="deleteRow(this)" class="btn btn-sm"><i class="fas fa-trash text-danger"></i></a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
            </div>

            <div class="form-group row mt-5" style="margin: 20px 0px !important">
                <div class="col-lg-12 col-sm-12" style="display: flex; padding: 0px">
                    <a href="<?= admin_url('sales/activity') ?>" class="btn btn-primary cust-btn-back" style="width: 50%; height: 50px; display: flex; align-items: center; justify-content: center;">CANCEL</a>
                    <span style="margin: 5px;"></span>
                    <button type="submit" class="btn btn-primary cust-btn-save" style="width: 50%; height: 50px">SAVE</button>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBLUc8QC0GYh5ozbMbGBcNUm1BBIjvmmg8&callback=myMap"></script> -->
<script>
    const customerData = <?= json_encode($customer) ?>;

    // Generate select options dari PHP (satu kali saja)
    const customerOptionsHtml = `
        <option value="" selected>- PILIH CUSTOMER -</option>
        <?php foreach($customer as $item): ?>
            <option value="<?= $item['CUST'] ?>"><?= $item['CUST'] ?> - <?= $item['FULL_NAME'] ?></option>
        <?php endforeach ?>
    `;

    $('.customer-select').select2({
        theme: 'bootstrap4',
        language: 'en',
        placeholder: '- SELECT CUSTOMER -'
    });

    // Auto isi telepon & alamat saat pilih customer
    $(document).on('change', '.customer-select', function () {
        const selectedVal = $(this).val();
        const selectedRow = $(this).closest('tr');

        const customer = customerData.find(c => c.CUST === selectedVal);

        if (customer) {
            selectedRow.find('.phone-field').val(customer.MOBILE_PHONE);
            selectedRow.find('.address-field').val(customer.ADDRESS);
            selectedRow.find('.name-field').val(customer.FULL_NAME);
        } else {
            selectedRow.find('.phone-field').val('');
            selectedRow.find('.address-field').val('');
            selectedRow.find('.name-field').val('');
        }
    });

    function addCustomers() {
        let tabledata = `
        <tr>
            <td data-label="CUSTOMER">
                <select class="form-control customer-select" style="width: 100%;" name="cust[]" required>
                    ${customerOptionsHtml}
                </select>
            </td>
            <td data-label="CONTACT PHONE">
                <input type="hidden" name="cust_name[]" class="form-control name-field">
                <input type="text" name="phone[]" class="form-control phone-field" style="font-size: 14px;" readonly>
            </td>
            <td data-label="ADDRESS">
                <textarea name="address[]" class="address-field" style="width: 100%;padding: 10px; border-radius: 5px !important; background-color: #eee; border-color: #d2d6de; text-transform: uppercase; color: #555;" rows="3" readonly></textarea>
            </td>
            <td data-label="PLAN">
                <textarea required name="target_plan[]" placeholder="CTH : MENAWARKAN PENJUALAN AYAM...." style="width: 100%;padding: 10px; border-radius: 5px !important; border-color: #d2d6de; text-transform: uppercase;" rows="3" required></textarea>
            </td>
            <td><a onclick="deleteRow(this)" href="javascript:void(0)" class="btn btn-sm" title="Hapus"><i class="fas fa-trash text-danger" style="width: 18px"></i></a></td>
        </tr>
        `;

        $("#customersinfo").append(tabledata);

        // Inisialisasi ulang Select2 hanya untuk elemen baru
        $("#customersinfo .customer-select").last().select2({
            theme: 'bootstrap4',
            language: "en",
            placeholder: "- SELECT CUSTOMER -"
        });
    }

    function addOthers() {
        let tabledata = `
        <tr>
            <td data-label="CUSTOMER">
                <input type="hidden" name="other_id[]" value="">
                <input type="text" name="other_customer[]" class="form-control" placeholder="CTH: PT. SUPER UNGGAS JAYA" />
            </td>
            <td data-label="CONTACT PHONE">
                <input type="text" name="other_phone[]" placeholder="CTH : 08XXXXXX" class="form-control" style="font-size: 14px;" >
            </td>
            <td data-label="ADDRESS">
                <textarea name="other_address_plan[]" placeholder="CTH : MENARA JAMSOSTEK, JAKARTA SELATAN" style="width: 100%;padding: 10px; border-radius: 5px !important; border-color: #d2d6de; text-transform: uppercase; color: #555;" rows="3" ></textarea>
            </td>
            <td data-label="REMARK">
                <textarea name="other_target[]" class="form-control" placeholder="CTH: Menawarkan penjualan ayam..." style="width: 100%;padding: 10px; border-radius: 5px !important; border-color: #d2d6de; text-transform: uppercase; font-size: 12px" id="" rows="5" required></textarea>
            </td>
            <td>
                <a href="javascript:void(0)" onclick="deleteRow(this)" class="btn btn-sm"><i class="fas fa-trash text-danger"></i></a>
            </td>
        </tr>
        `;

        $("#othersinfo").append(tabledata);
    }

    $(document).ready(function() {
        $('.cust-btn-save').on('click', function() {
            $(this).prop('disabled', true);
            $(this).text('Saving...'); // opsional, ganti teks
            $(this).closest('form').submit(); // pastikan form tetap disubmit
            });
        });

        function deleteRow(btn) {
        const row = btn.closest('tr');
        const otherIdInput = row.querySelector('input[name="other_id[]"]');
        
        if (otherIdInput && otherIdInput.value) {
            // Ada ID, artinya baris dari tabel "others" yang sudah tersimpan di DB
            let container = document.getElementById('deletedOtherIdsContainer');
            if (!container) {
                container = document.createElement('div');
                container.id = 'deletedOtherIdsContainer';
                container.style.display = 'none';
                row.closest('form').appendChild(container);
            }
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'deleted_other_id[]';
            input.value = otherIdInput.value;
            container.appendChild(input);
        }

        // Hapus baris dari tabel (baik customers maupun others)
        row.remove();
    }

    // function deleteRow(e) {
    //     Swal.fire({
    //         type: "warning",
    //         title: "Delete Row",
    //         showCancelButton: true,
    //         text: "Are you sure want to delete this data ?"
    //     }).then((result) => {
    //         if (result.value) {
    //             $(e).parent().parent().remove();
    //         }
    //     });
    // }

    function deleteRowSegment(e) {
        Swal.fire({
            type: "warning",
            title: "Delete Row",
            showCancelButton: true,
            text: "Are you sure want to delete this cycle ?"
        }).then((result) => {
            if (result.value) {
                $("#segment-" + e).remove();
            }
        });
    }
</script>