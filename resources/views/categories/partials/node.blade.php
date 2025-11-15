<div style="margin-left: {{ $node->depth * 20 }}px; border:1px solid #ccc; padding:5px; margin-bottom:2px;">
    {{ $node->name }}

    <a href="{{ url('/categories/'.$node->id.'/move/up') }}">⬆️</a>
    <a href="{{ url('/categories/'.$node->id.'/move/down') }}">⬇️</a>

    @foreach($node->children as $child)
        @include('categories.partials.node', ['node' => $child])
    @endforeach
</div>
