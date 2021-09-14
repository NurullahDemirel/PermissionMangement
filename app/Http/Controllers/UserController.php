<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserDetay;
use Countable;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
class UserController extends Controller
{
    public function index(){
        $users=User::all();
        return view('user.manage',compact('users'));
    }//izni olan kişi herhangi bir kişini deyatyını silme işlemini rol veya izinleri ile ilgili değişiklik yapmak istediğinde düştüğü view sayfasını görüntüler

    public function editPermission($id){
        $izinler=Permission::all();
        $kisi=User::with('permissions','roles.permissions')->where('id',$id)->first();

        $readOnly=$this->readOnly($kisi);
        $enable=$this->enable($kisi);

        return view('role.edit',compact('izinler','kisi','readOnly','enable'));
    }//izni olan kişinin ,herhangi bir kişinin rollerine ek olarak ekleme veya çıkrtma yapmak istediğinde düştüğü view sayfasını görüntüler

    public function getNewPermission(Request $request,$id){

        //kişiyi al
        //eklediklerini ve daha önce işaretli olanları tespti et
        //eğer çıkarıyorsa bütün ek izinleri bunun kontrolünü yap
        //daha fazla ekleme mi yapıyor yoksa çıkartmamı yapıyor tespit et


        $kisi=User::with(['roles','permissions'])->where('id',$id)->first();

        $oldCount=count($kisi->permissions);
        $oldPermissions=[];

        foreach ($kisi->permissions as $index=>$izin){
            $oldPermissions[$index]=$izin->name;
        }

        $newPermissions=$request->permissions;


        if(!is_array($newPermissions)){

            foreach ($oldPermissions as  $oldPermission){
                $kisi->revokePermissionTo($oldPermission);
            }

            return redirect()->route('edit-permisson',$id);
        }//role hariç ek verdiklerini çıkarmış ise

        $newCount=count($newPermissions);

        if($oldCount>$newCount && is_array($newPermissions)){

            foreach ($oldPermissions as  $oldPermission){
                if (!in_array($oldPermission,$newPermissions)){
                    $kisi->revokePermissionTo($oldPermission);
                }
            }

        }//old büyük ve new de bir eleman varsa

        if ($newCount>$oldCount){
            for ($i=0;$i<$newCount;$i++){
                if(($i<$oldCount)){
                    if(!($oldPermissions[$i]==$newPermissions[$i])){
                        $kisi->revokePermissionTo($oldPermissions[$i]);
                        $kisi->givePermissionTo($newPermissions[$i]);
                    }

                    else{
                        $kisi->givePermissionTo($newPermissions[$i]);
                    }
                }
                else{
                    $kisi->givePermissionTo($newPermissions[$i]);
                }
            }
        }//new büyükse ekliyor

        if ($newCount == $oldCount){
            foreach ($oldPermissions as $index=>$oldPermission){
                if(!($oldPermission ==$newPermissions[$index])){
                    $kisi->revokePermissionTo($oldPermission);
                    $kisi->givePermissionTo($newPermissions[$index]);
                }
            }
        }

        return redirect()->route('edit-permisson',$id);
    }//kişiye sahip olğu rolden başka görev eklemesi veya çıkartması yaptığımızda post işleminin düştüğü fonk.

    public function editRole($id){
        $roles=Role::with('permissions')->get();
        $user=User::with('roles')->where('id',$id)->first();
        return view('user.edit-role',compact('user','roles'));
    }//yönetici bir kişini rolünü düzeltmek için girdiğinde gelen view

    public function editUserRole(Request $request){
        $user=User::find($request->id);
        $user->syncRoles($request->roles);//bu kişiden bütün rolleri silip sadece gelen rolleri ekler
        return redirect()->route('edit-role',$user->id);
    }//bu kişinin rollerine ekleme çıkartma yapacağı zaman düştüğü post işleminin geldiği yer

    public function editUser($id){
       $user=User::find($id)->first();
        return view('user.edit',compact('user'));
    }///izini olan kişi , kişiyi düzelmek için geleceği view

    public function deleteUser($id){
        User::find($id)->delete();
        redirect()->route('manager-user');
    }//kişi modal da evet e bastığında silinmesi gereken kişiyi yakalayan

    public function tamamla($code){
        $user=User::where('activate_code',$code)->firstOrFail();
        return view('user.kayit-tamamla',compact('user'));
    }//detaylarını girmesi için gösterilmesi gereken view

    public function Detaylar(Request $request,$code){
//        $request->validate([
//            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
//        ]);

        $imageName = time().'.'.$request->image->extension();

        $request->image->move(public_path('images'), $imageName);
        $age=Carbon::parse($request->birthday)->age;
        $user=User::where('activate_code',$code)->first();
        UserDetay::create([
           'birthday'=>$request->birthday,
           'age'=>$age,
           'sex'=>$request->sex,
           'phone'=>$request->phone,
           'heigh'=>$request->height,
           'weight'=>$request->weight,
           'adres'=>$request->adres,
           'image'=>$imageName,
           'user_id'=>$user->id
        ]);
        $user->detay=1;
        $user->save();
        return redirect()
            -> route('home')
            ->with('mesaj','aktivasyon işleminiz tamamlanmıştır')
            ->with('mesaj_tur','success');



    }//kullanıcı detaylarını yakalayan

    public function readOnly(User $user){
        $disabledArray=array();
        $izinler=Permission::all();
        foreach ($user->roles as $role){

            foreach ($izinler as $izin){
                if( ($role->hasPermissionTo($izin->name)) &&  !(in_array($izin->name,$disabledArray)) ){
                    array_push($disabledArray,$izin->name);
                }
            }
        }
        return $disabledArray;
    }//kişinin bütün rollerini alır sahip olduğu izinlerin birleşimini array olatrak verir.

    public function enable(User $user){
        $disabledArray=array();
        $izinler=DB::select('select * from permissions');
        foreach ($user->roles as $role){
            foreach ($izinler as $izin){
                if(($user->hasDirectPermission($izin->name))  &&  !(in_array($izin->name,$disabledArray))){
                    array_push($disabledArray,$izin->name);
                }
            }
        }
        return $disabledArray;
    } //kişinin rolünde olmayıp ek olarak aldığı izinleri array olarak dönen fonk

}
