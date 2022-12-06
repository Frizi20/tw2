@extends('layouts.admin')
@section('content')
@can('survey_builder_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.survey-builders.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.surveyBuilder.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.surveyBuilder.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-SurveyBuilder">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.surveyBuilder.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.surveyBuilder.fields.departamente') }}
                        </th>
                        <th>
                            {{trans('cruds.surveyBuilder.fields.dimensiune')}}
                        </th>
                        <th>
                            {{ trans('cruds.surveyBuilder.fields.categorie_de_control') }}
                        </th>
                        <th>
                            {{ trans('cruds.surveyBuilder.fields.schema') }}
                        </th>
                        <th>
                            {{ trans('cruds.surveyBuilder.fields.generala') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($surveyBuilders as $key => $surveyBuilder)
                        <tr data-entry-id="{{ $surveyBuilder->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $surveyBuilder->id ?? '' }}
                            </td>
                            <td>
                                {{ $surveyBuilder->departamente->nume ?? '' }}
                            </td>
                            <td>
                                {{ json_encode($surveyBuilder->dimensiuni->dimensiune ?? '') }}
                            </td>
                            <td>
                                {{ $surveyBuilder->categorie_de_control->nume ?? '' }}
                            </td>
                            <td>
                                {{ $surveyBuilder->schema ?? '' }}
                            </td>
                            <td>
                                <span style="display:none">{{ $surveyBuilder->generala ?? '' }}</span>
                                <input type="checkbox" disabled="disabled" {{ $surveyBuilder->generala ? 'checked' : '' }}>
                            </td>
                            <td>
                                @can('survey_builder_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.survey-builders.show', $surveyBuilder->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('survey_builder_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.survey-builders.edit', $surveyBuilder->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('survey_builder_delete')
                                    <form action="{{ route('admin.survey-builders.destroy', $surveyBuilder->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
@can('survey_builder_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.survey-builders.massDestroy') }}",
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
  let table = $('.datatable-SurveyBuilder:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });

})

</script>
@endsection
