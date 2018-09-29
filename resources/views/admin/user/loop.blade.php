@foreach ($rows as $row)
	<tr>
        <td>{{ $loop->iteration }}</td>
	    @foreach ($select_columns as $column)
	        <td>{{ $row->$column }}</td>
	    @endforeach
	    <td>
	        @include("$base_view.$path.action")
	    </td>
	</tr>
@endforeach
