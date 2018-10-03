@foreach ($rows as $row)
	<tr>
	    @foreach ($select_columns as $column)
	        <td>{{ $row->$column }}</td>
	    @endforeach
	    <td>
	    	<a href="{{ $row->url }}" target="_blank">
		    	<button type="button" class="btn btn-secondary m-btn m-btn--custom m-btn--label-danger m-btn--bolder m-btn--uppercase">
		    		<i class="{{ $row->icon }}"></i>
		    	</button>
	    	</a>
	    </td>
	    <td>
	    	@if($row->activation != 1) 
	    		<form method='POST' action={{ url('/admin/social-media/activate/'.$row->id.'') }} class='form-horizontal submit-form'>
	                <input type='hidden' name='_token' value={{ csrf_token() }}>
	                <button type='submit' class='btn btn-success submit-form btn-sm'>
	                	<i class="fa fa-check"></i>
	                </button>
           		 </form>
            @else
		        <form method='POST' action={{ url('/admin/social-media/activate/'.$row->id.'') }} class='form-horizontal submit-form'>
	                <input type='hidden' name='_token' value={{ csrf_token() }}>
	                <button type='submit' class='btn btn-danger submit-form btn-sm'>
	                	<i class="fa fa-close"></i>
	                </button>
	            </form>
            @endif
	    </td>
	    <td>
	        @include("$base_view.$path.action")
	    </td>
	</tr>
@endforeach