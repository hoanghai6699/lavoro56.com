@extends('admin.master')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <h1>Sửa khuyến mãi</h1>
        <ol class="breadcrumb">
            <li><a href="{{route('admin')}}"><i class="fa fa-dashboard"></i> Trang tổng quan</a></li>
            <li><a href="{{route('admin.get.list.sale')}}">Danh sách khuyến mãi</a></li>
            <li class="active">Sửa khuyến mãi</li>
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
                                        <?php $name = DB::table('products')->where('id',$sale->product_id)->first(); ?>
                                        <select class="form-control" name="name_product">
                                            
                                            <option value="">{{$name->name}}</option>
                                            
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
                                                    <input type="date" class="form-control pull-right" name="startdate" value="{{old('startdate',$sale->start_date)}}">
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
                                                    <input type="date" class="form-control pull-right" name="enddate" value="{{old('enddate',$sale->end_date)}}">
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
                                        <input type="number" class="form-control" name="sale" placeholder="% Giảm giá" value="{{old('sale',$sale->sale)}}">
                                        @if($errors->has('sale'))
                                        <div class="help-block" style="color: red;">
                                        {{$errors->first('sale')}}
                                        </div>
                                        @endif
                                    </div>
                                <button type="submit" class="btn btn-primary">Lưu</button>
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
