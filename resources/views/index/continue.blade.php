@extends('index.layouts.app')

@section('title','继续借')

@section('css')
    <link rel="stylesheet" href="/css/index/continue.css">
@endsection

@section('content')
    <div class="large">
        <div class="top">
            <p>您当前的信用分值为 718 分</p>
            <p>恭喜你审核通过：额度以用完</p>
            <p>根据资质为你匹配 <strong style="color:#f49417">几</strong> 个资金方</p>
            <p>成功率高达 <strong style="color:#f49417">94%</strong> </p>
        </div>
        <div class="middle">

        </div>

        <div class="footer">
            <input type="submit" id="continue" value="继续借">
            <p class="text-center">借款金额和期限以当天实际借款为准</p>
        </div>

    </div>
@endsection

@section('script')
    <script type="text/javascript">
        $('#continue').on('click',function() {
            window.location.href = '{{ route('second.index') }}'
        })
    </script>
@endsection