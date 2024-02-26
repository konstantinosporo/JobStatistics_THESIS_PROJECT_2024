 <ul class="nav nav-tabs">
   <li class="nav-item">
     <a class="nav-link {{ request()->routeIs('graphType1') ? 'active' : '' }}"
       href="{{ route('graphType1', ['query' => request('query')]) }}"><i
         class="bi bi-graph-up mx-2"></i>@lang('messages.user_graph.cartesian_graph')</a>
   </li>
   <li class="nav-item ">
     <a class="nav-link {{ request()->routeIs('graphType2') ? 'active' : '' }}"
       href="{{ route('graphType2', ['query' => request('query')]) }} "><i
         class="bi bi-pie-chart-fill mx-2"></i>@lang('messages.user_graph.pie_graph')</a>
   </li>
 </ul>
