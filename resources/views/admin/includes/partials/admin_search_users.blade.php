@if ($users->isNotEmpty())
  <ul class="list-group">
    @foreach ($users as $user)
      <li class="list-group-item">
        <a href="{{ route('admin.viewUsers.indexViewUsers', ['query' => $user->email ?: $user->id]) }}">
          {{ $user->name }}
        </a>
      </li>
    @endforeach
  </ul>
@else
  <div class="p-2">@lang('messages.user_graph.no_results')</div>
@endif
