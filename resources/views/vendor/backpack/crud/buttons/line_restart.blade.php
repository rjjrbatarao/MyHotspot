@if ($crud->hasAccess('create'))
<a class="btn btn-sm btn-link" target="_self" href="{{ url($crud->route.'/'.$entry->getKey().'/line-restart') }} " data-toggle="tooltip" title="restart"><i class="la la-refresh"></i> Restart</a>
@endif