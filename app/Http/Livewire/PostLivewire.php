<?php

namespace App\Http\Livewire;

use App\Models\Posts;
use Livewire\Component;
use Livewire\WithPagination;

class PostLivewire extends Component
{
    use WithPagination;
    protected $paginationTheme ='bootstrap';
    public $paginate = 10;
    public $search="";
    public $checked=[];
    public $selectPage = false;
    public $selectAll = false;
    public function render()
    {
        return view('livewire.post-livewire',[
            'posts'=>$this->getPosts()
        ]);
    }
    public function getPosts(){
        return $this->getPostsQueryProperties()->paginate($this->paginate);
    }
    public function getPostsQueryProperties(){
        return Posts::with('user')->orderBy('created_at','desc')->search(trim($this->search));
    }
    public function updatedSelectPage($value)
    {
        if ($value) {
            $this->checked = $this->getPosts()->pluck('id')->map(fn ($item) =>(string) $item)->toArray();
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
        $this->checked = $this->getPostsQueryProperties()->pluck('id')->map(fn ($item) => (string) $item)->toArray();
    }
    public function lockSinglePost($post_id){
        $post = Posts::findOrFail($post_id);
        $post->active = 2;
        $post->save();
        $this->checked = array_diff($this->checked,[$post_id]);
        session()->flash('info','Đã khóa bài viết');
    }
    public function activeSinglePost($post_id){
        $post = Posts::findOrFail($post_id);
        $post->active = 1;
        $post->save();
        $this->checked = array_diff($this->checked,[$post_id]);
        session()->flash('info','Đã duyệt bài viết');
    }
    public function lockPosts(){
        $posts = Posts::whereKey($this->checked)->get();
        foreach ($posts as $post){
            if ($post->active == 1){
                $post->active = 2;
                $post->save();
            }
        }
        $this->checked=[];
        session()->flash('info','Đã khóa các bài viết');
        $this->selectAll=false;
        $this->selectPage=false;
    }
    public function unlockPosts(){
        $posts = Posts::whereKey($this->checked)->get();
        foreach ($posts as $post){
            if ($post->active == 2){
                $post->active = 1;
                $post->save();
            }
        }
        $this->checked=[];
        session()->flash('info','Đã mở khóa các bài viết');
        $this->selectAll=false;
        $this->selectPage=false;
    }
    public function activePosts(){
        $posts = Posts::whereKey($this->checked)->get();
        foreach ($posts as $post){
            if ($post->active == 0){
                $post->active = 1;
                $post->save();
            }
        }
        $this->checked=[];
        session()->flash('info','Đã duyệt các bài viết');
        $this->selectAll=false;
        $this->selectPage=false;
    }
    public function deleteRecords(){
        $posts = Posts::whereKey($this->checked)->delete();
        $this->checked=[];
        session()->flash('info','Đã xóa các bài viết đã chọn');
        $this->selectAll=false;
        $this->selectPage=false;
    }
    public function deleteSingleRecord($post_id){
        $post = Posts::findOrFail($post_id);
        $post->delete();
        $this->checked = array_diff($this->checked,[$post_id]);
        session()->flash('info','Đã xóa bài viết');
    }
    public function isChecked($post_id){
        return in_array($post_id,$this->checked);
    }
    public function reviewPost($post_id){
        return $this->redirect('post/'.$post_id);
    }
}
