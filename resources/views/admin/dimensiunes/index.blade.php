@extends('layouts.admin')
@section('content')
@can('dimensiune_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.dimensiunes.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.dimensiune.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.dimensiune.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-Dimensiune">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.dimensiune.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.dimensiune.fields.dimensiune') }}
                        </th>
                        <th>
                            {{ trans('cruds.dimensiune.fields.departament') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($dimensiunes as $key => $dimensiune)
                        <tr data-entry-id="{{ $dimensiune->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $dimensiune->id ?? '' }}
                            </td>
                            <td>
                                {{ $dimensiune->dimensiune ?? '' }}
                            </td>
                            <td>
                                {{ $dimensiune->departament->nume ?? '' }}
                            </td>
                            <td>
                                @can('dimensiune_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.dimensiunes.show', $dimensiune->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('dimensiune_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.dimensiunes.edit', $dimensiune->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('dimensiune_delete')
                                    <form action="{{ route('admin.dimensiunes.destroy', $dimensiune->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                    </form>
                                @endcan

                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>



@endsection
@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('dimensiune_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.dimensiunes.massDestroy') }}",
    className: 'btn-danger',
    action: function (e, dt, node, config) {
      var ids = $.map(dt.rows({ selected: true }).nodes(), function (entry) {
          return $(entry).data('entry-id')
      });

      if (ids.length === 0) {
        alert('{{ trans('global.datatables.zero_selected') }}')

        return
      }

      if (confirm('{{ trans('global.areYouSure') }}')) {
        $.ajax({
          headers: {'x-csrf-token': _token},
          method: 'POST',
          url: config.url,
          data: { ids: ids, _method: 'DELETE' }})
          .done(function () { location.reload() })
      }
    }
  }
  dtButtons.push(deleteButton)
@endcan

  $.extend(true, $.fn.dataTable.defaults, {
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  });
  let table = $('.datatable-Dimensiune:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection