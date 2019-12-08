@extends('admin.master')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <h1>Sửa bài viết</h1>
        <ol class="breadcrumb">
            <li><a href="{{route('admin')}}"><i class="fa fa-dashboard"></i> Trang tổng quan</a></li>
            <li><a href="{{route('admin.get.list.article')}}">Bài viết</a></li>
            <li class="active">Sửa bài viết</li>
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
                                <input type="text" class="form-control" name="name" placeholder="Tên bài viết" value="{{old('name',$article->name)}}">
                                @if($errors->has('name'))
                                <div class="help-block" style="color: red;">
                                    {{$errors->first('name')}}
                                </div>
                                @endif
                            </div>
                            <div class="form-group">
                                <label>Ảnh bài viết</label>
                                <a class="thumbnail">
                                    <img src="{{url('uploads/article/')}}/{{$article->image}}" alt="" style="width: 500px;height: 300px;">
                                    <input type="hidden" name="img_current" value="{!! $article->image !!}">
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
                                <textarea class="form-control" rows="3" name="description" placeholder="Mô tả"> {{old('description',$article->description)}} </textarea>
                            </div>
                            <div class="form-group">
                                <label>Nội dung</label>
                                <textarea class="form-control" rows="3" name="content" placeholder="Nội dung">{{old('content',$article->content)}}</textarea>
                                <script type="text/javascript">ckeditor('content')</script>
                            </div>
                            <div class="form-group">
                                    <label>Nổi bật </label>
                                    <label class="radio-inline">
                                        <input name="hot" value="1" @if($article["hot"]==1) checked="checked"; @endif type="radio"> Có
                                    </label>
                                    <label class="radio-inline">
                                        <input name="hot" value="0" @if($article["hot"]==0) checked="checked"; @endif type="radio"> Không
                                    </label>
                                </div>
                            <button type="submit" class="btn btn-success">Lưu thông tin</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
@stop