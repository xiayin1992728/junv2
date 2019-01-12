<?php

namespace App\Http\Controllers\AdminControllers;

use App\Handlers\ImageUploadHandler;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CarouselController extends Controller
{
    public function index()
    {
        $contents = file_get_contents(public_path().'/settings/carousel.json');
        $contents = json_decode($contents,true);
        if (!$contents) {
            $contents = [
                [
                    'url' => '',
                    'img' => '',
                ],
                [
                    'url' => '',
                    'img' => '',
                ],
                [
                    'url' => '',
                    'img' => '',
                ],
            ];
        }
        return view('admin.carousel.index',['contents' => $contents]);
    }

    public function store(Request $request)
    {
        $handle = fopen(public_path().'/settings/carousel.json','w+');
        $content = $request->post('carousel');
        foreach ($content as $k => $v) {
            $content[$k]['url'] = $this->addHttp($v['url']);
        }
        $result = fwrite($handle,json_encode($content));
        fclose($handle);
        if ($result) {
            return ['status' => 200,'msg' => '保存成功'];
        } else {
            return ['status' => 402,'msg' => '保存失败'];
        }
    }

    public function upload(ImageUploadHandler $uploadHandler,Request $request)
    {
        $result = $uploadHandler->save($request->file,'carousel');
        if ($request) {
            return ['status' => 200,'path' => $result['path']];
        } else {
            return ['status' => 402,'msg' => '上传失败'];
        }
    }

    protected function addHttp($value)
    {
        if (strpos($value,'http://') === false) {
            $value = 'http://'.$value;
        }
        return $value;
    }
}
