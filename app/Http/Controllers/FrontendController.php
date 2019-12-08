<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB,Auth,Cart,Hash,Mail;
use App\Models\User;
use App\Models\ProductProperties;
use App\Models\Product;
use App\Models\Category;
use App\Models\Article;
use App\Models\SaleProduct;
use App\Models\Slide;
use App\Models\Order;
use App\Models\Size;
use App\Models\District;
use App\Models\Coupon;
use Illuminate\Support\Facades\Input;

class FrontendController extends Controller
{
	public function home(){
		$product = DB::table('products')->select('id','name','slug','price','image','category_id','active','hot','pay')->orderBy('id','DESC')->skip(0)->take(8)->get();
        $slide = Slide::all();
        return view('frontend.home',compact('product','slide'));
    }

    public function sanpham(Request $req){
        $product = DB::table('products')->select('id','name','image','slug','category_id','price','description','content','active');
        if($req->price){
            $price = $req->price;
            switch ($price) {
                case '1':
                $product->where('price','<',1000000);
                break;
                case '2':
                $product->whereBetween('price',[1000000,2000000]);
                break;
                case '3':
                $product->where('price','>',2000000);
                break;
            }
        }

        if ($req->orderby) {
            $orderby = $req->orderby;
            switch ($orderby) {
                case 'price':
                $product->orderBy('price','ASC');
                break;
                case 'price-desc':
                $product->orderBy('price','DESC');
                break;
            }
        }
        if ($req->k) {
            $product = Product::where('name','like','%'.$req->k.'%');
        }

        if ($req->size) {
            $size = $req->size;
            $product = DB::table('products')->leftJoin('product_properties','products.id','=','product_properties.product_id')->leftJoin('sizes','product_properties.size_id','=','sizes.id')->select('products.id','products.active','products.slug','products.name','products.image','products.category_id','products.price','products.description','products.content','product_properties.product_id','product_properties.size_id','sizes.size')->where('sizes.size',$size)->where('qty','>',0)->distinct();
            //dd($product->get());
        }
        //dd($product->get());
        $product = $product->paginate(9);

        return view('frontend.product-all',[
            'product' => $product->appends(Input::except('page'))
        ]);
    }


    public function loaisanpham(Request $req,$id){
       $product_cate = DB::table('products')->select('id','name','image','slug','category_id','price','description','active');

       if($req->price){
        $price = $req->price;
        switch ($price) {
            case '1':
            $product_cate->where('price','<',1000000);
            break;
            case '2':
            $product_cate->whereBetween('price',[1000000,2000000]);
            break;
            case '3':
            $product_cate->where('price','>',2000000);
            break;
        }
    }

    if ($req->orderby) {
        $orderby = $req->orderby;
        switch ($orderby) {
            case 'price':
            $product_cate->orderBy('price','ASC');
            break;
            case 'price-desc':
            $product_cate->orderBy('price','DESC');
            break;
        }
    }
    if ($req->size){
        $size = $req->size;
        $product_cate = DB::table('products')->join('product_properties','products.id','=','product_properties.product_id')->join('sizes','product_properties.size_id','=','sizes.id')->where('sizes.size',$size)->where('qty','>',0);
    }
    $product_cate = $product_cate->where('category_id',$id)->paginate(9);
    if (count($product_cate)>0) {
        $cate = DB::table('categories')->select('parent_id')->where('id',$product_cate[0]->category_id)->first();
        $menu_cate = DB::table('categories')->select('id','name','slug')->where('parent_id',$cate->parent_id)->get();
        return view('frontend.shop',[
            'product_cate' => $product_cate->appends(Input::except('page')),
            'menu_cate' => $menu_cate,
        ]);
    }
    return view('frontend.shop',[
            'product_cate' => $product_cate->appends(Input::except('page'))
        ]);
}
    public function chitietsanpham($id,Request $req){
       $product = DB::table('products')->where('id',$id)->first();
       $image = DB::table('product_images')->select('id','images')->where('product_id',$product->id)->get();
       $product_new = DB::table('products')->where('category_id',$product->category_id)->where('id','<>',$id)->take(8)->get();
       $size = ProductProperties::where('product_id',$product->id)->get();
       $sale_product = SaleProduct::where('product_id',$product->id)->select('start_date','end_date','sale')->first();

       return view('frontend.product-detail',compact('product','product_new','image','size','sale_product'));
    }

