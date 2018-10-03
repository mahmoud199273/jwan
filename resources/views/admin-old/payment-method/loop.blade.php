@foreach ($rows as $row)
	<tr>
	    @foreach ($select_columns as $column)
	        <td>{{ $row->$column }}</td>
	    @endforeach
	    <td>
	    	<img src="{{ asset($row->image) }}" height="50px">
	    </td>
	    <td>
	        @include("$base_view.$path.action")
	    </td>
	</tr>
@endforeach