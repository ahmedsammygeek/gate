<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-primary">
                <h5 class="mb-0 text-white"> شاشاه اشتراكات الكورسات </h5>
            </div>

            <div class="card-body">
                <div class="d-sm-flex align-items-sm-start">
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
                        <label for=""> تاريخ الاشتراك (من) : </label>
                        <input type="date"  wire:model='start_date' class='form-control'>
                    </div>
                    <div class=" ms-sm-3  mb-sm-0">
                        <label for=""> تاريخ الاشتراك (الى) : </label>
                        <input type="date"  wire:model='end_date'  class='form-control'>
                    </div>

                    <div class="dropdown ms-sm-3  mb-sm-0">
                        <label for=""> الجامعه : </label>
                        <select wire:model='university_id' class="form-select">
                            <option value=""> جميع الجامعات  </option>
                            @foreach ($universities as $university)
                                <option value="{{ $university->id }}">  {{ $university->title }} </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="dropdown ms-sm-3  mb-sm-0">
                        <label for=""> الكورس : </label>
                        <select wire:model='course_id' class="form-select">
                            <option value=""> جميع الكورسات :  </option>
                            @foreach ($courses as $course)
                                <option value="{{ $course->id }}">  {{ $course->title }} </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="dropdown ms-sm-3  mb-sm-0">
                        <label for=""> المدرب  : </label>
                        <select wire:model='trainer_id' class="form-select">
                            <option value=""> جميع المدربين  </option>
                            @foreach ($trainers as $trainer)
                                <option value="{{ $trainer->id }}">  {{ $trainer->name }} </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- <div class="dropdown ms-sm-3  mb-sm-0">
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
                    </div> --}}
                   
                    <div class=" ms-sm-3  mb-sm-0">
                        <label> خصائص </label> <br>
                        <button wire:loading.attr="disabled"  wire:click='resetFilters' type="button" class="btn btn-flat-primary btn-labeled btn-labeled-start ">
                            <span  class="btn-labeled-icon bg-primary text-white">
                                <i class="icon-reset"></i>
                            </span>
                            إعادة ضبط الفلتر
                        </button>
                    </div>

                    <div class=" ms-sm-3  mb-sm-0">
                        <label> خصائص </label> <br>
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
                            <th > الكورس </th>
                            <th > الجامعه </th>
                            <th >  الدكتور </th>
                            <th >  الطالب  </th>
                            <th >  تاريخ الاشتراك  </th>
                            <th >  طريقه الدفع  </th>
                            <th >  المبلغ (وقت الطلب)  </th>
                            <th >  رقم الطلب  </th>
                            <th >  المدفوع  </th>
                            <th >  المتبقى  </th>
                        </tr>
                        @endif
                    </thead>
                    <tbody>
                        @if (count($purchases))
                        @foreach ($purchases as $purchase)
                        <tr>
                            <td> {{ $purchase->item?->course?->title  }} </td>
                            <td> {{ $purchase->item?->course?->university?->title  }} </td>
                            <td> {{ $purchase->item?->course?->trainer?->name  }} </td>
                            <td> {{ $purchase->item?->course?->user?->name  }} </td>
                            <td> {{ $purchase->created_at->toDateString()  }} </td>
                            <td> {{ $purchase->order?->paymentTypeAsText()  }} </td>
                            <td> {{ $purchase->total  }} </td>
                            <td> {{ $purchase->purchase_number  }} </td>
                            <td> {{ $purchase->transactions()->sum('amount') }} <span class='text-muted' > ريال </span> </td>
                            <td> {{ $purchase->total - $purchase->transactions()->sum('amount') }} <span class='text-muted' > ريال </span> </td>
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
<script src="{{ Storage::url('board_assets/js/vendor/notifications/sweet_alert.min.js') }}"></script>
<script src="{{ asset('board_assets/js/vendor/media/glightbox.min.js') }}"></script>
<script src="{{ asset('board_assets/js/vendor/notifications/sweet_alert.min.js') }}"></script>
<script src="{{ asset('board_assets/demo/pages/gallery.js') }}"></script>
<script>
    $(function() {


        

        // Livewire.on('statusChanged', () => {
        //     $(document).find('#modal_form_vertical').modal('hide');
        //     new Noty({
        //         text: 'تم تعديل بنجاح',
        //         type: 'info'
        //     }).show();
        // })


        // Livewire.on('openModal', () => {
        //     $(document).find('#modal_form_vertical').modal('show');
        // })


        // Noty.overrideDefaults({
        //     theme: 'limitless',
        //     layout: 'topLeft',
        //     type: 'alert',
        //     timeout: 2500
        // });

        // const swalInit = swal.mixin({
        //     buttonsStyling: false,
        //     customClass: {
        //         confirmButton: 'btn btn-primary',
        //         cancelButton: 'btn btn-light',
        //         denyButton: 'btn btn-light',
        //         input: 'form-control'
        //     }
        // });

        // Livewire.on('itemDeleted', () => {
        //     new Noty({
        //       text: 'تم الحذف بنجاح',
        //       type: 'info'
        //   }).show();
        // })



        // $(document).on('click', 'a.delete_item', function(event) {
        //     event.preventDefault();
        //     var item_id = $(this).attr('data-item_id');
        //     swalInit.fire({
        //         title: 'تاكيد الحذف',
        //         text: "هل انت متاكد من رغبتك فى حذف العنصر ؟",
        //         icon: 'warning',
        //         showCancelButton: true,
        //         confirmButtonText: 'نعم',
        //         cancelButtonText: 'تراجع',
        //         buttonsStyling: false,
        //         customClass: {
        //             confirmButton: 'btn btn-danger',
        //             cancelButton: 'btn btn-success'
        //         }
        //     }).then(function(result) {
        //         if(result.value) {
        //             Livewire.emit('deleteItem' , item_id );
        //         }
        //     });

        // });

    });
</script>
@endsection
