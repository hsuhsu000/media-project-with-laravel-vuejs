<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    //direct post page
    public function index()
    {
        $category = Category::get();
        $post = Post::get();
        return view('admin.post.index', compact('category', 'post'));
    }

    //create post
    public function createPost(Request $request)
    {
        $validator = $this->checkPostValidation($request);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        if (!empty($request->postImage)) {
            $file = $request->file('postImage');
            $fileName = uniqid() . '_' . $file->getClientOriginalName();
            $file->move(public_path() . '/postImage', $fileName);
            $data = $this->getPostData($request, $fileName);
        } else {
            $data = $this->getPostData($request, NULL);
        }


        Post::create($data);
        return back();
    }

    //delete post
    public function deletePost($id)
    {
        $postData = Post::where('post_id', $id)->first();
        $dbImageName = $postData['image'];

        Post::where('post_id', $id)->delete();
        if (File::exists(public_path() . '/postImage/' . $dbImageName)) {
            File::delete(public_path() . '/postImage/' . $dbImageName);
        }
        return back()->with(['deleteSuccess' => 'Post deleted successfully']);
    }

    //direct update post page
    public function updatePostPage($id)
    {
        $postDetails = Post::where('post_id', $id)->first();
        $category = Category::get();
        $post = Post::get();
        return view('admin.post.update', compact('postDetails', 'category', 'post'));
    }

    //update post
    public function updatePost($id, Request $request)
    {
        $validator = $this->checkPostValidation($request);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        $data = $this->requestUpdatePostData($request);
        if (isset($request->postImage)) {
            $this->storeNewUpdateImage($id, $request, $data);
        } else {
            Post::where('post_id', $id)->update($data);
        }
        return back()->with(['updateSuccess' => 'Post Update Successfully']);
    }

    //post validation check
    private function checkPostValidation($request)
    {
        return Validator::make($request->all(), [
            'postName' => 'required',
            'postDescription' => 'required',
            'postCategory' => 'required',
        ]);
    }

    //get post data
    private function getPostData($request, $fileName)
    {
        return [
            'title' => $request->postName,
            'description' => $request->postDescription,
            'image' => $fileName,
            'category_id' => $request->postCategory,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ];
    }

    //request update post data
    private function requestUpdatePostData($request)
    {
        return [
            'title' => $request->postName,
            'description' => $request->postDescription,
            'category_id' => $request->postCategory,
            'updated_at' => Carbon::now(),
        ];
    }

    //store new update image
    private function storeNewUpdateImage($id, $request, $data)
    {
        //get from client
        $file = $request->postImage;
        $fileName = uniqid() . '_' . $file->getClientOriginalName();
        $data['image'] = $fileName;

        //get db image
        $postData = Post::where('post_id', $id)->first();
        $dbImage = $postData['image'];

        //delete image from public folder
        if (File::exists(public_path() . '/postImage/' . $dbImage)) {
            File::delete(public_path() . '/postImage/' . $dbImage);
        }

        //store new image under public folder
        $file->move(public_path() . '/postImage', $fileName);

        //update new data with new image
        Post::where('post_id', $id)->update($data);
    }
}
