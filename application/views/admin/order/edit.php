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
        font-size: 15px !important;
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
        font-size: 15px !important;
        margin-top: 3px !important;
    }
    .select2-container--bootstrap4 .select2-results__option {
        font-size: 12px
    }

    #corninfo .cust-btn-add {
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
    .select2-container--bootstrap4 .select2-selection--single {
        height: 35px !important;
        font-size: 20px
    }
    span.important {
        color: red;
        font-size: 14px
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
        td[data-label*="*"]::before {
            color: red; /* Mengubah warna teks jika mengandung * */
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
            font-size: 12px !important;
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
        #corninfo .cust-btn-add {
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
    }
</style>


<div class="main-content pre-posttest">
    <h3 class="card-title">
        <strong>CONFIRM REQUEST ORDER</strong>
    </h3>
    <div class="row" style="align-items: center; justify-content: center; min-height: 80vh">
        <form class="form-category" action="<?= admin_url('order/do_update') ?>" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="req_no" value="<?= $detail['REQUEST_ORDER']['REQ_NO'] ?>">
            <input type="hidden" name="image_file_old" value="<?= $detail['REQUEST_ORDER']['IMAGE'] ?>">
            <div class="content-task">
                <div class="table-responsive mt-2">
                    <table class="table table-bordered" style="margin-bottom: 0px">
                        <thead>
                            <tr>
                                <th style="text-align: left" width="50%">REQUEST NO</th>
                                <th style="text-align: left" width="50%">REQUEST DATE</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td data-label="REQUEST NO">
                                <input type="text" class="form-control" style="font-size: 14px; width: 100%" value="#<?= $detail['REQUEST_ORDER']['REQ_NO'] ?>" readonly>
                                </td> 
                                <td data-label="REQUEST DATE">
                                    <input type="date" name="req_date" class="form-control" style="font-size: 14px; width: 100%" value="<?php echo date('Y-m-d', strtotime($detail['REQUEST_ORDER']['REQ_DATE'])) ?>" readonly>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <table class="table table-bordered" style="margin-bottom: 0px">
                        <thead>
                            <tr>
                                <th style="text-align: left" width="100%">CUSTOMER <span class="important">*</span></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td data-label="CUSTOMER">
                                    <input type="hidden" id="customer" value="<?= $detail['REQUEST_ORDER']['CUSTOMER'] ?>">
                                    <input type="text" class="form-control" style="font-size: 14px;" placeholder="-" value="<?= $detail['REQUEST_ORDER']['CUSTOMER'] ?> - <?= $detail['REQUEST_ORDER']['FULL_NAME'] ?>" readonly>
                                </td> 
                            </tr>
                        </tbody>
                    </table>

                    <table class="table table-bordered" style="margin-bottom: 0px">
                        <thead>
                            <tr>
                                <th style="text-align: left" width="25%">CREDIT LIMIT</th>
                                <th style="text-align: left" width="25%">REMAIN AMT (A/R)</th>
                                <th style="text-align: left; background: #e6e6e6;" width="25%">A/R OVERDUE</th>
                                <th style="text-align: left; background: #e6e6e6;" width="25%">REMAIN LIMIT</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td data-label="CREDIT LIMIT">
                                    <input type="text" id="credit_limit" class="form-control" style="font-size: 14px;" placeholder="-" readonly>
                                </td>
                                <td data-label="REMAIN AMT (A/R)">
                                    <input type="text" id="remain_amt" class="form-control" style="font-size: 14px;" placeholder="-" readonly>
                                </td>
                                <td data-label="A/R OVERDUE" style="background: #e6e6e6">
                                    <input type="text" id="overdue" class="form-control" style="font-size: 14px;  background: #e6e6e6;" placeholder="-" readonly>
                                </td>
                                <td data-label="REMAIN LIMIT" style="background: #e6e6e6">
                                    <input type="text" id="remain_limit" class="form-control" style="font-size: 14px; background: #e6e6e6;" placeholder="-" readonly>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    
                    <table class="table table-bordered" style="margin-bottom: 0px">
                        <thead>
                            <tr>
                                <th style="text-align: left" width="50%">PROJECT <span class="important">*</span></th>
                                <th style="text-align: left" width="25%">PLAZMA <span class="important">*</span></th>
                                <th style="text-align: left" width="25%">FARM <span class="important">*</span></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td data-label="PROJECT *">
                                    <select id="project" class="form-control" style="width: 100%;" name="project" required>
                                        <option value="" selected>- PILIH PROJECT -</option>
                                        <?php foreach($projects as $item): ?>
                                            <option <?= $detail['REQUEST_ORDER']['PROJECT'] == trim($item['PROJECT']) ? 'selected' : '' ?> value="<?= $item['PROJECT'] ?>"><?= $item['PROJECT'] ?> - <?= $item['PROJECT_NAME'] ?></option>
                                        <?php endforeach ?>
                                    </select>
                                </td>
                                <td data-label="PLAZMA">
                                    <input type="hidden" id="plazma" name="plazma">
                                    <input type="hidden" id="plant" name="plant">
                                    <input type="hidden" id="note" name="note">
                                    <input type="text" id="plazma_text" class="form-control" style="font-size: 14px; width: 100%" placeholder="-" readonly>
                                </td>
                                <td data-label="FARM">
                                    <input type="hidden" id="farm" name="farm">
                                    <input type="text" id="farm_text" class="form-control" style="font-size: 14px; width: 100%" placeholder="-" readonly>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <table class="table table-bordered" style="margin-bottom: 0px">
                        <thead>
                            <tr>
                                <th width="25%" style="text-align: left">REQUEST QTY</th>
                                <th width="25%" style="text-align: left">REQUEST WEIGHT (KG)</th>
                                <th width="50%" style="text-align: left" colspan="2">CUSTOMER NOTE</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td data-label="REQ QTY">
                                    <input value="<?= $detail['REQUEST_ORDER']['REQ_QTY'] ?>" type="text" class="form-control" style="font-size: 14px; width: 100%" placeholder="0" readonly>
                                </td>
                                <td data-label="REQ WEIGHT (KG)">
                                    <input value="<?= $detail['REQUEST_ORDER']['REQ_BW'] ?>" type="text" class="form-control" style="font-size: 14px; width: 100%" placeholder="0" readonly>
                                </td> 
                                <td data-label="CUSTOMER NOTE" colspan="2">
                                    <input value="<?= $detail['REQUEST_ORDER']['REMARKS'] ?>" type="text" class="form-control" style="font-size: 14px; width: 100%" placeholder="0" readonly>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <table class="table table-bordered" style="margin-bottom: 0px">
                        <thead>
                            <tr>
                                <th style="text-align: left">QTY <span class="important">*</span></th>
                                <th style="text-align: left">WEIGHT (KG) <span class="important">*</span></th>
                                <th style="text-align: left">PRICE <span class="important">*</span></th>
                                <th style="text-align: left">AMOUNT</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td data-label="QTY *">
                                    <input value="<?= $detail['REQUEST_ORDER']['REQ_QTY'] ?>" type="text"  
                                    pattern="[0-9]*" name="qty" class="form-control" style="font-size: 14px; width: 100%" placeholder="0" required>
                                </td>
                                <td data-label="WEIGHT (KG) *">
                                    <input value="<?= $detail['REQUEST_ORDER']['REQ_BW'] ?>" type="text" id="bw" name="bw" class="form-control calculateAmount" style="font-size: 14px; width: 100%" placeholder="0" oninput="this.value = this.value.replace(/[^0-9.]/g, '')" required>
                                </td> 
                                <td data-label="PRICE *">
                                    <input value="<?= empty($detail['REQUEST_ORDER']['UP']) ? '' : number_format($detail['REQUEST_ORDER']['UP']) ?>" type="text" id="price" name="price" class="form-control calculateAmount" style="font-size: 14px; width: 100%" placeholder="0" oninput="this.value = this.value.replace(/[^0-9]/g, '')" required>
                                </td>
                                <td data-label="AMOUNT">
                                    <input value="<?= number_format($detail['REQUEST_ORDER']['AMOUNT']) ?>" type="text" id="amount" name="amount" class="form-control" style="font-size: 14px; width: 100%" placeholder="0" readonly>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <table class="table table-bordered" style="margin-bottom: 0px">
                        <thead>
                            <tr>
                                <th style="text-align: left">SIZE <span class="important">*</span></th>
                                <th style="text-align: left">REMARK</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td data-label="SIZE *">
                                    <input value="<?= $detail['REQUEST_ORDER']['RANGE_BW'] ?>" type="text" name="control_no" class="form-control" style="font-size: 14px; width: 100%" placeholder="INPUT SIZE HERE (cth: 1.2 - 1.5)" required>
                                </td>
                                <td data-label="REMARKS">
                                    <input value="<?= $detail['REQUEST_ORDER']['REMARKS'] ?>"  type="text" name="remarks" class="form-control" style="font-size: 14px; width: 100%" placeholder="INPUT REMARKS HERE...">
                                </td> 
                            </tr>
                        </tbody>
                    </table>

                    <table class="table table-bordered" style="margin-bottom: 0px">
                        <thead>
                            <tr>
                                <th style="text-align: left" width="50%">CUSTOMER PHONE NUMBER</th>
                                <th style="text-align: left" width="50%">IMAGE</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td data-label="PHONE NUMBER">
                                    <input value="<?= $detail['REQUEST_ORDER']['CUST_PHONE_NO'] ?>" type="text" name="customer_phone" class="form-control" style="font-size: 14px; width: 100%" placeholder="INPUT PHONE NUMBER HERE...">
                                </td>
                                <td data-label="CONTROL NO">
                                    <input type="file" name="image" class="form-control" style="font-size: 14px; width: 100%">
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">                                
                                    <?php if(!empty($detail['REQUEST_ORDER']['IMAGE'])): ?>
                                        <img style="width: 100%; height: 200px; object-fit: contain" src="<?= base_url('upload/'.$detail['REQUEST_ORDER']['IMAGE']) ?>" alt="">
                                    <?php endif ?>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                </div>
            </div>
               
            <div class="form-group row mt-5" style="margin: 20px 0px !important">
                <div class="col-lg-12 col-sm-12" style="display: flex; padding: 0px">
                    <a href="<?= admin_url('order') ?>" class="btn btn-primary cust-btn-back" style="width: 50%; height: 50px; display: flex; align-items: center; justify-content: center;">CANCEL</a>
                    <span style="margin: 5px;"></span>
                    <button type="submit" class="btn btn-primary cust-btn-save" style="width: 50%; height: 50px">SAVE</button>
                </div>
            </div>
            </form>
    </div>
</div>

<script>
    $(document).ready(function() {
        // loadMPCustomer();
        $("#project").trigger('change');
        loadCustomerLimit();
    });

    // document.querySelectorAll("td").forEach(td => {
    //     let label = td.getAttribute("data-label");
    //     if (label && label.includes("*")) {
    //         let updatedLabel = label.replace("*", '<span style="color:red;">*</span>');
    //         td.setAttribute("data-label", updatedLabel);
    //     }
    // });

    $('#project').select2({
        theme: 'bootstrap4',
        language: "en",
        placeholder: "- PILIH PROJECT -",
    }).on('change', function() {
        loadProject()
    });

    $(".calculateAmount").on('keyup', function() {
        let bw = Number($("#bw").val());
        let price = Number($("#price").val());
        let amount = bw * price;
        console.log(bw, price, amount);
        $("#amount").val(amount);
    });

    function loadMPCustomer() {
        // let customer_phone = $("#customer option:selected").data('phone');
        // $("#customer_phone").val(customer_phone);
    }

    function loadProject() {
        $.ajax({
            url : `<?= base_url('ajax/load/project-detail') ?>`,
            type : "GET",
            data: {
                project: $("#project option:selected").val()
            },
            dataType : "json",
            success:function(data)
            {
                console.log(data);
                $("#plant").val(data["PLANT"]);
                $("#note").val(data["NOTE"]);
                $("#plazma").val(data["PLAZMA"]);
                $("#plazma_text").val(data["PLAZMA"] + " - " +data["PLAZMA_NAME"]);
                $("#farm").val(data["FARM"]);
                $("#farm_text").val(data["FARM"] + " - " +data["FARM_NAME"]);
            }
        });
    }

    function formatRupiah(angka) {
        angka = Number(angka); // Pastikan angka dalam bentuk number
        return 'RP ' + angka.toLocaleString('id-ID');
    }

    function loadCustomerLimit() {
        $.ajax({
            url : `<?= base_url('ajax/load/customer-limit') ?>`,
            type : "GET",
            data: {
                customer: $("#customer").val()
            },
            dataType : "json",
            success:function(response)
            {
                if (response.status == true) {
                    let data = response.data;
                    let limit = data["CREDIT_LIMIT"] - data["REMAIN_AMT"];
                    $("#credit_limit").val(formatRupiah(data["CREDIT_LIMIT"]));
                    $("#remain_amt").val(formatRupiah(data["REMAIN_AMT"]));
                    $("#overdue").val(formatRupiah(data["ABNORMAL_AMT"]));
                    $("#remain_limit").val(formatRupiah(limit));
                    console.log(data);                    
                } else if (response.status == false) {
                    $("#credit_limit").val("-");
                    $("#remain_amt").val("-");
                    $("#overdue").val("-");
                    $("#remain_limit").val("-");

                    alert('CUSTOMER SUDAH TIDAK AKTIF');
                    
                }
            }
        });
    }
</script>
