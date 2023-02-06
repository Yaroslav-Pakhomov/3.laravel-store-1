@if (count($items))
    @php
        $level = -1;
        $level++;
    @endphp
    @foreach ($items as $item)
        <tr>
            <td>
                @if ($level)
                    {{ str_repeat('—', $level) }}
                @endif
                <a href="{{ route('admin.brand.show', [$item->id]) }}"
                   style="font-weight:@if($level) normal @else bold @endif">
                    {{ $item->name }}
                </a>
            </td>
            <td>
                <img src="{{ $item->preview_image ?? 'https://via.placeholder.com/300x125' }}" alt="{{ $item->slug }}" class="img-fluid">
            </td>
            <td>{{ iconv_substr($item->content, 0, 150) }}</td>
            <td>
                <a href="{{ route('admin.brand.edit', [$item->id]) }}">
                    <i class="fa fa-edit"></i>
                </a>
            </td>
            <td>
                <form action="{{ route('admin.brand.delete', [$item->id]) }}"
                      method="post">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="m-0 p-0 border-0 bg-transparent">
                        <i class="fa fa-trash-o text-danger"></i>
                    </button>
                </form>
            </td>
        </tr>
{{--        @dd($item->children)--}}
{{--        @if ($item->children->count())--}}
{{--            <x-admin.brand.part.tree :items="$item->children" :level="$level"></x-admin.brand.part.tree>--}}
{{--        @endif--}}
    @endforeach
@endif
