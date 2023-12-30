<div class="row">
    @if (count($package_courses))
        <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="d-sm-flex align-items-sm-start">
                    <div class="form-control-feedback form-control-feedback-start flex-grow-1 mb-3 mb-sm-0">
                        <input type="text" wire:model='search' class="form-control" placeholder="البحث داخل الباقات">
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
                </div>
            </div>

            <div class="table-responsive">
                <table class="table text-nowrap">
                    <thead>
                        <tr>
                            <th> صوره الكورس </th>
                            <th> اسم الكورس </th>
                            <th>  التصنيف </th>
                            <th>  الجامعه </th>
                            <th>  تم الاضافه بواسطه </th>
                            <th class="text-center" style="width: 20px;">خصائص</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($package_courses as $package_course)
                        <tr>
                            <td class="pe-0">
                                <div class="col-sm-6 col-lg-9">
                                    <div class="card">
                                        <div class="card-img-actions m-1">
                                            <a href="{{ Storage::url('courses/'.$package_course->subCourse?->image) }}"
                                                class="btn btn-outline-white btn-icon rounded-pill"
                                                data-bs-popup="lightbox" data-gallery="gallery1">
                                                <img src="{{ Storage::url('courses/'.$package_course->subCourse?->image) }}"
                                                class="card-img " width="60" height="60" alt="">
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <td class="text-wrap">
                                <a href="{{ route('board.courses.show', $package_course->subCourse?->id) }}" class="d-block fw-semibold">
                                    {{ Str::limit($package_course->subCourse?->title, 30, '.....') }}</a>
                                    <span class="fs-sm text-muted">{{ $package_course->created_at->toFormattedDateString() }}</span>
                                </td>

                                <td>
                                    @if ($package_course->subCourse?->category_id)
                                    <a href="{{ route('board.categories.show' , $package_course->subCourse?->category_id ) }}"> {{ $package_course->subCourse?->category?->name }} </a>
                                    @endif
                                </td>
                                <td>
                                    @if ($package_course->subCourse?->university_id)
                                    <a href="{{ route('board.universities.show' , $package_course->subCourse?->university_id ) }}"> {{ $package_course->subCourse?->university?->title }} </a>
                                    @endif
                                </td>
                                <td>
                                    @if ($package_course->user_id)
                                    <a href="{{ route('board.admins.show' , $package_course->user_id ) }}"> {{ $package_course->user?->name }} </a>
                                    @endif
                                </td>

                                <td class="text-center">
                               {{--  @can('packages.add')
                                <a  href="{{ route('board.packages.show'  , $package ) }}"  class="btn btn-sm btn-primary  ">
                                    <i class="icon-eye  "></i>
                                </a>
                                @endcan --}}
                                @can('packages.delete')
                                <a data-item_id='{{ $package_course->id }}' class="btn btn-danger btn-sm delete_item">
                                    <i class="icon-trash  "></i>
                                </a>
                                @endcan
                            </td>

                        </tr>
                        @endforeach



                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @else
    <div class="col-lg-12">
        <br>
        <br>
        <div class="alert alert-warning alert-dismissible fade show">
            <span class="fw-semibold"> لا يوجد كورسات داخل الباقه حتى الان !</span> 
        </div>
    </div>   
    @endif
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
                text: "هل انت متاكد من رغبتك فى حذف الكورس من داخل الباقه ?",
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



