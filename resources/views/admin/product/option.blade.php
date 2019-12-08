@extends('admin.master')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <h1>Tùy chọn sản phẩm</h1>
        <ol class="breadcrumb">
            <li><a href="{{route('admin')}}"><i class="fa fa-dashboard"></i> Trang tổng quan</a></li>
            <li><a href="{{route('admin.get.list.product')}}">Sản phẩm</a></li>
            <li class="active">Tùy chọn sản phẩm</li>
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
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label>Tên sản phẩm</label>
                                    <input type="text" class="form-control" name="name" placeholder="Tên danh mục" value="{{old('name',$product->name)}}">
                                </div>
                                <div class="form-group">
                                    <label>Ảnh sản phẩm</label>
                                    <a class="thumbnail">
                                        <img src="{{url('uploads/')}}/{{$product->image}}" alt="" width="250px">
                                    </a>
                                </div>
                                <div class="form-group">
                                    <label>Size</label>
                                    <select class="form-control" name="size">
                                        @foreach($size as $item)
                                        <option value="{{$item->id}}">{{$item->size}}</option>
                                        @endforeach
                                    </select>
                                    <!-- <input type="text" class="form-control" name="size" placeholder="Size"> -->
                                </div>
                                <div class="form-group">
                                    <label>Số lượng</label>
                                    <input type="number" class="form-control" name="quantity" placeholder="Số lượng">
                                    @if($errors->has('quantity'))
                                    <div class="help-block" style="color: red;">
                                        {{$errors->first('quantity')}}
                                    </div>
                                    @endif
                                </div>
                                <button type="submit" class="btn btn-primary">Thêm size</button>
                                <a class="btn btn-primary" href="{{route('admin.get.list.product')}}">Quay lại</a>
                            </div>
                        </form>
                        <div class="col-md-4">
                            <label>Danh sách size</label>
                            <table class="table table-bordered table-responsive">
                                <thead>
                                    <th>Size</th>
                                    <th>Số lượng</th>
                                    <th>Sửa</th>
                                </thead>
                                <tbody>
                                    @foreach($product->product_properties as $item_1)
                                    <tr>
                                        <td>
                                            <?php $p = DB::table('sizes')->where('id',$item_1->size_id)->first();
                                                    echo "$p->size"; 
                                                ?>
                                        </td>
                                        <td>
                                            <input type="number" name="qty" value="{{$item_1->qty}}" class='qty-{{$item_1->size_id}}'>
                                            <!-- <input type="number" name="qty" id="qty" value="{{old('qty',$item_1['qty'])}}"> -->
                                        </td>
                                        <td><a href="javascript:void(0)" class='save-quantity' data-pid='{{$product->id}}' data-sizeid='{{$item_1->size_id}}'><span class="glyphicon glyphicon-ok" aria-hidden="true"></span> Lưu</a></td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div> 
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@stop

@section('script')
    <script type="text/javascript">
        $(document).ready(function (){
        $(".save-quantity").click(function (){
            var product_id = $(this).attr('data-pid');
            var size_id = $(this).attr('data-sizeid');
            var qty = $('.qty-'+size_id).val();

            $.ajax({
                url: `{{route('ajax.edit.quantity')}}`,
                type: "POST",
                dataType: 'json',
                data: {
                    'product_id': product_id,
                    'qty': qty,
                    'size_id': size_id
                },
                
                success:function(data)
                {
                    if (data.valid.success==false) {
                        toastr.error(data.valid.messages);
                        setTimeout(function() {
                            document.location.reload()
                        }, 2000);
                    } else {
                        toastr.success(data.valid.messages);
                    }
                }
            })
        });
    });
    </script>
@stop