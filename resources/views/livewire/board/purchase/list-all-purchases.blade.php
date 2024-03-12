<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-primary">
                <h5 class="mb-0 text-white">عرض كافه عمليات الشراء</h5>
            </div>

            <div class="card-body">
                <div class="d-sm-flex align-items-sm-start">
                    <div class="form-control-feedback form-control-feedback-start flex-grow-1 mb-3 mb-sm-0">
                        <input type="text" wire:model='search' class="form-control" placeholder="البحث داخل عمليات الشراء">
                        <div class="form-control-feedback-icon">
                            <i class="ph-magnifying-glass"></i>
                        </div>
                    </div>
                    <div class="dropdown ms-sm-3 mb-3 mb-sm-0">
                        <select wire:model='rows' class="form-select">
                            <option value="30">30 صف للعرض</option>
                            <option value="60">60 صف للعرض </option>
                            <option value="90">90 صف للعرض </option>
                            <option value="120">120 صف للعرض </option>
                            <option value="150">150 صف للعرض </option>
                        </select>
                    </div>
                </div>
                <div class="d-sm-flex align-items-sm-start mt-2">

                    <div class="dropdown ms-sm-3  mb-sm-0">
                        <select wire:model='purchase_type' class="form-select">
                            <option value=""> جميع انواع الشراء </option>
                            <option value="one_later_installment">  قسط واحد مؤجل </option>
                            <option value="installments"> اقساط </option>
                            <option value="one_payment"> المبلغ كامل </option>
                        </select>
                    </div>


                    <div class="dropdown ms-sm-3  mb-sm-0">
                        <select wire:model='is_paid' class="form-select">
                            <option value="all"> جملع الحاات </option>
                            <option value="0"> لم يتم الدفع بعد </option>
                            <option value="1"> تم الدفع بشكل جزئى </option>
                            <option value="2"> تم دفع كامل المبلغ </option>
                        </select>
                    </div>
                    <div class="dropdown ms-sm-3  mb-sm-0">
                        <input type="date"  wire:model='start_date'  class='form-control'>
                    </div>
                    <div class=" ms-sm-3  mb-sm-0">
                        <input type="date"  wire:model='end_date'  class='form-control'>
                    </div>
                    <div class=" ms-sm-3  mb-sm-0">
                        <button wire:loading.attr="disabled"  wire:click='resetFilters' type="button" class="btn btn-flat-primary btn-labeled btn-labeled-start ">
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
                </div>
            </div>

            <div class="table-responsive">
                <table class="table text-nowrap">
                    <thead>
                        @if (count($purchases))
                        <tr>
                            <th > رقم عمليه الشراء </th>
                            <th > المستخدم </th>
                            <th >  قيمه عمليه الشراء </th>
                            <th >  نوع عمليه الشراء  </th>
                            <th >  هل تم الدفع  </th>
                            <th class="text-center" style="width: 20px;">خصائص</th>
                        </tr>
                        @endif
                    </thead>
                    <tbody>
                        @if (count($purchases))
                        @foreach ($purchases as $purchase)
                        <tr>
                            <td> {{ $purchase->purchase_number }} </td>
                            <td> <a href="{{ route('board.users.show' , $purchase->user_id ) }}"> {{ $purchase->user?->name }} </a> </td>
                            <td> {{ $purchase->total }} <span class='text-muted' >  ريال سعودى </span> </td>
                            <td> 
                                @switch($purchase->purchase_type)
                                @case('one_later_installment')
                                <span class='badge bg-primary' > قسط واحد مؤجل </span>
                                @break
                                @case('installments')
                                <span class='badge bg-success' > اقساط </span>
                                @break
                                @case('one_payment')
                                <span class='badge bg-info' > المبلغ كامل </span>
                                @break
                                @default
                                @endswitch
                            </td>
                            <td>
                                @switch($purchase->is_paid)
                                @case(0)
                                <span class='badge bg-warning' > لم يتم الدفع بعد </span>
                                @break
                                @case(1)
                                <span class='badge bg-black' > تم الدفع بشكل جزئى </span>
                                @break
                                @case(2)
                                <span class='badge bg-success' > تم دفع كامل المبلغ </span>
                                @break
                                @default
                                @endswitch
                            </td>
                            <td class="text-center">
                                @can('purchases.show')
                                <a  href="{{ route('board.purchases.show'  , $purchase ) }}"  class="btn btn-sm btn-primary  ">
                                    <i class="icon-eye  "></i>
                                </a>

                                <a wire:click='openEditModal({{ $purchase->id }})'  class="btn btn-sm btn-warning  ">
                                    <i class="icon-database-edit2 "></i>
                                </a>
                                @endcan
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

    <div id="modal_form_vertical" wire:ignore.self class="modal fade" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"> تعديل  حاله عمليه الشراء </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <form wire:submit.prevent="changePurchaseStatus" >
                    <div class="modal-body">
                        <div class="mb-3">
                            <div class="row">
                                <div class="col-sm-12">
                                    <label class="form-label">  الحاله   </label>
                                    <select wire:model='is_purchase_paid' class='form-control' >
                                        <option value='0' {{ $is_purchase_paid == 0 ? 'selected="selected"' : '' }}  > لم يتم الدفع </option>
                                        <option value='1' {{ $is_purchase_paid == 1 ? 'selected="selected"' : '' }}  > تم الدفع بشكل جزئ </option>
                                        <option value='2' {{ $is_purchase_paid == 2 ? 'selected="selected"' : '' }}  > تم الدفع بشكل كامل </option>
                                    </select>
                                    @error('is_purchase_paid')
                                    <p class='text-danger'> {{ $message }} </p>
                                    @enderror
                                </div>
                                
                            </div>
                        </div>


                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-link" data-bs-dismiss="modal"> اغلاق </button>
                        <button type="submit" class="btn btn-primary"> حفظ </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@section('scripts')
<script src="{{ Storage::url('board_assets/js/vendor/notifications/sweet_alert.min.js') }}"></script>
<script src="{{ asset('board_assets/js/vendor/media/glightbox.min.js') }}"></script>
<script src="{{ asset('board_assets/js/vendor/notifications/sweet_alert.min.js') }}"></script>
<script src="{{ asset('board_assets/demo/pages/gallery.js') }}"></script>
<script>
    $(function() {


        

        Livewire.on('statusChanged', () => {
            $(document).find('#modal_form_vertical').modal('hide');
            new Noty({
                text: 'تم تعديل بنجاح',
                type: 'info'
            }).show();
        })


        Livewire.on('openModal', () => {
            $(document).find('#modal_form_vertical').modal('show');
        })


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

        Livewire.on('itemDeleted', () => {
            new Noty({
              text: 'تم الحذف بنجاح',
              type: 'info'
          }).show();
        })



        $(document).on('click', 'a.delete_item', function(event) {
            event.preventDefault();
            var item_id = $(this).attr('data-item_id');
            swalInit.fire({
                title: 'تاكيد الحذف',
                text: "هل انت متاكد من رغبتك فى حذف العنصر ؟",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'نعم',
                cancelButtonText: 'تراجع',
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-danger',
                    cancelButton: 'btn btn-success'
                }
            }).then(function(result) {
                if(result.value) {
                    Livewire.emit('deleteItem' , item_id );
                }
            });

        });

    });
</script>
@endsection
