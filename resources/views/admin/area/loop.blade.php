
@foreach ($rows as $row)
	<tr>
		<td>{{ $loop->iteration }}</td>
	    @foreach ($select_columns as $column)
	        <td>{{ $row->$column }}</td>
	    @endforeach
	    {{--  <td>
	    	<button type="button" class="btn btn-secondary m-btn m-btn--custom m-btn--label-danger m-btn--bolder m-btn--uppercase">
	    		{{ $row->countries->name_ar }}
	    	</button>
	    </td>  --}}
	    <td>
	        @include("$base_view.$path.action")
	    </td>
	</tr>
@endforeach
