<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\ActionLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TrendPostController extends Controller
{
    //direct trendpost page
    public function index()
    {
        $posts = ActionLog::select(
            'action_logs.post_id as actionLogsPostId',
            'posts.post_id as postsPostId',
            'posts.title as postsTitle',
            'posts.description as postsDescription',
            'posts.image as postsImage',
            'posts.category_id as postsCategoryId',
            DB::raw('COUNT(action_logs.post_id) as post_count')
        )
            ->leftJoin('posts', 'posts.post_id', '=', 'action_logs.post_id')
            ->groupBy('action_logs.post_id', 'posts.post_id', 'posts.title', 'posts.description', 'posts.image', 'posts.category_id')
            ->get();

        return view('admin.trend_post.index', compact('posts'));
    }

    //direct trend post details
    public function trendPostDetails($id)
    {
        $post = Post::where('post_id', $id)->first();
        return view('admin.trend_post.details', compact('post'));
    }
}