    public function home_login(){
        return view('frontend.login');
    }
    public function post_home_login(Request $req){
        $this->validate($req,[
            'email' => 'required|email',
            'password' => 'required'
        ],[
            'required' => ':attribute không được rỗng',
            'email' => ':attribute không đúng định dạng (demo@gmail.com)'
        ]);
        if (Auth::attempt($req->only('email','password'))) {
            return redirect()->route('frontend.get.home')->with(['level'=>'success','success'=>'Đăng nhập tài khoản thành công']);
        }else{
            return redirect()->back()->with(['level'=>'danger','success'=>'Đăng nhập tài khoản thất bại, vui lòng thử lại']);
        }
    }
    public function register(){
        return view('frontend.register');
    }
    public function post_register(Request $req){
        $this->validate($req,[
            'name' => 'required',
            'email' => 'required|unique:users,email|email',
            'password' => 'required|min:6',
            're_password' => 'same:password'
        ],[
            'name.required' => 'Họ tên không được để trống',
            'email.required' => 'Email không được để trống',
            'email.unique' => 'Email đã tồn tại',
            'email.email' => 'Email phải đúng định dạng (demo@gmail.com)',
            'password.required' => 'Mật khẩu không được để trống',
            'password.min' => 'Mật khẩu ít nhất 6 ký tự',
            're_password.same' => 'Mật khẩu nhập lại không đúng'
        ]);

        $user = new User();
        $user->name = $req->name;
        $user->email = $req->email;
        $user->password = Hash::make($req->password);
        $user->remember_token = $req->_token;
        $user->phone = $req->phone;
        $user->level = 0;
        $user->save();
        return redirect()->back()->with(['level'=>'success','success'=>'Đăng ký tài khoản thành công']);
    }
    public function home_logout(){
        Auth::logout();
        if (session()->has('coupon')) {
            $couponId = session()->get('coupon')['couponId'] ?? 0;
            $coupon = Coupon::where('id',$couponId)->first();
            session()->forget('coupon');
            $coupon_qty = $coupon->qty + 1;
            $coupon = Coupon::where('id',$couponId)->update(['qty'=>$coupon_qty]);
        }
        Cart::destroy();
        return redirect()->route('frontend.get.home')->with(['level'=>'success','success'=>'Thoát tài khoản thành công']);
    }

    public function tintuc(){
        $article = Article::where('active','=',1)->paginate(6);
        return view('frontend.article',compact('article'));
    }

    public function chitiettintuc($id){
        $article = Article::find($id);
        return view('frontend.article-detail',compact('article'));
    }

    public function lienhe(){
        return view('frontend.contact-us');
    }

    public function post_lienhe(Request $req){
        $this->validate($req,[
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'address' => 'required',
            'content' => 'required'
        ],[
            'name.required' => 'Họ tên không được để trống',
            'email.required' => 'Email không được để trống',
            'email.email' => 'Email không đúng định dạng (demo@gmail.com)',
            'phone.required' => 'Số điện thoại không được để trống',
            'address.required' => 'Địa chỉ không được để trống',
            'content.required' => 'Nội dung không được để trống'
        ]);
        $email = $req->email;
        $data['info'] = $req->all();
        Mail::send('frontend.email-contact', $data, function($message) use ($email){
            $message ->from($email,$email);
            $message ->to('nghhai2712@gmail.com');
            $message ->subject('Thông tin liên hệ');
        });
        return redirect()->route('frontend.get.home');
    }

    public function gioithieu(){
        return view('frontend.about');
    }

    public function changeLanguage($language){
        \Session::put('language', $language);
        return redirect()->back();
    }

    public function donhang(){
        if(Auth::check()){
            $user = Auth::user()->id;
            $order = Order::where('user_id',$user)->select('id','created_at','total','payment','status','payment_method')->orderBy('id','DESC')->get();
            return view('frontend.order',compact('order','user'));
        }else{
            return redirect()->route('home.login');
        }
    }

    public function chitiet($id){
        $order = Order::where('id',$id)->select('status')->get();
        return view('frontend.order-detail',compact('order'));
    }

    public function thaydoimatkhau(){
        return view('frontend.change-password');
    }

    public function post_thaydoimatkhau(Request $req){
        $this->validate($req,[
            'old_password' => 'required',
            'new_password' => 'required|min:6',
            're_password' => 'required|same:new_password',
        ],[
            'old_password.required' => 'Mật khẩu cũ không được để trống',
            'new_password.required' => 'Mật khẩu mới không được để trống',
            'new_password.min' => 'Mật khẩu mới phải từ 6 ký tự',
            're_password.required' => 'Vui lòng nhập lại mật khẩu',
            're_password.same' => 'Mật khẩu nhập lại không đúng',
        ]);
        $user = Auth::user();
        if(Hash::check($req->old_password,$user->password)){
            $user = User::find($user->id);
            $user->password = Hash::make($req->new_password);
            $user->save();
            return redirect()->back()->with(['level'=>'success','success'=>'Thay đổi mật khẩu thành công']);
        }
        return redirect()->back()->with(['level'=>'danger','success'=>'Mật khẩu cũ không đúng']);
    }

    public function getDistrict(Request $req){
        $district = District::where('city_id',$req->city_id)->pluck('district','id');
        return json_encode($district);
    }
}