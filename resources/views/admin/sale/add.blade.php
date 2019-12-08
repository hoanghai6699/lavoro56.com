@extends('admin.master')
@section('content')
<link rel="stylesheet" href="{{url('/')}}/admin/dist/css/AdminLTE.min.css">
<div class="content-wrapper">
    <section class="content-header">
        <h1>Thêm khuyến mãi</h1>
        <ol class="breadcrumb">
            <li><a href="{{route('admin')}}"><i class="fa fa-dashboard"></i> Trang tổng quan</a></li>
            <li><a href="{{route('admin.get.list.sale')}}">Danh sách khuyến mãi</a></li>
            <li class="active">Thêm khuyến mãi</li>
        </ol>
        @if(Session::has('success'))
            <div class="alert alert-{!! Session::get('level') !!}">
                {!! Session::get('success') !!}
            </div>
        @endif
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    
                    <div class="box-body">
                        <form action="" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="_token" value="{{csrf_token()}}">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Tên sản phẩm</label>
                                        <select class="form-control select2" name="name_product" style="width: 100%;">
                                            @foreach($product as $item)
                                            <option value="{{$item->id}}">{{$item->name}}</option>
                                            @endforeach
                                        </select>
                                        @if($errors->has('name_product'))
                                        <div class="help-block" style="color: red;">
                                        {{$errors->first('name_product')}}
                                        </div>
                                        @endif
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Từ ngày</label>
                                                <div class="input-group date">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-calendar"></i>
                                                    </div>
                                                    <input type="date" class="form-control pull-right" name="startdate">
                                                    @if($errors->has('startdate'))
                                                    <div class="help-block" style="color: red;">
                                                    {{$errors->first('startdate')}}
                                                    </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Đến ngày</label>
                                                <div class="input-group date">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-calendar"></i>
                                                    </div>
                                                    <input type="date" class="form-control pull-right" name="enddate">
                                                    @if($errors->has('enddate'))
                                                    <div class="help-block" style="color: red;">
                                                    {{$errors->first('enddate')}}
                                                    </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                            
                                    <div class="form-group">
                                        <label>% Giảm giá</label>
                                        <input type="number" class="form-control" name="sale" placeholder="% Giảm giá">
                                        @if($errors->has('sale'))
                                        <div class="help-block" style="color: red;">
                                        {{$errors->first('sale')}}
                                        </div>
                                        @endif
                                    </div>
                                <button type="submit" class="btn btn-primary">Thêm khuyến mãi</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@stop

@section('script')


<script>
    $('.select2').select2();
</script>
@stop