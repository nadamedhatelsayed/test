<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        @if(isset($upParent))
            <li class="breadcrumb-item"><a href="{{url('/'.$upParent['url'])}}">{{$upParent['name']}}</a></li>
        @endif
        @if(isset($parent))
            <li class="breadcrumb-item"><a href="{{url('/'.$parent['url'])}}">{{$parent['name']}}</a></li>
        @endif
        @if(isset($name))
            <li class="breadcrumb-item active" aria-current="page">{{$name}}</li>
        @endif
    </ol>
</nav>
