@php
$uid = uniqid(mt_rand(), true);
// 소수점(.)을 빈 문자열로 대체하여 제거
$uid = str_replace('.', '', $uid);
@endphp
<div>
    <div>
        <div class="row align-items-center py-2 px-3">
            <div class="col-lg-8 col-xl-9 col-7">
                <h5 class="fs-2">
                    @if(isset($rows['title']))
                    {!! $rows['title'] !!}
                    @endif
                </h5>
                <h6 class="card-subtitle text-muted">
                    @if(isset($rows['description']))
                    {!! $rows['description'] !!}
                    @endif
                </h6>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="tab-content p-3" id="pills-tabTwoContent">
                    <div class="tab-pane tab-example-code fade show active" id="pills-{{$uid}}-code" role="tabpanel"
                        aria-labelledby="pills-{{$uid}}-code-tab">
                        @if(isset($rows['code']))
                        <pre><code class="language-markup">{!! code_view($rows['code']) !!}</code></pre>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>