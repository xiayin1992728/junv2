@extends('index.layouts.app')

@section('title','特征')

@section('css')
    <link rel="stylesheet" href="/css/index/feature.css">
@endsection

@section('content')
    <div class="large">
        <div class="tugif">

        </div>
        <h4>智能AI正在</h4>
        <div class="wenzi">

        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript">
        window.onload = function () {
            setTimeout(function () {
                window.location.href = "{{ route('continue.index') }}"
            },5000);
        }
        let num = 0;

        let jisuan = setInterval(function() {

            let texts = '<p>正在计算你的第 '+(num = num+1)+' 个身份特征</p>'
            $('.wenzi').append(texts);
            console.log();
            if ($('.wenzi p').length > 3) {
                $('.wenzi p').eq(0).remove();
            }
            if (num > 100) {
                clearInterval(jisuan);
            }
        },50);
    </script>
@endsection
