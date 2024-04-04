<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-primary">
                <h5 class="mb-0 text-white">عرض كافه تحويلات المدربين </h5>
            </div>

            <div class="card-body">
                <div class="d-sm-flex align-items-sm-start">
                    <div class="dropdown ms-sm-3  mb-sm-0">
                        <select wire:model='transfer_type' class="form-select">
                            <option value=""> جملع طرق الدفع </option>
                            <option value="1">  تحويل بنكى  </option>
                            <option value="2"> paypal  </option>
                            <option value="3"> فودافون كاش  </option>
                        </select>
                    </div>
                    <div class="dropdown ms-sm-3  mb-sm-0">
                        <select wire:model='trainer_id' class="form-select">
                            <option value=""> جملع المدربين </option>
                            @foreach ($trainers as $trainer)
                            <option value="{{ $trainer->id }}"> {{ $trainer->name }} </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="dropdown ms-sm-3  mb-sm-0">
                        <select wire:model='course_id' class="form-select">
                            <option value=""> جملع الكورسات </option>
                            @foreach ($this->courses as $course)
                            <option value="{{ $course->id }}"> {{ $course->title }} </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="dropdown ms-sm-3  mb-sm-0">
                        <input type="date"  wire:model='transfer_date'  class='form-control'>
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
                        <button wire:loading.attr="disabled"  wire:click='resetFilters' type="button" class="btn btn-flat-primary btn-labeled btn-labeled-start">
                            <span  class="btn-labeled-icon bg-primary text-white">
                                <i class="icon-reset"></i>
                            </span>
                            إعاده ضبط الفلتر
                        </button>
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


                </div>
            </div>

            <div class="table-responsive">
                <table class="table text-nowrap">
                    <thead>
                        @if (count($transfers))
                        <tr>
                            <th > المدرب </th>
                            <th > الكورس </th>
                            <th >  قيمه المبلغ </th>
                            <th > تاريخ التحويل </th>
                            <th >  طريقه التحويل  </th>
                            <th >  تم اضافه التحويل بواسطه </th>
                            <th class="text-center" style="width: 20px;">خصائص</th>
                        </tr>
                        @endif
                    </thead>
                    <tbody>
                        @if (count($transfers))
                        @foreach ($transfers as $transfer)
                        <tr>
                            <td> {{ $transfer->trainer?->name }} </td>
                            <td> {{ $transfer->course?->title }} </td>
                            <td> {{ $transfer->amount }} </td>
                            <td> {{ $transfer->transfer_date }} </td>
                            <td> 
                                @switch($transfer->transfer_type)
                                @case(1)
                                <span class='badge bg-primary' > تحويل بنكى</span>
                                @break
                                @case(2)
                                <span class='badge bg-success' > paypal</span>
                                @break
                                @case(3)
                                <span class='badge bg-info' >فودافون كاش </span>
                                @break
                                @endswitch
                            </td>
                            <td> {{ $transfer->user?->name }} </td>

                            <td class="text-center">
                                @can('trainers_transfers.show')
                                   <a  href="{{ route('board.trainers_transfers.show'  , $transfer ) }}"  class="btn btn-sm btn-primary  ">
                                    <i class="icon-eye  "></i>
                                </a>
                                @endcan

                                @can('trainers_transfers.edit')
                                   <a  href="{{ route('board.trainers_transfers.edit'  , $transfer ) }}"  class="btn btn-sm btn-warning  ">
                                    <i class="icon-database-edit2 "></i>
                                </a>
                                @endcan

                                @can('trainers_transfers.delete')
                                <a data-item_id='{{ $transfer->id }}' class="btn btn-danger btn-sm delete_item">
                                    <i class="icon-trash  "></i>
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
                {{ $transfers->links() }}
            </div>
        </div>
    </div>
</div>



@section('scripts')

<script src="{{ asset('board_assets/js/vendor/media/glightbox.min.js') }}"></script>
<script src="{{ asset('board_assets/js/vendor/notifications/sweet_alert.min.js') }}"></script>
<script src="{{ asset('board_assets/demo/pages/gallery.js') }}"></script>
<script>
    $(function() {

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
