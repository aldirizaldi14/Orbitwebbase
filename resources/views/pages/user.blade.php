@section('pageTitle', 'User')

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
                                    <button type="button" class="btn btn-accent pull-left m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air" id="btnAdd">
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
                                        <th>Username</th>
                                        <th>Fullname</th>
                                        <th>Group</th>
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
                    <label class="col-md-4 control-label">Username *</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" name="user_username" required="">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <label class="col-md-4 control-label">Fullname *</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" name="user_fullname" required="">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <label class="col-md-4 control-label">Group *</label>
                    <div class="col-md-8">                        
                        <select class="form-control" id="user_group_id" name="user_group_id" style="width:100% !important;" required>
                            <option value="1">System Admin</option>
                            <option value="2">Production</option>
                            <option value="3">Warehouse</option>
                            <option value="9">Viewer</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <label class="col-md-4 control-label">Password</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" name="user_password">
                    </div>
                </div>
            </div>
            <div class="form-group" style="color: red;">
                <br/>You need to fill all field with * mark
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary" id="btnSave">Save</button>
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
    var user_id = '';

    $("#btnAdd").click(function(){
        user_id='';
        $("input[name=user_username").val('');
        $("input[name=user_fullname").val('');
        $("input[name=user_password").val('');
        $('#modalForm').modal('show');
    });

    var tableColumn = [
        { data: "user_id", width : 50, sortable: false},
        { data: "user_username" },
        { data: "user_fullname" },
        { data: "user_group_id" },
        { data: "user_id", width: 100, sortable: false}
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
        order: [[ 1, "asc" ]],
        ajax: function(data, callback, settings) {
            orderSort = tableColumn[data.order[0].column].data;
            orderDir = data.order[0].dir;
            $.getJSON('{{ url('user/data') }}', {
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
                    switch(data){
                        case '1': return 'System Admin'; break;
                        case '2': return 'Production'; break;
                        case '3': return 'Warehouse'; break;
                        case '9': return 'Viewer'; break;
                    }
                    return '';
                },
                targets : [3]
            },
            {
                render: function(data,type,row,index){
                    content = '<button type="button" class="btn btn-edit btn-accent m-btn--pill btn-sm m-btn m-btn--custom" data-index="'+ index.row +'"><i class="m-nav__link-icon fa fa-pencil"></i></button>';
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
                user_id = data.user_id;
                $("input[name=user_username]").val(data.user_username);
                $("input[name=user_fullname]").val(data.user_fullname);
                $("select[name=user_group_id]").val('1');
                console.log($("select[name=user_group_id]").val());
                $('#modalForm').modal('show');
            });
            $(".btn-delete").click(function(event){
                var index = $(this).data('index');
                var data = table.row(index).data();

                swal.fire({
                    title: "Delete "+ data.user_username +" ?",
                    type: "question",
                    showCancelButton : true,
                    focusCancel : true,
                    dangerMode: true,
                    closeOnClickOutside : false
                })
                .then((confirm) => {
                    if (confirm.value) {
                        $.ajax({
                            url: '{{ url('user') }}/' + data.user_id,
                            method: "DELETE",
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

    $("#formData").submit(function (e)
    {
        e.preventDefault();
        var btn = $("#btnSave");
        btn.text('Processing...').attr('disabled', true);

        var postData = new FormData($('#formData')[0]);

        $.ajax({
            url: '{{ url('user') }}' + (user_id ? '/' + user_id : ''),
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
            url: '{{ url('user') }}/export',
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
