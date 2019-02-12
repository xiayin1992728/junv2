<?php

namespace App\Http\Controllers\AdminControllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FindController extends Controller
{
    public function index()
    {
        $contents = file_get_contents(public_path().'/settings/find.json');
        $contents = json_decode($contents,true);
        if (!$contents) {
            $contents = [
                'notice' => '',
                'server' => '',
                'recommend' => ''
            ];
        }
        return view('admin.find.index',['content' => $contents]);
    }

    public function store(Request $request)
    {
        $handle = fopen(public_path().'/settings/find.json','w+');
        $content = $request->post();
        $result = fwrite($handle,json_encode($content));
        fclose($handle);
        if ($result) {
            return ['status' => 200,'msg' => '保存成功'];
        } else {
            return ['status' => 402,'msg' => '保存失败'];
        }
    }
}
