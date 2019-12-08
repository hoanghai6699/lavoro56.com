@extends('admin.master')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <h1>Nhập/Xuất dữ liệu</h1>
        <ol class="breadcrumb">
            <li><a href="{{route('admin')}}"><i class="fa fa-dashboard"></i> Trang tổng quan</a></li>
            <li><a href="{{route('admin.get.list.product')}}">Sản phẩm</a></li>
            <li class="active">Nhập/Xuất dữ liệu</li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <form action="{{route('import')}}" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                        <div class="box-body">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label>Tệp dữ liệu</label>
                                    <input type="file" name="excel" multiple style="width: 250px;" />
                                    @if($errors->has('excel'))
                                    <div class="help-block" style="color: red;">
                                        {{$errors->first('excel')}}
                                    </div>
                                    @endif
                                </div>
                                <button type="submit" class="btn btn-primary">Nhập dữ liệu từ Excel</button>
                                <a class="btn btn-warning" href="{{ route('export') }}">Xuất dữ liệu ra Excel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
@stop