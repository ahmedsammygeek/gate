<div class="row">


    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-primary">
                <h5 class="mb-0 text-white"> تقرير فحص الاشتراكات </h5>
            </div>

            <div class="card-body">
                <div class="d-sm-flex align-items-sm-start">

                    <div class="dropdown ms-sm-3  mb-sm-0">
                        <select wire:model='is_paid_status' class="form-select">
                            <option value="all"> جملع الحلات الشراء </option>
                            <option value="1"> تم الدفع بشكل كامل </option>
                            <option value="2"> تم الدفع بشكل جزءى </option>
                            <option value="3"> لم يتم الدفع </option>
                        </select>
                    </div>
                    <div class="dropdown ms-sm-3  mb-sm-0">
                        <input type="date"  wire:model='due_date'  class='form-control'>
                    </div>
                    <div class=" ms-sm-3  mb-sm-0">
                        <button wire:loading.attr="disabled" wire:click='resetFilters' type="button" class="btn btn-flat-primary btn-labeled btn-labeled-start">
                            <span  class="btn-labeled-icon bg-primary text-white">
                                <i class="icon-reset"></i>
                            </span>
                            إعادة ضبط الفلتر
                        </button>
                    </div>

                    <div class=" ms-sm-3  mb-sm-0">
                        <button wire:loading.attr="disabled"  wire:click='excelSheet' type="button" class="btn btn-flat-primary btn-labeled btn-labeled-start ">
                            <span  class="btn-labeled-icon bg-primary text-white">
                                <i class="icon-file-excel "></i>
                            </span>
                            Excel
                        </button>
                    </div>

                    <div class=" ms-sm-3  mb-sm-0">
                        <button wire:loading.attr="disabled"  wire:click='lockUsers' type="button" class="btn btn-flat-primary btn-labeled btn-labeled-start ">
                            <span  class="btn-labeled-icon bg-primary text-white">
                                <i class="icon-lock"></i>
                            </span>
                            remove access
                        </button>
                    </div>

                    <div class=" ms-sm-3  mb-sm-0">
                        <button wire:loading.attr="disabled"  wire:click='unLockUsers' type="button" class="btn btn-flat-primary btn-labeled btn-labeled-start ">
                            <span  class="btn-labeled-icon bg-primary text-white">
                                <i class="icon-lock"></i>
                            </span>
                            Allow access
                        </button>
                    </div>
                    
                    <div class="dropdown ms-sm-3 mb-3 mb-sm-0">


                        <select wire:model='rows' class="form-select">
                            <option value="5"> 5 صف للعرض</option>
                            <option value="30">30 صف للعرض</option>
                            <option value="60">60 صف للعرض </option>
                            <option value="90">90 صف للعرض </option>
                            <option value="120">120 صف للعرض </option>
                            <option value="150">150 صف للعرض </option>
                        </select>
                    </div>
                </div>
                <div class="d-sm-flex align-items-sm-start mt-2">
                 


                </div>
            </div>

            <div class="table-responsive">
                <table class="table text-nowrap">
                    <thead>
                        @if (count($purchases))
                        <tr>
                            <th >  الطالب  </th>
                            <th > رقم الواتس </th>
                            <th >  الاميل </th>
                            <th >  رقم الطالب  </th>
                            <th >  اسم الكورس  </th>
                            <th >  الدكتور  </th>
                            <th >  الجامعه  </th>
                            <th >  تاريخ الاستحقاق  </th>
                            <th >  قيمه الاشتراك  </th>
                            <th >  المدفوع  </th>
                            <th >  المتبقى  </th>
                            <th >  الحاله  </th>
                            <th >  
                                <input type="checkbox" wire:model='selectAll' class="form-check-input" id="cc_ls_c1" >
                            </th>
                        </tr>
                        @endif
                    </thead>
                    <tbody>
                       @if (count($purchases))
                       @foreach ($purchases as $purchase)
                       <tr>
                        <td> {{ $purchase->user?->name }} </td>
                        <td> {{ $purchase->user?->phone }} </td>
                        <td> {{ $purchase->user?->email }} </td>
                        <td> {{ $purchase->user?->group_number }} </td>
                        <td> {{ $purchase->item?->course?->title }} </td>
                        <td> {{ $purchase->item?->course?->trainer?->name }} </td>
                        <td> {{ $purchase->item?->course?->university?->title }} </td>
                        <td> {{ $purchase->installments()->where('transaction_id' , null )->first()?->due_date->toDateString() }} </td>
                        <td> {{ $purchase->total }} <span class='text-muted' > ريال </span> </td>
                        <td> {{ $purchase->transactions()->sum('amount') }} <span class='text-muted' > ريال </span> </td>
                        <td> {{ $purchase->total - $purchase->transactions()->sum('amount') }} <span class='text-muted' > ريال </span> </td>
                        <td>
                            @if ($purchase->purchase_status)
                            <span class='badge bg-success' > نشط </span>
                            @else
                            <span class='badge bg-danger' > غير نشط </span>
                            @endif
                        </td>
                        <td>
                            <div class="form-check mb-2">
                                <input type="checkbox" wire:model='selectedPurchases' value="{{ $purchase->id }}" class="form-check-input" id="cc_ls_c" >
                            </div>
                        </td>
                    </tr>
                    @endforeach
                    @else
                    <tr>
                        <td class="text-center text-danger" colspan="5"> لا يوجد بيانات  </td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>

        <div class="card-footer d-flex justify-content-end ">
            {{ $purchases->links() }}
        </div>
    </div>
</div>
</div>


@section('scripts')
<script src="{{ asset('board_assets/js/vendor/media/glightbox.min.js') }}"></script>
<script src="{{ asset('board_assets/js/vendor/notifications/sweet_alert.min.js') }}"></script>
<script src="{{ asset('board_assets/demo/pages/gallery.js') }}"></script>
<script>

    jQuery(document).ready(function($) {
        
        
        Noty.overrideDefaults({
            theme: 'limitless',
            layout: 'topLeft',
            type: 'alert',
            timeout: 2500
        });

        const swalInit = swal.mixin({
            buttonsStyling: false,
            customClass: {
                confirmButton: 'btn btn-primary',
                cancelButton: 'btn btn-light',
                denyButton: 'btn btn-light',
                input: 'form-control'
            }
        });

        Livewire.on('userCourseExpirationDateUpdated', () => {
            new Noty({
              text: 'تم منع الدخول بنجاح',
              type: 'info'
          }).show();
        })
    });


</script>
@endsection
