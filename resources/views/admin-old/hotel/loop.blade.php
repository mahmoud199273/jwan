@foreach ($rows as $row)
	<tr>
	    @foreach ($select_columns as $column)
	        <td>{{ $row->$column }}</td>
	    @endforeach
	    <td>{{ $row->detail ? ($row->detail->city ? $row->detail->city->name_ar : '') :'' }}</td>

	    <td>
    		<div class="m-demo__preview m-demo__preview--btn">
    			@if($row->activation == 2)
			    	<a href="javascript:void(0)" class="btn btn-outline-warning m-btn m-btn--icon m-btn--pill m-btn--air action-btn">
						<span>
							<i class="fa flaticon-clock-1"></i>
							<span>@lang('lang.pending')</span>
						</span>
					</a>
				@elseif($row->activation == 3)
					<a href="javascript:void(0)" class="btn btn-outline-metal m-btn m-btn--icon m-btn--pill m-btn--air action-btn">
						<span>
							<i class="fa flaticon-clock-1"></i>
							<span>@lang('lang.new')</span>
						</span>
					</a>
				@elseif($row->activation == 0)
					<a href="javascript:void(0)" class="btn btn-outline-metal m-btn m-btn--icon m-btn--pill m-btn--air action-btn">
						<span>
							<i class="fa flaticon-clock-1"></i>
							<span>@lang('lang.suspended')</span>
						</span>
					</a>
				@else
					<a href="javascript:void(0)" class="btn btn-outline-success m-btn m-btn--icon m-btn--pill m-btn--air action-btn">
						<span>
							<i class="fa flaticon-clock-1"></i>
							<span>@lang('lang.Approved')</span>
						</span>
					</a>
				@endif
			</div>
	    </td>
	    <td>
	        @include("$base_view.$path.action")
	    </td>
	</tr>
@endforeach

