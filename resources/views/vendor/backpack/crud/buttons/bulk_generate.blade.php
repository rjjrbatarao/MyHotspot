@if ($crud->hasAccess('create'))
<a href="{{ url($crud->route.'/bulk-generate') }} " class="btn btn-xs btn-info"><i class="la la-plus"></i> Bulk Generate</a>
@endif