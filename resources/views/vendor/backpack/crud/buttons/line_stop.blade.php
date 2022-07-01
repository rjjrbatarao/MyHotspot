@if ($crud->hasAccess('create'))
<a class="btn btn-sm btn-link" target="_blank" href="{{ url($crud->route.'/'.$entry->getKey().'/line-stop') }} " data-toggle="tooltip" title="reset account"><i class="la la-stop"></i> Stop account</a>
@endif