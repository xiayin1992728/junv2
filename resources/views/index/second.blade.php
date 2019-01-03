@extends('index.layouts.app')

@section('title','为你推荐')

@section('css')
    <link rel="stylesheet" href="/css/index/second.css">
@endsection

@section('content')
    <div class="large">

        <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
            <!-- Indicators -->
            <ol class="carousel-indicators">
                <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
                <li data-target="#carousel-example-generic" data-slide-to="1"></li>
                <li data-target="#carousel-example-generic" data-slide-to="2"></li>
            </ol>

            <!-- Wrapper for slides -->
            <div class="carousel-inner" role="listbox">
                @foreach($carousels as $k => $carousel)
                        <div class="item active">
                            <a href="{{ $carousels['oneLink'] }}">
                                <img style="height: 165px" src="{{ env('APP_URL').'/uploads/carousel/'.$carousel }}" alt="...">
                            </a>
                            <div class="carousel-caption">
                            </div>
                        </div>
                @endforeach
            </div>

            <!-- Controls -->
            <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
                <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
                <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
    </div>


    <div>
        <div class="xiakuan">
            <div class="xiakuan-header">
                <div>特大</div>
                <div>喜讯</div>
            </div>

            <icon></icon>
            <div class="xiakuan-list">
                @foreach($product as $k => $v)
                    <div class="xiakuan-container">
                        <div class="left">
                            <i><img  src="{{ env('APP_URL').'/uploads/products/'.$v->logo}}" alt=""></i>
                        </div>
                        <div class='right'>
                            <h6>{{ $v->name }}</h6>
                            <p> <span>{{ '1'.random_int(3,8).random_int(1,9).'****'.random_int(1000,9999) }}</span> 下款 <strong>4500</strong> 成功</p>
                        </div>
                    </div>

                @endforeach
            </div>
        </div>
    </div>

    <p class="notice text-center">申请三个以上产品通过率能达到<strong>100%</strong></p>

    <div class="product-container">
        @foreach ($products as $product)
            <a href="{{ $product->link }}">
                <div class="miao_list">
                    <div class="top">
                        <div class="left">
                            <i><img src="{{ env('APP_URL').'/uploads/products/'.$product->logo }}"></i>
                            <div>
                                <p>{{ $product->name }}</p>
                                <span><strong>{{ $product->maxs }}</strong>元</span>
                            </div>
                        </div>
                        <div class="right">
                            <button class="btn">立即借款</button>
                            <p>借款期限：{{ $product->longtimes }} 天</p>
                        </div>
                    </div>
                    <div class="buttom">
                        <p>{{ $product->tag }}</p>
                    </div>
                </div>
            </a>
        @endforeach
    </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript">
        $('.carousel').carousel()
        let min = 0;
        let logo = null;
        setInterval(function () {
            changeData()
            min = min-50;
            if (min < -50) {
                $(".xiakuan-list").css('top',0);
                min = min + 50;
            }
            $(".xiakuan-list").animate({
                top:min,
            },2000);
        },5000);

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url:"{{ route('second.product') }}",
            type:'POST',
            dataType:'json',
            success:function (res) {
                logo = res.data;
            }
        })

        // 生成随机数
        var random = function(min, max){
            // 若max不存在 min 赋值给max,并重新赋值min
            if(max == null){
                max = min;
                min = 0;
            }
            return min+ Math.floor(Math.random()*(max-min+1))
        }

        // 生成区间数组
        var range = function (start,end,step=1) {
            let arr = [];
            for (let i=start;i<=end;i=i+step) {
                arr.push(i);
            }
            return arr;
        }


        function changeData() {
            let lon = $('.xiakuan-container').length;
            let n = random(0,logo.length);

            if (!logo || logo.length == 0 || logo[n] == undefined) {
                return;
            }

            let phone = '1'+random(3,8)+''+random(1,9)+'****'+random(1000,9999);
            let money = range(3000,10000,500);
            let html = '<div class="xiakuan-container">\n' +
                '                    <div class="left">\n' +
                '                        <i><img src="'+window.location.protocol+'/uploads/products/'+logo[n].logo+'" alt=""></i>\n' +
                '                    </div>\n' +
                '                    <div class=\'right\'>\n' +
                '                        <h6>'+logo[n].name+'</h6>\n' +
                '                        <p> <span>'+phone+'</span> 下款 <strong>'+money[random(0,money.length-1)]+'</strong> 成功</p>\n' +
                '                    </div>\n' +
                '                </div>';

            $('.xiakuan-container').eq(0).remove();
            $('.xiakuan-list').append(html)
        }
    </script>
@endsection