<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use App\Models\Coupon;
session_start();
class CartController extends Controller
{
    public function check_coupon(Request $request){
    $data = $request->all();
    $coupon = Coupon::where('coupon_code', $data['coupon'])->first();
    if($coupon){
        $count_coupon = $coupon->count();
        if($count_coupon>0){
            $coupon_session = Session::get('coupon');
            if($coupon_session==true){
                $is_avaiable = 0;
                if($is_avaiable==0){
                    $cou[] = array(
                        'coupon_code' => $coupon->coupon_code,
                        'coupon_condition' => $coupon->coupon_condition,
                        'coupon_number' => $coupon->coupon_number,
                    );
                    Session::put('coupon', $cou);
                }else{
                $cou[] = array(
                    'coupon_code' => $coupon->coupon_code,
                    'coupon_condition' => $coupon->coupon_condition,
                    'coupon_number' => $coupon->coupon_number,
                );
                Session::put('coupon', $cou);
            }
            }
            Session::save();
            return Redirect()->back()->with('message', 'Thêm mã giảm giá thành công');
        }
    }else{
        return Redirect()->back()->with('message', 'Mã giảm giá không đúng, vui lòng nhập lại');
    }
    }
    public function update_cart(Request $request){
       $data = $request->all();
         $cart = Session::get('cart');
        if($cart==true){
            foreach($data['cart_qty'] as $key => $qty){
                foreach($cart as $session => $val){
                    if($val['session_id']==$key){
                        $cart[$session]['product_qty'] = $qty;
                    }
                }
            }
            Session::put('cart', $cart);
            return Redirect::to('/gio-hang')->with('message', 'Cập nhật số lượng sản phẩm thành công');
        }else{
            return Redirect::to('/gio-hang')->with('message', 'Cập nhật số lượng sản phẩm thất bại');
        }
    }
    public function del_all_product(){
        $cart = Session::get('cart');
        if($cart==true){
            Session::forget('cart');
            Session::forget('coupon');
            return Redirect::to('/gio-hang')->with('message', 'Xóa tất cả sản phẩm khỏi giỏ hàng thành công');
        }
    }
    public function del_product($session_id){
        $cart = Session::get('cart');
        if($cart==true){
            foreach($cart as $key => $val){
                if($val['session_id'] == $session_id){
                    unset($cart[$key]);
                }
            }
            Session::put('cart', $cart);
            return Redirect::to('/gio-hang')->with('message', 'Xóa sản phẩm khỏi giỏ hàng thành công');
        }else{
            return Redirect::to('/gio-hang')->with('message', 'Xóa sản phẩm khỏi giỏ hàng thất bại');
        }
    }
    public function gio_hang(){
           $cate_product = DB::table('tbl_category_product')->where('category_status','0')->orderby('category_id', 'desc')->get();
        $brand_product = DB::table('tbl_brand')->where('brand_status','0')->orderby('brand_id', 'desc')->get();
        return view('pages.cart.cart_ajax')->with('category', $cate_product)
       ->with('brand', $brand_product);
}
//   public function add_cart_ajax(Request $request){
    
//      $data = $request->all();
//      $session_id = substr(md5(microtime()), rand(0, 26), 5);
//      $cart = Session::get('cart');
//      if ( $cart == true){
//         $is_avaiable = 0;
//         foreach($cart as $key => $val){
//             if($val['product_id'] == $data['product_id']){
//                 $is_avaiable++;
//             }
//         }   
//         if(!$is_avaiable == 0 ){
//             $cart[] = array(
//                 'session_id' => $session_id,
//                 'product_id' => $data['cart_product_id'],
//                 'product_name' => $data['cart_product_name'],               
//                 'product_image' => $data['cart_product_image'],
//                 'product_qty' => $data['cart_product_qty'],
//                 'product_price' => $data['cart_product_price'],
//             );
//         Session::put('cart', $cart);
//         }

//      }else{
//         $cart = array(
//             'session_id' => $session_id,
//             'product_id' => $data['cart_product_id'],
//             'product_name' => $data['cart_product_name'],
//             'product_image' => $data['cart_product_image'],
//             'product_qty' => $data['cart_product_qty'],
//             'product_price' => $data['cart_product_price'],
//         );
//      }
//      Session::put('cart', $cart);
//      Session::save();
// }
public function add_cart_ajax(Request $request)
{
    $data = $request->all();

    // Lấy id từ request (tên trường bên client là cart_product_id)
    $productId = $data['cart_product_id'] ?? null;
    if (!$productId) {
        return response()->json('Missing product id', 400);
    }

    $session_id = substr(md5(microtime()), rand(0, 26), 5);

    // Lấy cart, nếu chưa có thì mặc định là mảng rỗng
    $cart = Session::get('cart', []);

    // Kiểm tra xem sản phẩm đã tồn tại trong cart chưa
    $is_available = false;
    foreach ($cart as $key => $item) {
        // $item phải là mảng chứa 'product_id'
        if (isset($item['product_id']) && $item['product_id'] == $productId) {
            $is_available = true;
            // nếu muốn tăng số lượng khi trùng:
            // $cart[$key]['product_qty'] += intval($data['cart_product_qty']);
            break;
        }
    }

    // Nếu chưa có thì thêm sản phẩm mới (luôn push vào mảng)
    if (!$is_available) {
        $cart[] = [
            'session_id'   => $session_id,
            'product_id'   => $productId,
            'product_name' => $data['cart_product_name'] ?? '',
            'product_image'=> $data['cart_product_image'] ?? '',
            'product_qty'  => intval($data['cart_product_qty'] ?? 1),
            'product_price'=> floatval($data['cart_product_price'] ?? 0),
        ];
    }

    // Lưu cart về session
    Session::put('cart', $cart);
    Session::save();

    return response()->json('Thêm giỏ hàng thành công');
}

    public function save_cart(Request $request){
    $productId = $request->productid_hidden;
    $quantity = $request->qty;
    $product_info = DB::table('tbl_product')->where('product_id', $productId)->first();
    //  Cart::add('123', 'Áo thun', 2, 150000, ['size' => 'L', 'màu' => 'xanh']);
    // Cart::destroy();
    $data['id'] = $product_info->product_id;
    $data['qty'] =$quantity;
    $data['name'] = $product_info->product_name;
    $data['price'] = $product_info->product_price;
    $data['weight'] = $product_info->product_price;
    $data['options']['image'] = $product_info->product_image;
    Cart::add($data);
     return Redirect::to('/show-cart')->with('message', 'Thêm sản phẩm vào giỏ hàng thành công');
    }
    public function show_cart(){
        $cate_product = DB::table('tbl_category_product')->where('category_status','0')->orderby('category_id', 'desc')->get();
        $brand_product = DB::table('tbl_brand')->where('brand_status','0')->orderby('brand_id', 'desc')->get();
        return view('pages.cart.show_cart')->with('category', $cate_product)
       ->with('brand', $brand_product);
    }
    public function delete_to_cart($rowId){
        Cart::update($rowId, 0);
        return Redirect::to('/show-cart')->with('message', 'Xóa sản phẩm khỏi giỏ hàng thành công');
    }
    public function update_cart_quantity(Request $request){
        $rowId = $request->rowId_cart;
        $qty = $request->cart_quantity;
        Cart::update($rowId, $qty);
        return Redirect::to('/show-cart')->with('message', 'Cập nhật số lượng sản phẩm thành công');
    }
}