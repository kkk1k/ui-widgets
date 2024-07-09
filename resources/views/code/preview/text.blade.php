<div>
    <h3 class="fs-1">
        @if(isset($rows['title']))
        {!! $rows['title'] !!}
        @endif
    </h3>
    <p class="card-subtitle text-muted fs-3">
        @if(isset($rows['description']))
        {!! $rows['description'] !!}
        @endif
    </p>
</div>