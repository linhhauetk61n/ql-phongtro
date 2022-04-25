<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\User;
use App\Owner;
use App\District;
use App\Categories;
use App\Motelroom;
use App\Notifi;
use App\Yeuthich;
class UserController extends Controller
{
	/* Register */
 public function get_register(){
   $categories = Categories::all();
   $notification = Notifi::all();
   return view('home.register',['categories'=>$categories,'notification'=>$notification]);
}

public function post_register(Request $req){

  $req->validate([
   'txtuser' => 'required|unique:users,username',
   'txtmail' => 'required|email|unique:users,email',
   'txtpass' => 'required|min:6',
   'txt-repass' => 'required|same:txtpass',
   'txtname' => 'required'
],[
   'txtuser.required' => 'Vui lòng nhập tài khoản',
   'txtuser.unique' => 'Tài khoản đã tồn tại trên hệ thống',
   'txtmail.unique' => 'Email đã tồn tại trên hệ thống',
   'txtmail.required' => 'Vui lòng nhập Email',
   'txtpass.required' => 'Vui lòng nhập mật khẩu',
   'txtpass.min' => 'Mật khẩu phải lớn hơn 6 kí tự',
   'txt-repass.required' => 'Vui lòng nhập lại mật khẩu',
   'txt-repass.same' => 'Mật khẩu nhập lại không trùng khớp',
   'txtname.required' => 'Nhập tên hiển thị'
]);
  $newuser = new User;
  $newuser->username = $req->txtuser;
  $newuser->password = bcrypt($req->txtpass);
  $newuser->email = $req->txtmail;
  $newuser->name = $req->txtname;
  $newuser->save();
  return redirect('/user/register')->with('success','Đăng kí thành công');
}

public function get_register_owner(){
   $categories = Categories::all();
   $notification = Notifi::all();
   return view('home.register-owner',['categories'=>$categories,'notification'=>$notification]);
}

public function post_register_owner(Request $req){
   $req->validate([
      'txtuser' => 'required',
      'txtcmt' => 'required|min:11|numeric',
      'txtadd' => 'required',
      'txtsdt' => 'required|min:9'
   ],[
      'txtuser.required' => 'Vui lòng nhập Họ tên',
      'txtcmt.required' => 'Vui lòng nhập Số thẻ căn cước',
      'txtcmt.min' => 'Số thẻ căn cước phải lớn hơn 11 số',
      'txtcmt.numeric' => 'Số thẻ căn cước phải là số',
      'txtadd.required' => 'Vui lòng nhập địa chỉ',
      'txtsdt.required' => 'Vui lòng nhập số điện thoại',
      'txtsdt.min' => 'Số điện thoại phải lớn hơn 8 số'
   ]);
   $newuser = new Owner;
   $newuser->id_users = Auth::user()->id;
   $newuser->fullname = $req->txtuser;
   $newuser->cmt = $req->txtcmt;
   $newuser->address = $req->txtadd;
   $newuser->phone_number = $req->txtsdt;
   $newuser->email = Auth::user()->email;
   $newuser->save();
   return redirect('/user/register-owner')->with('success','Đăng kí thành công, chờ phê duyệt');
}
/* Login */
public function get_login(){
   $categories = Categories::all();
   $notification = Notifi::all();
   return view('home.login',['categories'=>$categories, 'notification'=>$notification]);
}

public function post_login(Request $req){
  $req->validate([
   'txtuser' => 'required',
   'txtpass' => 'required',

],[
   'txtuser.required' => 'Vui lòng nhập tài khoản',
   'txtpass.required' => 'Vui lòng nhập mật khẩu'

]);
  if(Auth::attempt(['username'=>$req->txtuser,'password'=>$req->txtpass])){
   return redirect('/');
}
else 
   return redirect('user/login')->with('warn','Tài khoản hoặc mật khẩu không đúng');	
}
public function logout(){
  Auth::logout();
  return redirect('user/login');
}
public function getprofile(){
   $mypost = Motelroom::where('user_id',Auth::user()->id)->get();
   $categories = Categories::all();
   $notification = Notifi::all();
   return view('home.profile',[
      'categories'=>$categories,
      'mypost'=> $mypost,
      'notification'=>$notification
   ]);
}

public function getEditprofile(){
   $user = User::find(Auth::user()->id);
   $categories = Categories::all();
   $notification = Notifi::all();
   return view('home.edit-profile',[
      'categories'=>$categories,
      'user'=> $user,
      'notification'=>$notification
   ]);
}
public function postEditprofile(Request $request){
   $categories = Categories::all();
   $user = User::find(Auth::id());
   if ($request->hasFile('avtuser')){
      $file = $request->file('avtuser');
      var_dump($file);
      $exten = $file->getClientOriginalExtension();
      if($exten != 'jpg' && $exten != 'png' && $exten !='jpeg' && $exten != 'JPG' && $exten != 'PNG' && $exten !='JPEG' )
       return redirect('user/profile/edit')->with('thongbao','Bạn chỉ được upload hình ảnh có định dạng JPG,JPEG hoặc PNG');
    $Hinh = 'avatar-'.$user->username.'-'.time().'.'.$exten;
    while (file_exists('uploads/avatars/'.$Hinh)) {
     $Hinh = 'avatar-'.$user->username.'-'.time().'.'.$exten;
  }
  if(file_exists('uploads/avatars/'.$user->avatar))
   unlink('uploads/avatars/'.$user->avatar);

$file->move('uploads/avatars',$Hinh);
$user->avatar = $Hinh;
}
$this->validate($request,[
   'txtname' => 'min:3|max:20'
],[
   'txtname.min' => 'Tên phải lớn hơn 3 và nhỏ hơn 20 kí tự',
   'txtname.max' => 'Tên phải lớn hơn 3 và nhỏ hơn 20 kí tự'
]);
if(($request->txtpass != '' ) || ($request->retxtpass != '')){
   $this->validate($request,[
      'txtpass' => 'min:3|max:32',
      'retxtpass' => 'same:txtpass',
   ],[
      'txtpass.min' => 'password phải lớn hơn 3 và nhỏ hơn 32 kí tự',
      'txtpass.max' => 'password phải lớn hơn 3 và nhỏ hơn 32 kí tự',
      'retxtpass.same' => 'Nhập lại mật khẩu không đúng',
      'retxtpass.required' => 'Vui lòng nhập lại mật khẩu',
   ]);
   $user->password = bcrypt($request->txtpass);
}

$user->name = $request->txtname;
$user->save();
return redirect('user/profile/edit')->with('thongbao','Cập nhật thông tin thành công');

         // return view('home.edit-profile',[
         //    'categories'=>$categories,
         //    'user'=> $user
         // ]);
}
/* Đăng tin */
public function get_dangtin(){
   $district = District::all();
   $categories = Categories::all();
   $notification = Notifi::all();
   $owners = Owner::all();
   return view('home.dangtin',[
      'district'=>$district,
      'categories'=>$categories,
      'notification'=>$notification,
      'owners'=>$owners
   ]);
}
public function post_dangtin(Request $request){

   $request->validate([
      'txttitle' => 'required',
      'txtaddress' => 'required',
      'txtprice' => 'required',
      'txtarea' => 'required',
      'txtphone' => 'required',
      'txtdescription' => 'required',
      'txtaddress' => 'required',
      'txtdien' => 'required',
      'txtnuoc' => 'required',
   ],
   [  
      'txttitle.required' => 'Nhập tiêu đề bài đăng',
      'txtaddress.required' => 'Nhập địa chỉ phòng trọ',
      'txtprice.required' => 'Nhập giá thuê phòng trọ',
      'txtarea.required' => 'Nhập diện tích phòng trọ',
      'txtphone.required' => 'Nhập SĐT chủ phòng trọ (cần liên hệ)',
      'txtdescription.required' => 'Nhập mô tả ngắn cho phòng trọ',
      'txtaddress.required' => 'Nhập hoặc chọn địa chỉ phòng trọ trên bản đồ',
      'txtdien.required' => 'Nhập giá điện',
      'txtnuoc.required' => 'Nhập giá nước'
   ]);

   /* Check file */ 
   $json_img ="";
   if ($request->hasFile('hinhanh')){
      $arr_images = array();
      $inputfile =  $request->file('hinhanh');
      foreach ($inputfile as $filehinh) {
         $namefile = "phongtro-".str_random(5)."-".$filehinh->getClientOriginalName();
         while (file_exists('uploads/images'.$namefile)) {
           $namefile = "phongtro-".str_random(5)."-".$filehinh->getClientOriginalName();
        }
        $arr_images[] = $namefile;
        $filehinh->move('uploads/images',$namefile);
     }
     $json_img =  json_encode($arr_images,JSON_FORCE_OBJECT);
  }
  else {
   $arr_images[] = "no_img_room.png";
   $json_img = json_encode($arr_images,JSON_FORCE_OBJECT);
}
/* tiện ích*/
$json_tienich = json_encode($request->tienich,JSON_FORCE_OBJECT);
/* ----*/ 
/* get LatLng google map */ 
$arrlatlng = array();
$arrlatlng[] = $request->txtlat;
$arrlatlng[] = $request->txtlng;
$json_latlng = json_encode($arrlatlng,JSON_FORCE_OBJECT);

/* --- */
/* New Phòng trọ */
$motel = new Motelroom;
$motel->title = $request->txttitle;
$motel->description = $request->txtdescription;
$motel->price = $request->txtprice;
$motel->area = $request->txtarea;
$motel->count_view = 0;
$motel->address = $request->txtaddress;
$motel->latlng = $json_latlng;
$motel->utilities = $json_tienich;
$motel->images = $json_img;
$motel->user_id = Auth::user()->id;
$motel->category_id = $request->idcategory;
$motel->district_id = 999;
$motel->phone = $request->txtphone;
$arr = explode(',', $request->txtaddress);
if ($arr[count($arr)-1] == " Việt Nam" || $arr[count($arr)-1] == "  Việt Nam"|| $arr[count($arr)-1] == "Việt Nam" ) {
   $motel->thanhpho = $arr[count($arr)-2]; 
   $motel->quanhuyen = $arr[count($arr)-3];   
}
else{
   $motel->thanhpho = $arr[count($arr)-1];
   $motel->quanhuyen = $arr[count($arr)-2];  
}
$motel->dien = $request->txtdien;
$motel->nuoc = $request->txtnuoc;
$motel->tinhtrangphong = "Còn phòng";
$motel->save();
return redirect('/user/dangtin')->with('success','Đăng tin thành công. Vui lòng đợi Admin kiểm duyệt');

}
public function viewedNotifi($id)
{
   $notifi = Notifi::where('id_users', $id)->get();
   $count=0;
   foreach ($notifi as $value) {
      $count+=1;
   }
   for ($i=0; $i <$count  ; $i++) { 
      $notifi[$i]->status = 1;
      $notifi[$i]->save();
   }
   return redirect('/');
}

public function get_dsphongtro(){
   $district = District::all();
   $categories = Categories::all();
   $notification = Notifi::all();
   $owners = Owner::all();
   $motelrooms = Motelroom::where('user_id',Auth::user()->id)->get();
   return view('home.dsphongtro',[
      'district'=>$district,
      'categories'=>$categories,
      'notification'=>$notification,
      'owners'=>$owners,
      'motelrooms'=>$motelrooms
   ]);
}

public function get_dsyeuthich()
{
    $district = District::all();
   $categories = Categories::all();
   $notification = Notifi::all();
   $owners = Owner::all();
   $yeuthich = Yeuthich::where('id_users',Auth::user()->id)->get();
   for ($i=0; $i < $yeuthich->count() ; $i++) { 
      $motelrooms[$i] = Motelroom::find($yeuthich[$i]->id_motel);
      $motelrooms[$i]->id_yeuthich = $yeuthich[$i]->id;
   }
   
   return view('home.dsyeuthich',[
      'district'=>$district,
      'categories'=>$categories,
      'notification'=>$notification,
      'owners'=>$owners,
      'motelrooms'=>$motelrooms
   ]);
}

public function delyeuthich($id)
{
   $yeuthich = Yeuthich::find($id);  
   $room = Motelroom::find($yeuthich->id_motel);
   $room->yeuthich = $room->yeuthich - 1;
   $room->save();
   $yeuthich->delete();
   return redirect('/user/dsphongtro')->with('success','Đã xóa khỏi danh sách yêu thích');
}
public function conphong($id)
{
   $room = Motelroom::find($id);
   $room->tinhtrangphong = "Đã cho thuê";
   $room->save();
   return redirect('/user/dsphongtro')->with('success','Cập nhật trạng thái thành công');
}
public function dachothue($id)
{
   $room = Motelroom::find($id);
   $room->tinhtrangphong = "Còn phòng";
   $room->save();
   return redirect('/user/dsphongtro')->with('success','Cập nhật trạng thái thành công');
}



public function yeuthich($id)
{
   if (Auth::user()) {

      $yeuthich = new Yeuthich;
      $yeuthich->id_users = Auth::user()->id;
      $yeuthich->id_motel = $id;
      $yeuthich->save();
      $room = Motelroom::find($id);
      $room->yeuthich = $room->yeuthich + 1;
      $room->save();
      return redirect('/phongtro/'.$room->slug)->with('success','Cập nhật trạng thái thành công');
   }
   else{
      $room = Motelroom::find($id);
      return redirect('/phongtro/'.$room->slug)->with('fail','Vui lòng đăng nhập để thực hiện chức năng này');
   }
}

}
