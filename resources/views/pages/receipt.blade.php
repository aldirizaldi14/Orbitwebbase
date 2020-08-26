@section('pageTitle', 'Receipt')

@extends("layouts/app")

@section('content')
<div class="m-grid__item m-grid__item--fluid m-wrapper">
    <div class="m-content">
        <div class="row">
            <div class="col-12">
                <div class="m-portlet">
                    <div class="m-portlet__head">
                        <div class="m-portlet__head-caption">
                            <div class="m-portlet__head-title">
                                <h3 class="m-portlet__head-text">@yield('pageTitle')</h3>
                            </div>
                        </div>
                        <div class="m-portlet__head-tools">
                            <div class="row">
                                <div class="col-md-6 col-md-1"></div>
                                <div class="col-md-6 col-sm-11">
                                    <input type="text" class="form-control pull-left" id="txtSearch" placeholder="Search" style="width: 200px; height: 40px; margin-right: 10px;">
                                    <button type="button" class="btn btn-accent pull-left m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air" id="btnDownload" hidden="">
                                        <i class="m-nav__link-icon fa fa-download"></i>
                                    </button>
                                    <button type="button" class="btn btn-accent pull-left m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air" id="btnAdd" hidden="">
                                        <i class="m-nav__link-icon fa fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="m-portlet__body">
                        <div class="table-responsive">
                            <table id="tableData" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Time</th>
                                        <th>Code</th>
                                        <th>Receiver</th>
                                        <th>&nbsp;</th>
                                    </tr>
                                </thead>
                            </table>
                            <tbody></tbody>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="modalForm" class="modal" role="dialog" aria-hidden="true">
<div class="modal-dialog" role="document">
<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title">@yield('pageTitle') Form</h5>
        <a href="#"><i class="m-nav__link-icon fa fa-close" data-dismiss="modal" aria-label="Close"></i></a>
    </div>
    <form class="form-horizontal" id="formData">
        <div class="modal-body">
            <div class="form-group">
                <div class="row">
                    <label class="col-md-4 control-label">Time *</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" name="receipt_time" readonly="">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <label class="col-md-4 control-label">Code *</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" name="receipt_code" readonly="">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <label class="col-md-4 control-label">Receiver *</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" name="receipt_user_id" readonly="">
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table id="tableDetail" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Product Code</th>
                            <th>Product</th>
                            <th>Quantity</th>
                        </tr>
                    </thead>
                </table>
                <tbody></tbody>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
    </form>
</div>
</div>
</div>
<!-- End modal form -->

@endsection

