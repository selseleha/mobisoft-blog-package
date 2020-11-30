<?php

namespace mobisoft\blog\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use mobisoft\blog\Controllers\Controller;
use mobisoft\blog\Requests\PostsRequest;
use mobisoft\blog\Requests\PostUpdateRequest;
use mobisoft\blog\Models\Post;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::simplePaginate(10);
        return view('blog::post.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function create()
    {

        return view(
            'blog::post.create'
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return Application|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector
     */
    public function store(PostsRequest $request)
    {
        //store image in public
        $image = $request->file('image');
        $input['imageName'] = time() . '.' . $image->getClientOriginalExtension(
            );
        $destinationPath = public_path('/images');
        $image->move($destinationPath, $input['imageName']);


        $post = Post::create(
            array_merge(
                $request->all(),
                ['author_id' => Auth::id(), 'image' => $input['imageName']]
            )
        );
        return redirect('post');

    }

    /**
     * Display the specified resource.
     *
     * @param \mobisoft\blog\Models\Post $post
     *
     * @return Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function show(Post $post)
    {

        $post = Post::findorfail($post->id);
        $comments = $post->comments()->with('user')->get();
        return view('blog::post.show', compact('post', 'comments'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \mobisoft\blog\Models\Post $post
     *
     * @return Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        $post = Post::findorfail($post->id);
        return view('blog::post.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request   $request

     * @param \mobisoft\blog\Models\Post $post
     *
     * @return Application|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector
     */
    public function update(PostUpdateRequest $request, Post $post)
    {
        if ($request->image) {
            //store image in public

            $image = $request->file('image');
            $post->image = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('/images');
            $image->move($destinationPath, $post->image);

        }

        $affectedRows = $post->update(
            array('title' => $request->title, 'content' => $request->content,
                  'image' => $post->image)
        );
        return redirect(route('post.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \mobisoft\blog\Models\Post $post
     *
     * @return Application|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector
     */
    public function destroy(Post $post)
    {
        $post->delete();
        return redirect(route('post.index'));
    }

    public function guestIndex()
    {
        $posts = Post::simplePaginate(3);
        return view('blog::post.guestIndex', compact('posts'));
    }
}
