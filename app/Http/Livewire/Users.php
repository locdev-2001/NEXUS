<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
class Users extends Component
{
    use WithPagination;
    protected $paginationTheme ='bootstrap';
    public $paginate = 2;
    public $search="";
    public $checked=[];
    public $selectPage = false;
    public $selectAll = false;
    public function render()
    {
        return view('livewire.users',[
            'users'=>$this->getUsers()
        ]);
    }
    public function getUsers(){
        return $this->getUsersQueryProperties()->paginate($this->paginate);
    }
    public function getUsersQueryProperties(){
        return User::with('profile')->where('role',0)->orderBy('created_at','desc')->search(trim($this->search));
    }
    public function updatedSelectPage($value)
    {
        if ($value) {
            $this->checked = $this->getUsers()->pluck('id')->map(fn ($item) =>(string) $item)->toArray();
        } else {
            $this->checked = [];
        }
    }

    public function updatedChecked()
    {
        $this->selectPage = false;
    }

    public function selectAll()
    {
        $this->selectAll = true;
        $this->checked = $this->getUsersQueryProperties()->pluck('id')->map(fn ($item) => (string) $item)->toArray();
    }

    public function deActiveSingleUser($user_id){
        $user = User::findOrFail($user_id);
        $user->active = 0;
        $user->save();
        $this->checked = array_diff($this->checked,[$user_id]);
        session()->flash('info','Đã khóa tài khoản người dùng');
    }
    public function activeSingleUser($user_id){
        $user = User::findOrFail($user_id);
        $user->active = 1;
        $user->save();
        $this->checked = array_diff($this->checked,[$user_id]);
        session()->flash('info','Đã mở khóa tài khoản người dùng');
    }
    public function deActiveUsers(){
        $users= User::whereKey($this->checked)->get();
        foreach ($users as $user){
            if ($user->active==1){
                $user->active = 0;
                $user->save();
            }
        }
        $this->checked=[];
        session()->flash('info','Đã khóa tài khoản các người dùng');
        $this->selectAll=false;
        $this->selectPage=false;
    }
    public function activeUsers(){
        $users= User::whereKey($this->checked)->get();
        foreach ($users as $user){
            if ($user->active==0){
                $user->active = 1;
                $user->save();
            }
        }
        $this->checked=[];
        session()->flash('info','Đã mở khóa tài khoản các người dùng');
        $this->selectAll=false;
        $this->selectPage=false;
    }
    public function deleteRecords(){
        $users= User::whereKey($this->checked)->delete();
        $this->checked=[];
        session()->flash('info','Đã xóa tài khoản các người dùng');
        $this->selectAll=false;
        $this->selectPage=false;
    }
    public function deleteSingleRecord($user_id){
        $user = User::findOrFail($user_id);
        $user->delete();
        $this->checked = array_diff($this->checked,[$user_id]);
        session()->flash('info','Đã xóa'.$user->name);
    }
    public function isChecked($user_id){
        return in_array($user_id,$this->checked);
    }
    public function editUser($user_id){
        return $this->redirect('edit_user/'.$user_id);
    }
}