@section('footer')
<script type="text/javascript">
$(document).ready(function() {
    $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    var receipt_id = '';

    $("#btnAdd").click(function(){
        receipt_id='';
        $("input[name=receipt_code").val('');
        $("input[name=receipt_time").val('');
        $("input[name=receipt_user_id").val('');
        $('#modalForm').modal('show');
    });

    var tableColumn = [
        { data: "receipt_id", width : 50, sortable: false},
        { data: "receipt_time" },
        { data: "receipt_code" },
        { data: "user_fullname" },
        { data: "receipt_id", width: 100, sortable: false}
    ];
    var orderSort = '';
    var orderDir = '';
    var table = $("#tableData").DataTable({
        filter : false,
        sortable: true,
        info: true,
        paging: true,
        processing: true,
        serverSide: true,
        ordering : true,
        order: [[ 1, "desc" ]],
        ajax: function(data, callback, settings) {
            orderSort = tableColumn[data.order[0].column].data;
            orderDir = data.order[0].dir;
            $.getJSON('{{ url('receipt/data') }}', {
                draw: data.draw,
                length: data.length,
                start: data.start,
                filter: $("#txtSearch").val(),
                sort:tableColumn[data.order[0].column].data,
                dir:data.order[0].dir
            }, function(res) {
                callback({
                    recordsTotal: res.recordsTotal,
                    recordsFiltered: res.recordsFiltered,
                    data: res.listData
                });
            });
        },
        columns: tableColumn,
        columnDefs: [
            {
                render: function(data,type,row,index){
                    var info = table.page.info();
                    return index.row+info.start+1;
                },
                targets : [0]
            },
            {
                render: function(data,type,row,index){
                    content = '<button type="button" class="btn btn-edit btn-accent m-btn--pill btn-sm m-btn m-btn--custom" data-index="'+ index.row +'"><i class="m-nav__link-icon fa fa-file"></i></button>';
                    content += '<button type="button" class="btn btn-delete btn-accent m-btn--pill btn-sm m-btn m-btn--custom" data-index="'+ index.row +'"><i class="m-nav__link-icon fa fa-trash"></i></button>';
                    return content;
                },
                targets : [4]
            },
        ],
        drawCallback: function(e,response){
            $(".btn-edit").click(function(event){
                var index = $(this).data('index');
                var data = table.row(index).data();

                receipt_id = data.receipt_id;
                $("input[name=receipt_code]").val(data.receipt_code);
                $("input[name=receipt_time]").val(data.receipt_time);
                $("input[name=receipt_user_id]").val(data.user_fullname);
                tableDetail.ajax.reload();
                $('#modalForm').modal('show');
            });
            $(".btn-delete").click(function(event){
                var index = $(this).data('index');
                var data = table.row(index).data();

                swal.fire({
                    title: "Delete "+ data.receipt_code +" ?",
                    type: "question",
                    showCancelButton : true,
                    focusCancel : true,
                    dangerMode: true,
                    closeOnClickOutside : false
                })
                .then((confirm) => {
                    if (confirm.value) {
                        $.ajax({
                            url: '{{ url('receipt') }}/delete/' + data.receipt_id,
                            method: "post",
                            dataType : 'json'
                        })
                        .done(function(resp) {
                            console.log(resp);
                            if (resp.success) {
                                swal.fire("Info", resp.message, "success");
                                table.ajax.reload();
                            }else{
                                swal.fire("Warning", resp.message, "warning");
                            }
                        })
                        .fail(function() {
                            swal.fire("Warning", 'Unable to process request at this moment', "warning");
                        });
                    } else {
                        event.preventDefault();
                        return false;
                    }
                });
            });
        }
    });

    var tableColumnDetail = [
        { data: "receiptdet_id", width : 50, sortable: false},
        { data: "product_code" },
        { data: "product_description" },
        { data: "receiptdet_qty" },
    ];
    var tableDetail = $("#tableDetail").DataTable({
        filter : false,
        sortable: false,
        info: true,
        paging: false,
        processing: true,
        serverSide: true,
        ordering : false,
        order: [[ 1, "asc" ]],
        ajax: function(data, callback, settings) {
            $.getJSON('{{ url('receipt/detail') }}', {
                draw: data.draw,
                receipt_id: receipt_id,
            }, function(res) {
                callback({
                    recordsTotal: res.recordsTotal,
                    recordsFiltered: res.recordsFiltered,
                    data: res.listData
                });
            });
        },
        columns: tableColumnDetail,
        columnDefs: [
            {
                render: function(data,type,row,index){
                    var info = table.page.info();
                    return index.row+info.start+1;
                },
                targets : [0]
            },
        ]
    });

    $("#receipt_warehouse_id").select2({
        theme:'bootstrap',
        ajax: {
            url: '{{ url('warehouse/data') }}',
            dataType: 'json',
            type: "GET",
            delay: 250,
            data: function (params) {
                return {
                    filter: params.term
                };
            },
            processResults: function(data, page) {
                var result_data = data.listData;
                if(data.recordsTotal >= 1){
                    return {
                        results: $.map(result_data, function (item) {
                            return {
                                text: item.warehouse_name,
                                id: item.warehouse_id
                            }
                        })
                    };
                }else{
                    return { results : null };
                }
            }
        }
    });

    $("#formData").submit(function (e)
    {
        e.preventDefault();
        var btn = $("#btnSave");
        btn.text('Processing...').attr('disabled', true);

        var postData = new FormData($('#formData')[0]);

        $.ajax({
            url: '{{ url('receipt') }}' + (receipt_id ? '/' + receipt_id : ''),
            method: "POST",
            data: postData,
            processData: false,
            cache: false,
            contentType: false,
            dataType : 'json'
        })
        .done(function(resp) {
            if (resp.success) {
                $("#modalForm").modal("hide");
                swal.fire("Info", resp.message, "success");
                table.ajax.reload();
            }else{
                swal.fire("Warning", resp.message, "warning");
            }
        })
        .fail(function() {
            swal.fire("Warning", 'Unable to process request at this moment', "warning");
        })
        .always(function() {
            btn.text('Simpan');
            btn.attr('disabled', false);
        });
    });

    $("#txtSearch").typeWatch({
        callback: function (value) { table.ajax.reload(); },
        wait: 750,
        highlight: true,
        allowSubmit: false,
        captureLength: 2
    });

    $("#btnDownload").click(function(){
        var filter = $("#txtSearch").val();
        $.ajax({
            url: '{{ url('receipt') }}/export',
            method: "POST",
            dataType : 'json',
            data : {
                filter : filter,
                sort : orderSort,
                dir : orderDir
            }
        })
        .done(function(resp) {
            if (resp.success) {
                window.open(resp.file);
            }else{
                swal.fire("Warning", resp.message, "warning");
            }
        })
        .fail(function() {
            swal.fire("Warning", 'Unable to process request at this moment', "warning");
        });
    });
});
</script>
@endsection
