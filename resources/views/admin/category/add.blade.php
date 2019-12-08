@extends('admin.master')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Thêm mới danh mục</h1>
        <ol class="breadcrumb">
            <li><a href="{{route('admin')}}"><i class="fa fa-dashboard"></i> Trang tổng quan</a></li>
            <li><a href="{{route('admin.get.list.category')}}">Danh mục</a></li>
            <li class="active">Thêm mới danh mục</li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <form action="" method="POST">
                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                        <div class="box-body">
                            <div class="form-group">
                                <label>Loại sản phẩm</label>
                                <select class="form-control" name="category_id">
                                    <option value="0">--Chọn loại sản phẩm--</option>
                                    <?php cate_parent($parent); ?>
                                </select>
                                @if($errors->has('category_id'))
                                <div class="help-block" style="color: red;">
                                    {{$errors->first('category_id')}}
                                </div>
                                @endif
                            </div>
                            <div class="form-group">
                                <label>Tên danh mục</label>
                                <input type="text" class="form-control" name="name" placeholder="Tên danh mục" value="{{old('name')}}">
                                @if($errors->has('name'))
                                <div class="help-block" style="color: red;">
                                    {{$errors->first('name')}}
                                </div>
                                @endif
                            </div>
                            <div class="form-group">
                                <label>Mô tả</label>
                                <textarea class="form-control" rows="3" name="description" placeholder="Mô tả"></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Thêm mới</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
@stop