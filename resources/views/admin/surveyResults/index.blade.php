@extends('layouts.admin')
@section('content')
@can('survey_result_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.survey-results.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.surveyResult.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.surveyResult.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-SurveyResult">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.surveyResult.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.surveyResult.fields.departament') }}
                        </th>
                        <th>
                            {{ trans('cruds.surveyResult.fields.dimensiune') }}
                        </th>
                        <th>
                            {{ trans('cruds.surveyResult.fields.categorie_de_control') }}
                        </th>
                        {{-- <th>
                            {{ trans('cruds.surveyResult.fields.user') }}
                        </th> --}}
                        <th>
                            {{ trans('cruds.surveyResult.fields.schema_results') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($surveyResults as $key => $surveyResult)
                        <tr data-entry-id="{{ $surveyResult->sr_id }}">
                            <td>

                            </td>
                            <td>
                                {{ $surveyResult->sr_id ?? '' }}
                            </td>
                            <td>
                                {{ $surveyResult->dep_name ?? '' }}
                            </td>
                            <td>
                                {{ $surveyResult->dimensiune ?? '' }}
                            </td>
                            <td>
                                {{ $surveyResult->cc_name ?? '' }}
                            </td>
                            {{-- <td>
                                {{ $surveyResult->user->name ?? '' }}
                            </td> --}}
                            <td>
                                @foreach (json_decode($surveyResult->schema_results) as $key => $result  )
                                <span style="background-color:#2eb85c;color:#fff;border-radius:5px;padding:5px;font-size:12px;font-weight:500;cursor: pointer;">
                                    {{$result->title}}</span>
                                @endforeach
                            </td>
                            <td>
                                @can('survey_result_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.survey-results.show', $surveyResult->sr_id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('survey_result_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.survey-results.edit', $surveyResult->sr_id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('survey_result_delete')
                                    <form action="{{ route('admin.survey-results.destroy', $surveyResult->sr_id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
@can('survey_result_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.survey-results.massDestroy') }}",
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
  let table = $('.datatable-SurveyResult:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });

})

</script>
@endsection
