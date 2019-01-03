@extends('index.layouts.app')

@section('title','贷款')

@section('css')
    {{--<link href="https://cdn.bootcss.com/roundSlider/1.3.2/roundslider.css" rel="stylesheet">--}}
    <link rel="stylesheet" href="/css/index/loan.css">
@endsection

@section('content')
    <p class="text-center zimu">快速审核，极速下款。</p>

    <div class="sum col-md-12">
        <div class="xuanjine">
            <div class="bar">
                <div class="left"></div>
                <div class="icon">
                    <div class="tishikuang">
                        3000
                    </div>
                </div>
            </div>
        </div>

        <div class="biaoshi">
            <div>1000</div>
            <div>3000</div>
            <div>5000</div>
        </div>
        <h4 class="text-center">借款金额</h4>
    </div>
    <div class="days col-md-12">
        {{ $errors->first('money') }}
        <p class="text-center">借款期限</p>
        <div class="zhuanshi">

            {{--<div id="slider"></div>--}}

            <div class="btn-container">
                <div class="btn-groups">
                    <div class="groups-item" days="7">7天</div>
                    <div class="groups-item" days="21">21天</div>
                    <div class="groups-item" days="30">30天</div>
                </div>
            </div>
            <div class="btnj">
                <form action="{{ route('loan.store') }}" method="POST">
                    {{ csrf_field()  }}
                    <input type="hidden" name="money" value="" id="money">
                    <input type="hidden" name="days" value="" id="days">
                    <input type="submit" name="" value="马上借" id="mashangjie">
                </form>
            </div>
        </div>
    </div>

    <div class="">

    </div>
@endsection

@section('script')
    {{--<script src="https://cdn.bootcss.com/roundSlider/1.3.2/roundslider.js"></script>--}}
    <script type="text/javascript">
        window.onload = function() {

            var lineDiv = document.getElementsByClassName('bar')[0]; //长线条
            var minDiv = document.getElementsByClassName('icon')[0]; //小方块
            var vals = document.getElementsByClassName("tishikuang")[0];
            var left = document.getElementsByClassName('left')[0];
            var ifBool = false; //判断鼠标是否按下

            //事件
            var start = function(e) {
                e.stopPropagation();
                ifBool = true;
                console.log("鼠标按下")
            }

            var move = function(e) {
                if(ifBool) {
                    if(!e.touches) {  //兼容移动端
                        var x = e.clientX;
                    } else {   //兼容PC端
                        var x = e.touches[0].pageX;
                    }
                    //var x = e.touches[0].pageX || e.clientX; //鼠标横坐标var x
                    var lineDiv_left = getPosition(lineDiv).left; //长线条的横坐标
                    var minDiv_left = x - lineDiv_left; //小方块相对于父元素（长线条）的left值
                    if(minDiv_left >= lineDiv.offsetWidth - 15) {
                        minDiv_left = lineDiv.offsetWidth - 15;
                    }
                    if(minDiv_left < 0) {
                        minDiv_left = 0;
                    }
                    //设置拖动后小方块的left值
                    minDiv.style.left = minDiv_left + "px";
                    let moeny = parseInt((minDiv_left / (lineDiv.offsetWidth - 15)) * 100);
                    if (moeny % 10 == 0 && moeny!= 0) {
                        vals.innerText = moeny*50;
                    }

                    left.style.width = parseInt((minDiv_left / (lineDiv.offsetWidth - 15)) * 100) + '%';
                }
            }

            var end = function(e) {
                ifBool = false;
            }
            //鼠标按下方块
            minDiv.addEventListener("touchstart", start);
            minDiv.addEventListener("mousedown", start);
            //拖动
            minDiv.addEventListener("touchmove", move);
            minDiv.addEventListener("mousemove", move);
            //鼠标松开
            minDiv.addEventListener("touchend", end);
            minDiv.addEventListener("mouseup", end);
            //获取元素的绝对位置
            function getPosition(node) {
                var left = node.offsetLeft; //获取元素相对于其父元素的left值var left
                var top = node.offsetTop;
                current = node.offsetParent; // 取得元素的offsetParent
                // 一直循环直到根元素

                while(current != null) {
                    left += current.offsetLeft;
                    top += current.offsetTop;
                    current = current.offsetParent;
                }
                return {
                    "left": left,
                    "top": top
                };
            }
        }

        //   $("#slider").roundSlider({
        //     radius: 100,
        //     width: 15,
        //     handleSize: "+8",
        //     handleShape: "dot",
        //     sliderType: "min-range",
        //     value: 180,
        //     min:0,
        //     max:365,
        // });
        // $('.rs-tooltip-text').before('<strong class="tianshu">day</strong>');

        $('#mashangjie').on('click',function () {
            $("#money").val(parseInt($('.tishikuang').text()));
            // $('#days').val($('.rs-tooltip').text());

        });

        $('.groups-item').on('click',function(){
            $('.groups-item').removeClass('active');
            $(this).addClass('active');
            $('#days').val($(this).attr('days'));
        })
    </script>
@endsection