<?php

namespace App\Http\Controllers\Admin;

use App\Models\Post;
use App\Models\Category;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Crypt;

class PostController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:post-list|post-create|post-edit|post-delete', ['only' => ['index','store']]);
        $this->middleware('permission:post-create', ['only' => ['create','store']]);
        $this->middleware('permission:post-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:post-delete', ['only' => ['destroy']]);
        $this->middleware('permission:publish-post', ['only' => ['PublishPost']]);
        $this->middleware('permission:archive-post', ['only' => ['ArchivePost']]);
        $this->middleware('permission:trash-post', ['only' => ['getPostTrash','DeletePermanentTrashedItem', 'DeletePermanentAllTrashedItem','RestoreTrashedItem','RestoreAllTrashedItem']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('Admin.post.index', [
            'data' => Post::with(['category', 'authors'])->latest()->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Admin.post.create', [
            'categories' => Category::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|unique:post,title',
            'category_id' => 'required',
            'thumbnail' => 'required|image|mimes:jpg,png,gif,jpeg,svg|max:2048',
            'content' => 'required',
        ]);

        $file = $request->file('thumbnail');
        $thumbnail = $file->move('resources/img/post/', Str::limit(Str::slug($request->title), 50, '') . '-' . strtotime('now') . '.' . $file->getClientOriginalExtension());

        $article = Post::create([
            'title' => $request->title,
            'category_id' => $request->category_id,
            'author' => auth()->user()->id,
            'slug' => Str::slug($request->title),
            'thumbnail' => $thumbnail,
            'content' => $request->content,
        ]);
        Helper::printlog('Menambahkan artikel dengan judul ' . $request->title);
        return redirect()->route('post.index')
                        ->with('success','Data Artikel berhasil dibuat');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('Admin.post.edit',[
            'post' => Post::findOrfail(Crypt::decrypt($id)),
            'categories' => Category::all(),
        ]);
       
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $post = Post::findOrfail($id);
        if ($request->title === $post->title) {
            $is_valid_title = 'required';
        }else {
            $is_valid_title = 'required|unique:post,title';
        }
        $request->validate([
            'title' => $is_valid_title,
            'category_id' => 'required',
            'thumbnail' => 'image|mimes:jpg,png,gif,jpeg,svg|max:2048',
            'content' => 'required',
        ]);

        if ($request->hasFile('thumbnail')) {
            Helper::removeFile($post->thumbnail);
            $file = $request->file('thumbnail');
            $thumbnail = $file->move('resources/img/post/', Str::limit(Str::slug($request->title), 50, '') . '-' . strtotime('now') . '.' . $file->getClientOriginalExtension());
        }

        $post->update([
            'title' => $request->title,
            'category_id' => $request->category_id,
            'slug' => Str::slug($request->title),
            'content' => $request->content,
            'thumbnail' => !empty($thumbnail) ? $thumbnail : $article->thumbnail,
        ]);
        Helper::printlog('Mengubah Data Artikel ' . $post->title);
        return redirect()->route('post.index')
                        ->with('success','Data Artikel berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Post::destroy($id);
        Helper::printlog('Menghapus Data Artikel');
        return redirect()->route('post.index')->with('success','Data Post berhasil dihapus');
    }

    public function PublishPost($id)
    {
        $article = Post::findOrfail(Crypt::decrypt($id));
        $article->update(['status' => 'publish']);
        return redirect()->route('post.index')
                            ->with('success','Data Post berhasil dipublish');
    }

    public function ArchivePost($id)
    {
        $post = Post::findOrfail(Crypt::decrypt($id));
        $post->update(['status' => 'archive']);
        return redirect()->route('post.index')
                            ->with('success','Data Post berhasil diarsipkan');
    }

    public function getPostTrash()
    {
        return view('Admin.post.trash', ['data' => Post::with(['category', 'authors'])->onlyTrashed()->get()]);
    }


    public function DeletePermanentTrashedItem($id)
    {
        $post = Post::onlyTrashed()->where('id',$id)->first();
        if(file_exists($post->thumbnail)){
            if(file_exists($post->thumbnail)){
                unlink($post->thumbnail);
                $post->forceDelete();
            }
        }
     Helper::printlog('Menghapus semua data Post dengan ID ' . $id . ' yang telah dihapus secara permanen');
     return redirect()->route('post.trash')
                        ->with('success','Data Post berhasil dihapus secara permanen');
    }

    public function DeletePermanentAllTrashedItem()
    {
        $post = Post::onlyTrashed()->get();
       if($post->count() < 1){
        return redirect()->route('post.trash')
        ->with('error','Data Post Tidak ditemukan');
       }
        foreach($post as $article){
            if(file_exists($article->thumbnail)){
                unlink($article->thumbnail);
                $article->forceDelete();
            }
        }
        Helper::printlog('Menghapus semua data Post yang telah dihapus secara permanen');
        return redirect()->route('post.trash')
        ->with('success','Semua Data Post berhasil dihapus secara permanen');
    }

    public function RestoreTrashedItem($id)
    {
        $dec = Crypt::decrypt($id);
        $article = Post::onlyTrashed()
        ->where('id', $dec)
        ->restore();
        Helper::printlog('Me-restore data Post yang telah dihapus dengan ID ' . $dec);
        return redirect()->route('post.index')
                            ->with('success','Data Post berhasil di-pulihkan');
    }

    public function RestoreAllTrashedItem()
    {
        $post = Post::onlyTrashed()->restore();
        if($post < 1){
            return redirect()->route('post.trash')
            ->with('error','Data Post Tidak ditemukan');
        }else{
            Helper::printlog('Me-restore semua data Post yang telah dihapus');
            return redirect()->route('post.index')
            ->with('success','Semua Data Post yang telah terhapus berhasil di-pulihkan');
        }
    }
}
