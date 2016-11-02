@foreach($items as $item)
<li {!! $item->attributes() !!}>
    @if($item->link) <a href="{{ $item->url() }}">
        {!! $item->prependIcon()->title !!}
    </a>
    @else
    {!! $item->prependIcon()->title !!}
    @endif
    @if($item->hasChildren())
    <ul class="treeview-menu @if ($item->active() ? 'menu-open' : '') @endif">
        @foreach($item->children() as $child)
        <li {!! $child->attributes() !!}><a href="{{ $child->url() }}">{!! $child->prependIcon()->title !!}</a></li>
        @endforeach
    </ul>
    @endif
</li>
@if($item->divider)
<li{{\HTML::attributes($item->divider)}}></li>
@endif
@endforeach