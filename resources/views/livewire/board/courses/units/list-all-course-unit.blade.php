<div class="row">
    <div class="col-md-12">
        <a href="{{ route('board.courses.units.create' , $course ) }}" class="btn btn-primary mb-2" style="float: left;">  <i class="icon-plus3  me-2"></i>  إضافه وحده جديده </a>

        <a href="{{ route('board.courses.show' , $course ) }}" class="btn btn-primary mb-2 " style="float: left;margin-left:10px;">
            <span style='margin-left:10px' > العوده الى الكورس </span>  <i class="icon-arrow-left7"></i>
        </a>

        <a href="{{ route('board.courses.index') }}" class="btn btn-primary mb-2" style="float: left;margin-left:10px;">
            <span style='margin-left:10px' > العوده الى جميع الكورسات </span>  <i class="icon-arrow-left7"></i>
        </a>
    </div>

    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-primary">
                <h5 class="mb-0 text-white">عرض كافه وحدات الكورس : {{ $course->title }}</h5>
            </div>

            <div class="card-body">
                <div class="d-sm-flex align-items-sm-start">
                    <div class="form-control-feedback form-control-feedback-start flex-grow-1 mb-3 mb-sm-0">
                        <input type="text" wire:model='search' class="form-control" placeholder="البحث داخل الوحدات">
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

            </div>

            <div class="table-responsive">
                <table class="table text-nowrap">
                    <thead>
                        <tr>
                            <th > اسم الوحده بالعربيه </th>
                            <th >  عدد الدروس داخل الوحده </th>
                            <th >  السماح بالعرض </th>

                            <th class="text-center" style="width: 20px;">خصائص</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($units as $unit)
                        <tr>
                            <td class="text-wrap">
                                {{ $unit->getTranslation('title' , 'ar' ) }}
                            </td>

                            <td> {{ $unit->lessons()->count() }} </td>
                            <td>
                                @switch($unit->is_active )
                                @case(1)
                                <span class="badge bg-success"> نعم </span>
                                @break
                                @case(0)
                                <span class="badge bg-danger"> لا</span>
                                @break
                                @endswitch
                            </td>


                            <td class="text-center">
                                <a  href="{{ route('board.courses.units.show'  ,  ['course' => $course  , 'unit' => $unit ] ) }}"  class="btn btn-sm btn-primary  ">
                                    <i class="icon-eye  "></i>
                                </a>
                                <a  href="{{ route('board.courses.units.lessons.index'  ,  ['course' => $course  , 'unit' => $unit ] ) }}"  class="btn btn-sm btn-info  ">
                                    <i class="icon-video-camera "></i>
                                </a>
                                <a href="{{ route('board.courses.units.edit'  ,  ['course' => $course  , 'unit' => $unit ] ) }}"  class="btn btn-sm btn-warning ">
                                    <i class="icon-database-edit2  "></i>
                                </a>
                                <a data-item_id='{{ $unit->id }}' class="btn btn-danger btn-sm delete_item">
                                    <i class="icon-trash  "></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach



                    </tbody>
                </table>
            </div>

            <div class="card-footer d-flex justify-content-end ">
                {{ $units->links() }}
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
