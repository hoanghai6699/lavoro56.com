@extends('admin.master')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <h1>Sửa sản phẩm</h1>
        <ol class="breadcrumb">
            <li><a href="{{route('admin')}}"><i class="fa fa-dashboard"></i> Trang tổng quan</a></li>
            <li><a href="{{route('admin.get.list.product')}}">Sản phẩm</a></li>
            <li class="active">Sửa sản phẩm</li>
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
                    <form action="" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                        <div class="box-body">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label>Loại sản phẩm</label>
                                    <select class="form-control" name="category_id">
                                        <option value="">--Chọn loại sản phẩm--</option>
                                        <?php cate_parent($parent,0,"--",$product["category_id"]); ?>
                                    </select>
                                    @if($errors->has('category_id'))
                                    <div class="help-block" style="color: red;">
                                        {{$errors->first('category_id')}}
                                    </div>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label>Tên sản phẩm</label>
                                    <input type="text" class="form-control" name="name" placeholder="Tên danh mục" value="{{old('name',$product->name)}}">
                                    @if($errors->has('name'))
                                    <div class="help-block" style="color: red;">
                                        {{$errors->first('name')}}
                                    </div>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label>Giá sản phẩm</label>
                                    <input type="number" class="form-control" name="price" placeholder="Giá sản phẩm" value="{{old('price',$product->price)}}">
                                    @if($errors->has('price'))
                                    <div class="help-block" style="color: red;">
                                        {{$errors->first('price')}}
                                    </div>
                                    @endif
                                </div>
                                
                                <div class="form-group">
                                    <label>Ảnh sản phẩm</label>
                                    <a class="thumbnail">
                                        <img src="{{url('uploads/')}}/{{$product->image}}" alt="" width="250px">
                                        <input type="hidden" name="img_current" value="{!! $product->image !!}">
                                    </a>
                                    <input type="file" name="image" multiple style="width: 250px;"/>
                                    @if($errors->has('image'))
                                    <div class="help-block" style="color: red;">
                                        {{$errors->first('image')}}
                                    </div>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label>Mô tả</label>
                                    <textarea class="form-control" rows="3" name="description" placeholder="Mô tả">{{old('description',$product->description)}}</textarea>
                                </div>
                                <div class="form-group">
                                    <label>Nội dung</label>
                                    <textarea class="form-control" rows="3" name="content" placeholder="Nội dung">{{old('content',$product->content)}}</textarea>
                                    <script type="text/javascript">ckeditor('content')</script>
                                </div>
                                <div class="form-group">
                                    <label>Giới tính </label>
                                    <label class="radio-inline">
                                        <input name="rdoLevel" value="1" @if($product["gender"]==1) checked="checked"; @endif type="radio"> Nam
                                    </label>
                                    <label class="radio-inline">
                                        <input name="rdoLevel" value="0" @if($product["gender"]==0) checked="checked"; @endif type="radio"> Nữ
                                    </label>
                                </div>
                                <button type="submit" class="btn btn-success">Lưu thông tin</button>
                            </div>

                            <div class="col-md-1"></div>
                            <div class="col-md-4">
                                @foreach($product_detail as $item)
                                <label>Ảnh chi tiết</label>
                                    <a class="thumbnail" id="del-img" href="{{route('admin.delete-img.product',['id'=>$item->id])}}">
                                        <i class="fa fa-trash-o fa-fw" data-toggle="tooltip" data-placement="top" title="Xóa"></i>
                                        <img src="{{url('uploads/detail')}}/{{$item->images}}" alt="">      
                                    </a>
                                @endforeach
                                <label>Thêm mới ảnh chi tiết</label>
                                <input type="file" name="fProductDetail[]" multiple style="width: 250px;"/>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
@stop