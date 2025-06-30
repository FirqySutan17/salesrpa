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
        width: 100%;
        border: none !important; 
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
        font-size: 10px !important;
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
        font-size: 10px !important;
        margin-top: 3px !important;
    }
    .select2-container--bootstrap4 .select2-results__option {
        font-size: 12px
    }

    #farmersinfo .cust-btn-add {
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

    th, td {
        border: 2px solid #ddd !important;
    }

    .upload-img {
        width: 10%
    }

    label.actual-btn {
        background-color: red;
        color: white;
        padding: 10px 15px;
        border-radius: 0.3rem;
        cursor: pointer;
        margin-top: 1rem;
    }

    textarea, input, button {
        font-size: 12px !important;
        text-transform: uppercase;
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
        #farmersinfo .cust-btn-add {
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
        .upload-img {
            width: 100%
        }
        .btn.cust-btn-add {
            width: 100%;
            font-size: 22px;
            padding: 10px;
        }
        .th-mobile {
            width: 100%;
            display: block;
        }
    }
</style>

<div class="main-content pre-posttest">
    <h3 class="card-title">
        <strong>ACTUAL ACTIVITY</strong>
    </h3>
    <div class="row">
        <form action="<?= base_url('dashboard/sales/activity/update') ?>" method="POST" enctype="multipart/form-data">
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
                                        <input type="text" class="form-control" style="font-size: 14px; width: 100%" name="activity_no" value="#<?= $plan['ACTIVITY_NO'] ?>" readonly>
                                    </td> 
                                    <td data-label="DATE">
                                        <input type="text" class="form-control" style="font-size: 14px; width: 100%" name="activity_date" value="<?= $plan['ACTIVITY_DATE'] ?>" readonly>
                                    </td> 
                                    <td data-label="SALES NAME">
                                        <input type="hidden" name="sales_npk" value="<?= $plan['SALES_NPK'] ?>">
                                        <input type="text" name="sales_name" class="form-control" style="font-size: 14px; width: 100%" value="<?= $plan['SALES_NAME'] ?>" readonly>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <?php foreach ($plan_activities as $i => $activity): ?>
                            <input type="hidden" name="activity_no[]" value="<?= $activity['ACTIVITY_NO'] ?>">
                            <input type="hidden" name="cust[]" value="<?= $activity['CUST'] ?>">
                            
                            <h3 style="margin-top: 20px; padding: 20px; background: #00cdb0; color: #fff; border: 1px solid #ddd; margin-bottom: 0px !important;" class="sub-title">
                                <strong><?= $activity['CUST'] ?></strong>&nbsp;-&nbsp;<?= $activity['CUST_NAME'] ?>
                            </h3>

                            <table class="table table-bordered" style="margin-bottom: 0px">
                                <thead>
                                    <tr>
                                        <th width="33.333%">COORDINATE</th>
                                        <th width="33.333%">PLAN</th>
                                        <th width="33.333%">ACTUAL</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td data-label="COORDINATE" style="padding-top: 15px !important">
                                            <a href="javascript:void(0)" onclick="getLocation(this)" style="background: #00c0ff; border-radius: 10px; color: #fff; font-weight: 600; padding: 10px;margin-top: 10px">UPDATE LOCATION</a>
                                            <input type="text" style="font-size: 14px; width: 100%;margin-top: 15px !important" placeholder="KLIK TOMBOL DIBAWAH UNTUK DAPAT KOORDINATE" name="coordinate[]" class="form-control" value="<?= $activity['COORDINATE'] ?>" readonly>
                                            <textarea name="address[]" class="form-control" rows="5" readonly style="margin-top:10px" id="address-info"><?= $activity['ADDRESS_ACTUAL'] ?></textarea>
                                        </td>
                                        <td data-label="PLAN">
                                            <textarea name="target_plan[]" placeholder="CTH : TULIS PLAN DISINI.." rows="5" class="form-control" readonly><?= $activity['TARGET_PLAN'] ?></textarea>
                                        </td>
                                        <td data-label="ACTUAL">
                                            <textarea name="remark[]" placeholder="CTH : TULIS REMARK DISINI.." rows="5" class="form-control"><?= $activity['REMARK'] ?></textarea>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                            <table class="table table-bordered" style="margin-bottom: 20px">
                                <thead>
                                    <tr>
                                        <th width="50%">PHONE NUMBER</th>
                                        <th width="50%">UPLOAD IMAGES</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td data-label="PHONE NUMBER">
                                            <input type="text" style="margin-top: 10px !important" name="phone[]" class="form-control" value="<?= $activity['PHONE'] ?>" readonly>
                                        </td>
                                        <td data-label="UPLOAD IMAGES">
                                            <?php if (!empty($activity['IMAGES'])): ?>
                                               <?php foreach ($activity['IMAGES'] as $img): ?>
                                                    <div style="display:inline-block; margin:5px;">
                                                        <img src="<?= base_url('uploads/plan/' . $img['IMAGE_PATH']) ?>" width="100" alt="Image">
                                                        <br>
                                                        <a style="color: red; font-weight: bold" href="<?= base_url('dashboard/sales/activity/delete_image/' . $img['ID']) ?>" onclick="return confirm('Yakin ingin hapus gambar ini?')">HAPUS GAMBAR</a>
                                                    </div>
                                                <?php endforeach; ?>
                                            <?php endif; ?>

                                            <input type="file" name="image[<?= $i ?>][]" class="form-control" accept="image/*" multiple>
                                            <small class="text-muted" style="font-weight: bold">BISA UPLOAD LEBIH DARI 1 GAMBAR</small>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        <?php endforeach; ?>


                        <?php foreach ($other_activities_fix as $i => $activity_cust): ?>
                            <!-- Hidden untuk identifikasi record unik -->
                            <input type="hidden" name="activity_no[]" value="<?= $activity_cust['ACTIVITY_NO'] ?>">
                            <input type="hidden" name="id[]" value="<?= $activity_cust['ID'] ?>">
                            
                            <h3 style="margin-top: 20px; padding: 20px; background: #00cdb0; color: #fff; border: 1px solid #ddd; margin-bottom: 0px !important;" class="sub-title"><?= $activity_cust['CUSTOMER'] ?></h3>

                            <table class="table table-bordered" style="margin-bottom: 0px">
                                <thead>
                                    <tr>
                                        <th width="33.333%">COORDINATE</th>
                                        <th width="33.333%">PLAN</th>
                                        <th width="33.333%">ACTUAL</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td data-label="COORDINATE" style="padding-top: 15px !important">
                                            <a href="javascript:void(0)" onclick="getLoca(this)" style="background: #00c0ff; border-radius: 10px; color: #fff; font-weight: 600; padding: 10px;margin-top: 10px">UPDATE LOCATION</a>
                                            <input type="text" style="font-size: 14px; width: 100%;margin-top: 15px !important" placeholder="KLIK TOMBOL DIBAWAH UNTUK DAPAT KOORDINATE" name="coordinatecust[]" class="form-control" value="<?= $activity_cust['COORDINATE'] ?>" readonly>
                                            <textarea name="addresscust[]" class="form-control" rows="5" readonly style="margin-top:10px" id="address-info"><?= $activity_cust['ADDRESS'] ?></textarea>
                                        </td>
                                        <td data-label="PLAN">
                                            <textarea name="target_plan_cust[]" placeholder="CTH : TULIS REMARK DISINI.." rows="5" class="form-control" readonly><?= $activity_cust['TARGET_PLAN'] ?></textarea>
                                        </td>
                                        <td data-label="ACTUAL">
                                            <textarea name="remark_cust[]" placeholder="CTH : TULIS REMARK DISINI.." rows="5" class="form-control"><?= $activity_cust['REMARK'] ?></textarea>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                            <table class="table table-bordered" style="margin-bottom: 20px">
                                <thead>
                                    <tr>
                                        <th width="50%">PHONE NUMBER</th>
                                        <th width="50%">UPLOAD IMAGE</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td data-label="PHONE NUMBER">
                                            <input type="number" style="margin-top: 10px !important" placeholder="CTH : 08XXXXXXX" name="phone_cust[]" class="form-control" value="<?= $activity_cust['PHONE'] ?>">
                                        </td>
                                        <td data-label="UPLOAD IMAGES">
                                            <?php
                                            $other_images = $this->db->get_where('TB_PLAN_ACTIVITY_OTHER_IMAGES', ['ID_DATA' => $activity_cust['ID']])->result_array();
                                            if (!empty($other_images)):
                                                foreach ($other_images as $img):
                                            ?>
                                                <div style="display:inline-block; margin:5px;">
                                                    <img src="<?= base_url('uploads/other/' . $img['IMAGE_PATH']) ?>" width="100" alt="Image">
                                                    <br>
                                                    <a style="color: red; font-weight: bold" href="<?= base_url('dashboard/sales/activity/delete_other_image/' . $img['ID']) ?>" onclick="return confirm('Yakin ingin hapus gambar ini?')">HAPUS GAMBAR</a>
                                                </div>
                                            <?php
                                                endforeach;
                                            endif;
                                            ?>

                                            <input type="file" name="image_cust[<?= $i ?>][]" multiple class="form-control" accept="image/*">
                                            <small class="text-muted" style="font-weight: bold">BISA UPLOAD LEBIH DARI 1 GAMBAR</small>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        <?php endforeach; ?>

                        <h3 class="sub-title" style="margin-top: 20px; padding: 20px; background:rgb(0, 190, 238); color: #fff; border: 1px solid #ddd; margin-bottom: 0px !important;">CUSTOMER CJ</h3>
                        <table class="table table-bordered" style="margin-bottom: 20px">
                            <thead>
                                <tr>
                                    <th colspan="6" style="text-align: right; background: #fff; border: 0px"><button type="button" class="btn cust-btn-add" onclick="addCustomers()">+</button></th>
                                </tr>
                                <tr>
                                    <th>CUSTOMER</th>
                                    <th>PHONE & ADDRESS</th>
                                    <th>LOCATION</th>
                                    <th>REMARK</th>
                                    <th>UPLOAD</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody id="customersinfo">
                                <tr style="align-items: flex-end">
                                    <th class="th-mobile" style="text-align: left; background: #fff; border: 0px;"><button type="button" class="btn cust-btn-add" onclick="addCustomers()">+</button></th>
                                </tr>
                                <tr>
                                    <td data-label="CUSTOMER">
                                        <select id="customer" class="form-control customer-select" style="width: 100%;" name="custnew[]" required>
                                            <option value="" selected>- PILIH CUSTOMER -</option>
                                            <?php foreach ($customer as $item): ?>
                                                <option value="<?= $item['CUST'] ?>"><?= $item['CUST'] ?> - <?= $item['FULL_NAME'] ?></option>
                                            <?php endforeach ?>
                                        </select>
                                    </td>
                                    <td data-label="PHONE & ADDRESS">
                                        <input type="hidden" name="cust_name_new[]" class="form-control name-field">
                                        <input type="text" name="phone_new[]" placeholder="PHONE NUMBER" class="form-control phone-field" style="font-size: 14px;" readonly>
                                        <textarea name="address_new[]" placeholder="ADDRESS" class="address-field" style="width: 100%;padding: 10px; border-radius: 5px !important; background-color: #eee; border-color: #d2d6de; text-transform: uppercase; color: #555; margin-top: 10px" rows="3" readonly></textarea>
                                    </td>
                                    <td data-label="LOCATION" style="padding-top: 15px !important">
                                            <a href="javascript:void(0)" onclick="getLocat(this)" style="background: #00c0ff; border-radius: 10px; color: #fff; font-weight: 600; padding: 10px;margin-top: 10px">UPDATE LOCATION</a>
                                            <input type="text" name="coordinateloca[]" class="form-control" readonly  style="font-size: 14px; width: 100%; margin-top: 15px !important" />
                                            <textarea name="addressloca[]" class="form-control" rows="5" readonly style="margin-top:10px"></textarea>
                                        </td>
                                    <td data-label="REMARK">
                                        <textarea required name="remark_new[]" placeholder="CTH : MENAWARKAN PENJUALAN AYAM...." style="width: 100%;padding: 10px; border-radius: 5px !important; border-color: #d2d6de; text-transform: uppercase;" id="" rows="3" required></textarea>
                                    </td>
                                    <td data-label="UPLOAD">
                                         <input type="file" name="image_customers[]" class="form-control file-input" accept="image/*" hidden/>
                                        <!-- our custom upload button -->
                                        <label for="actual-btn" class="actual-btn">CHOOSE FILE</label>
                                            <br>
                                        <!-- name of file chosen -->
                                        <span class="file-chosen">NO FILE CHOOSEN</span>
                                    </td>
                                    <td><a onclick="deleteRow(this)" href="javascript:void(0)" class="btn btn-sm" title="Hapus"><i class="fas fa-trash text-danger" style="width: 18px"></i></a></td>
                                </tr>
                            </tbody>
                        </table>

                        <h3 class="sub-title" style="margin-top: 20px; padding: 20px; background:rgb(0, 190, 238); color: #fff; border: 1px solid #ddd; margin-bottom: 0px !important;">NEW CUSTOMER</h3>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th colspan="6" style="text-align: right; background: #fff; border: 0px"><button type="button" class="btn cust-btn-add" onclick="addFarmers()">+</button></th>
                                </tr>
                                <tr>
                                    <th>CUSTOMER</th>
                                    <th>PHONE NUMBER</th>
                                    <th>ALAMAT</th>
                                    <th>ACTUAL</th>
                                    <th>UPLOAD</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody id="farmersinfo">
                                <tr style="align-items: flex-end">
                                    <th class="th-mobile" style="text-align: left; background: #fff; border: 0px;"><button type="button" class="btn cust-btn-add" onclick="addFarmers()">+</button></th>
                                </tr>
                                <?php if (!empty($other_activities)): ?>
                                    <?php foreach ($other_activities as $i => $other): ?>
                                    <tr>
                                        <td data-label="CUSTOMER">
                                            <input type="hidden" name="other_id[]" value="<?= $other['ID'] ?>">
                                            <input type="text" name="other_customer[]" class="form-control" value="<?= $other['CUSTOMER'] ?>" placeholder="CTH: PT. SUPER UNGGAS JAYA" />
                                        </td>
                                        <td data-label="PHONE NUMBER">
                                            <input type="text" name="other_phone[]" class="form-control" value="<?= $other['PHONE'] ?>" placeholder="CTH: 08XXXXXXXXX" />
                                        </td>
                                        <td data-label="ALAMAT" style="padding-top: 15px !important">
                                            <a href="javascript:void(0)" onclick="getLoc(this)" style="background: #00c0ff; border-radius: 10px; color: #fff; font-weight: 600; padding: 10px;margin-top: 10px">UPDATE LOCATION</a>
                                            <input type="text" name="other_coordinate[]" class="form-control" readonly  style="font-size: 14px; width: 100%;margin-top:15px !important" value="<?= $other['COORDINATE'] ?>" />
                                            <textarea name="other_address[]" class="form-control" rows="5" readonly style="margin-top:10px !important"><?= $other['ADDRESS'] ?></textarea>
                                        </td>
                                        <td data-label="ACTUAL">
                                            <textarea name="other_remark[]" class="form-control" placeholder="CTH: Menawarkan penjualan ayam..." style="width: 100%;padding: 10px; border-radius: 5px !important; border-color: #d2d6de; text-transform: uppercase; font-size: 12px" id="" rows="5"><?= $other['REMARK'] ?></textarea>
                                        </td>
                                        <td data-label="UPLOAD">
                                            <?php if (!empty($other['IMAGE_PATH'])): ?>
                                                <div style="margin-bottom: 10px;">
                                                    <img src="<?= base_url('uploads/other/' . $other['IMAGE_PATH']) ?>" alt="Existing Image" style="max-width: 150px; border: 1px solid #ccc; padding: 5px;">
                                                    <br>
                                                    <small><?= $other['IMAGE_PATH'] ?></small>
                                                </div>
                                            <?php endif; ?>
                                            <input type="file" name="other_image[]" class="form-control file-input" accept="image/*" hidden />
                                            <label class="actual-btn">CHOOSE FILE</label><br>
                                            <span class="file-chosen"><?= $other['IMAGE_PATH'] ?: 'NO FILE CHOSEN' ?></span>
                                        </td>
                                        <td>
                                            <a href="javascript:void(0)" onclick="deleteRow(this)" class="btn btn-sm"><i class="fas fa-trash text-danger"></i></a>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td data-label="CUSTOMER">
                                                <input type="hidden" name="other_id[]" value="">
                                                <input type="text" name="other_customer[]" class="form-control" placeholder="CTH: PT. SUPER UNGGAS JAYA" />
                                            </td>
                                            <td data-label="PHONE NUMBER">
                                                <input type="text" name="other_phone[]" class="form-control" placeholder="CTH: 08XXXXXXXXX" />
                                            </td>
                                            <td data-label="ALAMAT" style="padding-top: 15px !important">
                                                <a href="javascript:void(0)" onclick="getLoc(this)" style="background: #00c0ff; border-radius: 10px; color: #fff; font-weight: 600; padding: 10px;margin-top: 15px;">UPDATE LOCATION</a>
                                                <input type="text" name="other_coordinate[]" class="form-control" readonly  style="font-size: 14px; width: 100%; margin-top:10px !important" />
                                                <textarea name="other_address[]" class="form-control" rows="5" readonly style="margin-top:10px !important" id="address-info"></textarea>
                                            </td>
                                            <td data-label="REMARK">
                                                <textarea name="other_remark[]" class="form-control" placeholder="CTH: Menawarkan penjualan ayam..." style="width: 100%;padding: 10px; border-radius: 5px !important; border-color: #d2d6de; text-transform: uppercase; font-size: 12px" id="" rows="5"></textarea>
                                            </td>
                                            <td data-label="UPLOAD">
                                                <input type="file" name="other_image[]" class="form-control file-input" accept="image/*" hidden/>
                                                <!-- our custom upload button -->
                                                <label for="actual-btn" class="actual-btn">CHOOSE FILE</label>
                                                    <br>
                                                <!-- name of file chosen -->
                                                <span class="file-chosen">NO FILE CHOOSEN</span>
                                            </td>
                                            <td>
                                                <a href="javascript:void(0)" onclick="deleteRow(this)" class="btn btn-sm"><i class="fas fa-trash text-danger"></i></a>
                                            </td>
                                        </tr>
                                <?php endif; ?>
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
    $(document).on('click', '.actual-btn', function () {
        $(this).closest('td').find('.file-input').trigger('click');
    });

    $(document).on('change', '.file-input', function () {
        const fileName = this.files.length > 0 ? this.files[0].name : 'NO FILE CHOSEN';
        $(this).closest('td').find('.file-chosen').text(fileName);
    });

    const lang = document.getElementById("coordinateText");
    let segmenIndex = 0;

    function getLocation(button) {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                const latitude = position.coords.latitude;
                const longitude = position.coords.longitude;
                const coordinate = latitude + ", " + longitude;

                // Ambil parent row dari tombol yang diklik
                const row = button.closest('tr');

                // Set nilai koordinat
                const coordinateInput = row.querySelector('input[name="coordinate[]"]');
                if (coordinateInput) coordinateInput.value = coordinate;

                // Set nilai address (hasil reverse geocode)
                detailPosition(latitude, longitude, function(address) {
                    const addressTextarea = row.querySelector('textarea[name="address[]"]');
                    if (addressTextarea) addressTextarea.value = address;
                });

            }, function(error) {
                alert("Gagal mendapatkan lokasi: " + error.message);
            });
        } else {
            alert("Geolocation tidak didukung browser ini.");
        }
    }
    function getLoc(button) {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                const latitude = position.coords.latitude;
                const longitude = position.coords.longitude;
                const coordinate = latitude + ", " + longitude;

                // Ambil parent row dari tombol yang diklik
                const row = button.closest('tr');

                // Set nilai koordinat
                const coordinateInput = row.querySelector('input[name="other_coordinate[]"]');
                if (coordinateInput) coordinateInput.value = coordinate;

                // Set nilai address (hasil reverse geocode)
                detailPosition(latitude, longitude, function(address) {
                    const addressTextarea = row.querySelector('textarea[name="other_address[]"]');
                    if (addressTextarea) addressTextarea.value = address;
                });

            }, function(error) {
                alert("Gagal mendapatkan lokasi: " + error.message);
            });
        } else {
            alert("Geolocation tidak didukung browser ini.");
        }
    }

    function getLoca(button) {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                const latitude = position.coords.latitude;
                const longitude = position.coords.longitude;
                const coordinate = latitude + ", " + longitude;

                // Ambil parent row dari tombol yang diklik
                const row = button.closest('tr');

                // Set nilai koordinat
                const coordinateInput = row.querySelector('input[name="coordinatecust[]"]');
                if (coordinateInput) coordinateInput.value = coordinate;

                // Set nilai address (hasil reverse geocode)
                detailPosition(latitude, longitude, function(address) {
                    const addressTextarea = row.querySelector('textarea[name="addresscust[]"]');
                    if (addressTextarea) addressTextarea.value = address;
                });

            }, function(error) {
                alert("Gagal mendapatkan lokasi: " + error.message);
            });
        } else {
            alert("Geolocation tidak didukung browser ini.");
        }
    }
    function getLocat(button) {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                const latitude = position.coords.latitude;
                const longitude = position.coords.longitude;
                const coordinate = latitude + ", " + longitude;

                // Ambil parent row dari tombol yang diklik
                const row = button.closest('tr');

                // Set nilai koordinat
                const coordinateInput = row.querySelector('input[name="coordinateloca[]"]');
                if (coordinateInput) coordinateInput.value = coordinate;

                // Set nilai address (hasil reverse geocode)
                detailPosition(latitude, longitude, function(address) {
                    const addressTextarea = row.querySelector('textarea[name="addressloca[]"]');
                    if (addressTextarea) addressTextarea.value = address;
                });

            }, function(error) {
                alert("Gagal mendapatkan lokasi: " + error.message);
            });
        } else {
            alert("Geolocation tidak didukung browser ini.");
        }
    }

    $(document).ready(function() {
        getLocation();
        getLoc();
        getLoca();
        getLocat();
    });
        
    function showPosition(position) {
        let latitude    = position.coords.latitude;
        let longitude   = position.coords.longitude;
            
        $("#coordinate").val(coordinate);
        
        detailPosition(latitude, longitude)
    }

    function detailPosition(latitude, longitude, callback) {
        const addressAPI = `https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${latitude}&lon=${longitude}`;
        $.ajax({
            url: addressAPI,
            type: "GET",
            success: function(response) {
                const address = response.display_name;
                if (typeof callback === 'function') {
                    callback(address);
                }
            },
            error: function() {
                alert("Gagal mengambil alamat dari koordinat.");
            }
        });
    }

    const customerData = <?= json_encode($customer) ?>;

    // Generate select options dari PHP (satu kali saja)
    const customerOptionsHtml = `
        <option value="" selected>- PILIH CUSTOMER -</option>
        <?php foreach($customer as $item): ?>
            <option value="<?= $item['CUST'] ?>"><?= $item['CUST'] ?> - <?= $item['FULL_NAME'] ?></option>
        <?php endforeach ?>
    `;

    $('#customer').select2({
        theme: 'bootstrap4',
        language: "en",
        placeholder: "- SELECT CUSTOMER -",
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
                <select class="form-control customer-select" style="width: 100%;" name="custnew[]" required>
                    ${customerOptionsHtml}
                </select>
            </td>
            <td data-label="PHONE & ADDRESS">
                <input type="hidden" name="cust_name_new[]" class="form-control name-field">
                <input type="text" name="phone_new[]" placeholder="PHONE NUMBER" class="form-control phone-field" style="font-size: 14px;" readonly>
                <textarea name="address_new[]" placeholder="ADDRESS" class="address-field" style="width: 100%;padding: 10px; border-radius: 5px !important; background-color: #eee; border-color: #d2d6de; text-transform: uppercase; color: #555; margin-top: 10px" rows="3" readonly></textarea>
            </td>
            <td data-label="LOCATION" style="padding-top: 15px !important">
                    <a href="javascript:void(0)" onclick="getLocat(this)" style="background: #00c0ff; border-radius: 10px; color: #fff; font-weight: 600; padding: 10px;margin-top: 10px">UPDATE LOCATION</a>
                    <input type="text" name="coordinateloca[]" class="form-control" readonly  style="font-size: 14px; width: 100%; margin-top:10px !important" />
                    <textarea name="addressloca[]" class="form-control" rows="5" readonly style="margin-top:10px !important"></textarea>
                </td>
            <td data-label="REMARK">
                <textarea required name="remark_new[]" placeholder="CTH : MENAWARKAN PENJUALAN AYAM...." style="width: 100%;padding: 10px; border-radius: 5px !important; border-color: #d2d6de; text-transform: uppercase;" id="" rows="3" required></textarea>
            </td>
            <td data-label="UPLOAD">
                <input type="file" name="image_customers[]" class="form-control file-input" accept="image/*" hidden/>
                <!-- our custom upload button -->
                <label for="actual-btn" class="actual-btn">CHOOSE FILE</label>
                    <br>
                <!-- name of file chosen -->
                <span class="file-chosen">NO FILE CHOOSEN</span>
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

    function addFarmers() {
        let tabledata = `
        <tr>
            <td data-label="CUSTOMER">
                <input type="hidden" name="other_id[]" value="">
                <input type="text" name="other_customer[]" class="form-control" placeholder="CTH: PT. SUPER UNGGAS JAYA" />
            </td>
            <td data-label="PHONE NUMBER">
                <input type="text" name="other_phone[]" class="form-control" placeholder="CTH: 08XXXXXXXXX" />
            </td>
            <td data-label="ALAMAT" style="padding-top: 15px !important">
                <a href="javascript:void(0)" onclick="getLoc(this)" style="background: #00c0ff; border-radius: 10px; color: #fff; font-weight: 600; padding: 10px;margin-top: 15px;">UPDATE LOCATION</a>
                <input type="text" name="other_coordinate[]" class="form-control" readonly  style="font-size: 14px; width: 100%; margin-top:10px !important" />
                <textarea name="other_address[]" class="form-control" rows="5" readonly style="margin-top:10px !important" id="address-info"></textarea>
            </td>
            <td data-label="REMARK">
                <textarea name="other_remark[]" class="form-control" placeholder="CTH: Menawarkan penjualan ayam..." style="width: 100%;padding: 10px; border-radius: 5px !important; border-color: #d2d6de; text-transform: uppercase; font-size: 12px" id="" rows="5"></textarea>
            </td>
            <td data-label="UPLOAD">
                <input type="file" name="other_image[]" class="form-control file-input" accept="image/*" hidden/>
                <!-- our custom upload button -->
                <label for="actual-btn" class="actual-btn">CHOOSE FILE</label>
                    <br>
                <!-- name of file chosen -->
                <span class="file-chosen">NO FILE CHOOSEN</span>
            </td>
            <td>
                <a href="javascript:void(0)" onclick="deleteRow(this)" class="btn btn-sm"><i class="fas fa-trash text-danger"></i></a>
            </td>
        </tr>
        `;

        $("#farmersinfo").append(tabledata);
    }

    function deletedRow(e) {
        Swal.fire({
            icon: "warning",
            title: "DELETE ROW",
            showCancelButton: true,
            text: "ARE YOU SURE WANT TO DELETE THIS DATA ?"
        }).then((result) => {
            if (result.value) {
                const row = $(e).closest('tr');
                
                // Cek apakah baris ini punya ID dari database
                const hiddenInput = row.find('input[name="other_id[]"]');
                if (hiddenInput.length > 0 && hiddenInput.val() !== '') {
                    // Buatkan input untuk menandai ID yang perlu dihapus
                    const deletedInput = `<input type="hidden" name="deleted_other_id[]" value="${hiddenInput.val()}">`;
                    $("form").append(deletedInput);
                }

                row.remove();
            }
        });
    }

    function deleteRow(e) {
        Swal.fire({
            icon: "warning",
            title: "DELETE ROW",
            showCancelButton: true,
            text: "ARE YOU SURE WANT TO DELETE THIS DATA ?"
        }).then((result) => {
            if (result.value) {
                const row = $(e).closest('tr');
                
                // Cek apakah baris ini punya ID dari database
                const hiddenInput = row.find('input[name="other_id[]"]');
                if (hiddenInput.length > 0 && hiddenInput.val() !== '') {
                    // Buatkan input untuk menandai ID yang perlu dihapus
                    const deletedInput = `<input type="hidden" name="deleted_other_id[]" value="${hiddenInput.val()}">`;
                    $("form").append(deletedInput);
                }

                row.remove();
            }
        });
    }
    $(document).ready(function() {
        $('.cust-btn-save').on('click', function() {
        $(this).prop('disabled', true);
        $(this).text('Saving...'); // opsional, ganti teks
        $(this).closest('form').submit(); // pastikan form tetap disubmit
        });
    });
    document.querySelectorAll('.file-input').forEach(function(input){
        input.addEventListener('change', function(){
            const chosenText = input.closest('td').querySelector('.file-chosen');
            chosenText.textContent = input.files.length > 0 ? input.files[0].name : 'NO FILE CHOSEN';
        });
    });
</script>

<script>

</script>