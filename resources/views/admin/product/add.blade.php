@extends('admin.master')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <h1>Thêm mới sản phẩm</h1>
        <ol class="breadcrumb">
            <li><a href="{{route('admin')}}"><i class="fa fa-dashboard"></i> Trang tổng quan</a></li>
            <li><a href="{{route('admin.get.list.product')}}">Sản phẩm</a></li>
            <li class="active">Thêm mới sản phẩm</li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <form action="{{route('admin.get.add.product')}}" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                        <div class="box-body">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label>Loại sản phẩm</label>
                                    <select class="form-control" name="category_id">
                                        <option value="">--Chọn loại sản phẩm--</option>
                                        <?php cate_parent($parent,0,"--",old('category_id')); ?>
                                    </select>
                                    @if($errors->has('category_id'))
                                    <div class="help-block" style="color: red;">
                                        {{$errors->first('category_id')}}
                                    </div>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label>Tên sản phẩm</label>
                                    <input type="text" class="form-control" name="name" placeholder="Tên sản phẩm" value="{{old('name')}}">
                                    @if($errors->has('name'))
                                    <div class="help-block" style="color: red;">
                                        {{$errors->first('name')}}
                                    </div>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label>Giá sản phẩm</label>
                                    <input type="number" class="form-control" name="price" placeholder="Giá sản phẩm" value="{{old('price')}}">
                                    @if($errors->has('price'))
                                    <div class="help-block" style="color: red;">
                                        {{$errors->first('price')}}
                                    </div>
                                    @endif
                                </div>
                                
                                <div class="form-group">
                                    <label>Ảnh sản phẩm</label>
                                    <input type="file" name="image" multiple style="width: 250px;"/>
                                    @if($errors->has('image'))
                                    <div class="help-block" style="color: red;">
                                        {{$errors->first('image')}}
                                    </div>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label>Mô tả</label>
                                    <textarea class="form-control" rows="3" name="description" placeholder="Mô tả"></textarea>
                                    @if($errors->has('description'))
                                    <div class="help-block" style="color: red;">
                                        {{$errors->first('description')}}
                                    </div>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label>Nội dung</label>
                                    <textarea class="form-control" id="content" rows="3" name="content" placeholder="Nội dung"></textarea>
                                    <script type="text/javascript">ckeditor('content')</script>
                                </div>
                                <div class="form-group">
                                    <label>Giới tính </label>
                                    <label class="radio-inline">
                                        <input name="rdoLevel" value="1" checked="" type="radio"> Nam
                                    </label>
                                    <label class="radio-inline">
                                        <input name="rdoLevel" value="0" type="radio"> Nữ
                                    </label>
                                </div>
                                <button type="submit" class="btn btn-primary">Thêm mới</button>
                            </div>

                            <div class="col-md-4">
                                
                                <div class="form-group">
                                    <label>Thêm mới ảnh chi tiết</label>
                                    <input type="file" name="fProductDetail[]" multiple style="width: 250px;"/>
                                </div>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
@stop