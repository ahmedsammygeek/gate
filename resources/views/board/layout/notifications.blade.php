<div class="offcanvas offcanvas-end" tabindex="-1" id="notifications">
	<div class="offcanvas-header py-0">
		<h5 class="offcanvas-title py-3"> التنبيهات </h5>
		<button type="button" class="btn btn-light btn-sm btn-icon border-transparent rounded-pill" data-bs-dismiss="offcanvas">
			<i class="ph-x"></i>
		</button>
	</div>

	<div class="offcanvas-body p-0">

		


		@foreach (Auth::user()->notifications as $notification)
{{-- 		@php
			dd($notification['data']['type'])
		@endphp --}}
		<div class="p-3">
			<div class="d-flex align-items-start">
				<div class="me-3">
					@switch($notification['data']['type'])
					@case('purchase')
					<div class="bg-warning bg-opacity-10 text-success rounded-pill">
						<i class="ph-shopping-cart  p-2"></i>
					</div>
					@break
					@case('due_installment')
					<div class="bg-warning bg-opacity-10 text-warning rounded-pill">
						<i class="ph-warning p-2"></i>
					</div>
					@break
					@case('piad_installment')
					<div class="bg-warning bg-opacity-10 text-success rounded-pill">
						<i class="ph-currency-circle-dollar  p-2"></i>
					</div>
					@break
					
					@default
					<div class="bg-warning bg-opacity-10 text-warning rounded-pill">
						<i class="ph-circle-wavy-warning   p-2"></i>
					</div>
					@endswitch
					
				</div>
				<div class="flex-1">
					 {{ $notification['data']['content'] }} <a href="{{ $notification['data']['url'] }}"> تفاصيل </a> 
					<div class="fs-sm text-muted mt-1"> {{ $notification->created_at->diffForHumans() }} </div>
				</div>
			</div>
		</div>
		@endforeach



		

	</div>
</div>