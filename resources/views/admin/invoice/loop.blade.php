@foreach ($rows as $row)
	<tr>
	    @foreach ($select_columns as $column)
	        <td>{{ $row->$column }}</td>
	    @endforeach
	    <td>
	    	<a href="{{ url("admin/hotel/".$row->hotel->id) }}">
		    	{{-- <button type="button" class="btn btn-secondary m-btn m-btn--custom m-btn--label-danger m-btn--bolder m-btn--uppercase"> --}}
	    		{{ $row->hotel->name }}
		    	{{-- </button> --}}
	    	</a>
	    </td>

		<td>
    		{{ $row->amount }}
	    </td>
	    
	    <td>
	        @include("$base_view.$path.action")
	    </td>
	</tr>
@endforeach