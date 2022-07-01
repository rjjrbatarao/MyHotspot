@if ($crud->hasAccess('create'))
<a class="btn btn-sm btn-link" target="_self" href="{{ url($crud->route.'/'.$entry->getKey().'/line-reset') }} " data-toggle="tooltip" title="reset account"><i class="la la-refresh"></i> Reset account</a>
@endif