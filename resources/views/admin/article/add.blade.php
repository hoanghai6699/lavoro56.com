@extends('admin.master')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <h1>Thêm mới bài viết</h1>
        <ol class="breadcrumb">
            <li><a href="{{route('admin')}}"><i class="fa fa-dashboard"></i> Trang tổng quan</a></li>
            <li><a href="{{route('admin.get.list.article')}}">Bài viết</a></li>
            <li class="active">Thêm mới bài viết</li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <form action="" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                        <div class="box-body">
                            <div class="form-group">
                                <label>Tên bài viết</label>
                                <input type="text" class="form-control" name="name" placeholder="Tên bài viết" value="{{old('name')}}">
                                @if($errors->has('name'))
                                <div class="help-block" style="color: red;">
                                    {{$errors->first('name')}}
                                </div>
                                @endif
                            </div>
                            <div class="form-group">
                                <label>Ảnh bài viết</label>
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
                                <textarea class="form-control" rows="3" name="content" placeholder="Nội dung"></textarea>
                                <script type="text/javascript">ckeditor('content')</script>
                                @if($errors->has('content'))
                                <div class="help-block" style="color: red;">
                                    {{$errors->first('content')}}
                                </div>
                                @endif
                            </div>
                            <div class="form-group">
                                    <label>Nổi bật </label>
                                    <label class="radio-inline">
                                        <input name="hot" value="1" checked="" type="radio"> Có
                                    </label>
                                    <label class="radio-inline">
                                        <input name="hot" value="0" type="radio"> Không
                                    </label>
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