@push('script')
	{!! Html::script('backend/demo/default/custom/components/base/toastr.js') !!}
	<script type="text/javascript">
		toastr.options = {
			  "closeButton": true,
			  "debug": false,
			  "newestOnTop": false,
			  "progressBar": false,
			  "positionClass": "toast-top-right",
			  "preventDuplicates": true,
			  "onclick": null,
			  "showDuration": "300",
			  "hideDuration": "1000",
			  "timeOut": "10000",
			  "extendedTimeOut": "1000",
			  "showEasing": "swing",
			  "hideEasing": "linear",
			  "showMethod": "fadeIn",
			  "hideMethod": "fadeOut"
		};

		@if (session()->has('success'))
			toastr.success("{{ session()->get('success') }}", "@lang('lang.Success')");
		@elseif (session()->has('failed'))
			toastr.error("{{ session()->get('failed') }}", "Success");
		@elseif (session()->has('notice'))
			toastr.warning("{{ session()->get('notice') }}", "Success");
		@elseif (session()->has('status'))
			toastr.info("{{ session()->get('status') }}", "Success");
		@endif

	</script>

@endpush
