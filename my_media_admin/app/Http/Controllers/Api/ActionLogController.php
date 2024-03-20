<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ActionLog;
use Illuminate\Http\Request;

class ActionLogController extends Controller
{
    //set action log
    public function setActionLog(Request $request)
    {
        $data = [
            'user_id' => $request->user_id,
            'post_id' => $request->post_id
        ];
        ActionLog::create($data);
        $data = ActionLog::get();
        return response()->json([
            'post' => $data
        ]);
    }
}
