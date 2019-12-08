@extends('admin.master')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <h1>Thống kê doanh thu</h1>
        <ol class="breadcrumb">
            <li><a href="{{route('admin')}}"><i class="fa fa-dashboard"></i> Trang tổng quan</a></li>
            <li class="active">Thống kê</li>
        </ol>
    </section>
    <section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-body">
                    <div class="col-md-4">Tổng số đơn hàng - <b><span id="total_records"></span></b></div>
                    <div class="col-md-5">
                        <div class="input-group input-daterange">
                            <input type="text" name="from_date" id="from_date" readonly class="form-control" />
                            <div class="input-group-addon">to</div>
                            <input type="text"  name="to_date" id="to_date" readonly class="form-control" />
                        </div>
                    </div>
                    <div class="col-md-3">
                        <button type="button" name="filter" id="filter" class="btn btn-info btn-sm fa fa-search"> lọc</button>
                        <button type="button" name="refresh" id="refresh" class="btn btn-warning btn-sm fa fa-refresh"> refresh</button>
                        <a class="btn btn-primary fa fa-file-excel-o" href="{{ route('export') }}"> xuất excel</a>
                    </div>
                    
                    <table id="example2" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th style="text-align: center;width: 20%;">Mã ĐH</th>
                                <th style="text-align: center;width: 40%;">Khách hàng</th>
                                <th style="text-align: center;width: 20%;">Ngày tạo</th>
                                <th style="text-align: center;width: 20%;">Tổng tiền</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                        </tbody>
                    </table>
                    {{csrf_field()}}
                </div>
                <!-- /.box-body -->
            </div>
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
</section>

</div>
@stop

@section('script')
<script>
$(document).ready(function(){
    var date = new Date();
    $('.input-daterange').datepicker({
        todayBtn: 'linked',
        format: 'dd-mm-yyyy',
        autoclose: true
    });

    var _token = $('input[name="_token"]').val();

    fetch_data();
    function number_format(number, decimals, dec_point, thousands_point) {

        if (number == null || !isFinite(number)) {
            throw new TypeError("number is not valid");
        }

        if (!decimals) {
            var len = number.toString().split('.').length;
            decimals = len > 1 ? len : 0;
        }

        if (!dec_point) {
            dec_point = '.';
        }

        if (!thousands_point) {
            thousands_point = '.';
        }

        number = parseFloat(number).toFixed(decimals);

        number = number.replace(".", dec_point);

        var splitNum = number.split(dec_point);
        splitNum[0] = splitNum[0].replace(/\B(?=(\d{3})+(?!\d))/g, thousands_point);
        number = splitNum.join(dec_point);

        return number;
    }

    function fetch_data(from_date = '', to_date = '')
    {
        $.ajax({
            url:"{{ route('fetch_data') }}",
            method:"POST",
            data:{from_date:from_date, to_date:to_date, _token:_token},
            dataType:"json",
            success:function(data)
            {
            
            var output = '';
            $('#total_records').text(data.length);
            for(var count = 0; count < data.length; count++)
            {
                let ngayThang = new Date(data[count].created_at);
                let hienThi = ngayThang.getDate() + '-' + ("0" + (ngayThang.getMonth() + 1)).slice(-2) + '-' + ngayThang.getFullYear();

                output += '<tr>';
                output += '<td style="text-align: center; width: 20%;">' + '#HD' + data[count].id + '-' + ngayThang.getDate() + ("0" + (ngayThang.getMonth() + 1)).slice(-2)  + ngayThang.getFullYear() + '</td>';
                output += '<td style="text-align: center; width: 40%;">' + data[count].name + '</td>';
                output += '<td style="text-align: center; width: 20%;">' + hienThi + '</td>';
                output += '<td style="text-align: center; width: 20%;">' + number_format(data[count].total) + ' ' + 'đ' + '</td></tr>';
            }
            $('tbody').html(output);
            }
        })
    }

    $('#filter').click(function(){
        var from_date = $('#from_date').val();
        var to_date = $('#to_date').val();
        if(from_date != '' &&  to_date != '')
        {
        fetch_data(from_date, to_date);
        }
        else
        {
            alert('Bạn chưa chọn ngày');
        }
    });

    $('#refresh').click(function(){
        $('#from_date').val('');
        $('#to_date').val('');
        fetch_data();
    });
});
$(function () {
    $('#example2').DataTable({
        'paging'      : false,
        'lengthChange': false,
        'searching'   : false,
        'ordering'    : false,
        'info'        : false,
        'autoWidth'   : false
    })
})
</script>
@stop