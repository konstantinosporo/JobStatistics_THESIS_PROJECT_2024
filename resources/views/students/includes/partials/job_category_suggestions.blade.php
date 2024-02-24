@if ($jobCategories->isNotEmpty())
  <ul class="list-group">
    @foreach ($jobCategories as $category)
      <li class="list-group-item">
        <a href="{{ route('statistics', ['query' => $category->english_name]) }}">
          @if (app()->getLocale() == 'en')
            {{ $category->english_name }}
          @else
            {{ $category->greek_name }}
          @endif
        </a>
      </li>
    @endforeach
  </ul>
@else
  <div class="p-2">@lang('messages.user_graph.no_results')</div>
@endif
