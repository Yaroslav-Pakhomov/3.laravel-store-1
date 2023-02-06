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
                <a href="{{ route('admin.category.show', [$item->id]) }}"
                   style="font-weight: @if($level) normal @else bold @endif">
                    {{ $item->name }}
                </a>
            </td>
            <td>
                <img src="{{ $item->preview_image ?? 'https://via.placeholder.com/300x125' }}" alt="{{ $item->slug }}" class="img-fluid">
            </td>
            <td>{{ iconv_substr($item->content, 0, 150) }}</td>
            <td>
                <a href="{{ route('admin.category.edit', [$item->id]) }}">
                    <i class="fa fa-edit"></i>
                </a>
            </td>
            <td>
                <form action="{{ route('admin.category.delete', [$item->slug]) }}"
                      method="post">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="m-0 p-0 border-0 bg-transparent">
                        <i class="fa fa-trash-o text-danger"></i>
                    </button>
                </form>
            </td>
        </tr>
        @if ($item->descendants->count())
            <x-admin.category.part.tree :items="$item->descendants" :level="$level"></x-admin.category.part.tree>
        @endif
    @endforeach
@endif
