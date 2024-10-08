<div>
    @if (count($user_courses))
    <div class="col-md-12">
        <div class="card">


            <div class="table-responsive">
                <table class="table text-nowrap">
                    <thead>
                        <tr>
                            <th></th>
                            <th > اسم </th>
                            <th > النوع </th>
                            <th> تاريخ الانضمام </th>
                            <th> متاحه حتى تاريخ </th>
                            <th> نسبه اكمال الدوره </th>
                            <th> مفعل </th>
                            <th class="text-center" style="width: 20px;">خصائص</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($user_courses as $user_course)
                        <tr>
                            <td>
                                {{ $user_course->id }}
                            </td>
                            <td class="pe-0">
                                @switch($user_course->course_type)
                                @case(1)
                                <a href="{{ route('board.courses.show' , $user_course->course_id ) }}">
                                    {{ $user_course->course?->title }}
                                </a>
                                @break
                                @case(2)
                                <a href="{{ route('board.packages.show' , $user_course->course_id ) }}">
                                    {{ $user_course->course?->title }}
                                </a>
                            

                                @break
                                @endswitch

                                
                            </td>
                            <td class="pe-0">
                                @switch($user_course->course_type)
                                @case(1)
                                <span class='badge bg-primary' > كورس </span>
                                @break
                                @case(2)
                                <span class='badge bg-success'> باقه </span>
                                @break
                                @endswitch
                            </td>
                            <td> 
                                {{ $user_course->created_at->toDateString() }}
                                <span class='text-muted' > {{ $user_course->created_at->diffForHumans() }} </span>
                            </td>
                            <td> 
                                {{ $user_course->expires_at->toDateString() }}
                                <span class='text-muted' > {{ $user_course->expires_at->diffForHumans() }} </span>
                            </td>

                            <td> <span class='badge bg-info'> {{ $user_course->progress }} % </span>  </td>

                            <td>
                                @switch($user_course->allowed)
                                @case(1)
                                <span class='badge bg-success' > مفعل </span>
                                @break
                                @case(0)
                                <span class='badge bg-danger'> غير مفعل </span>
                                @break
                                @endswitch
                            </td>


                            <td class="text-center">
                                <a data-item_id='{{ $user_course->id }}' class="btn btn-warning btn-sm edit_item">
                                    <i class="icon-calendar22 "></i>
                                </a>
                                <a data-item_id='{{ $user_course->id }}'  class="btn btn-danger btn-sm delete_item">
                                    <i class="icon-trash  "></i>
                                </a>
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
            <span class="fw-semibold"> لا يوجد كورسات حاليا للمستخدم  </span> 
        </div>
    </div>
    @endif

    <div id="modal_form_vertical" wire:ignore.self class="modal fade" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"> تعديل الكورس للطالب </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <form wire:submit.prevent="changeExpirationDateTo" >
                    <div class="modal-body">
                        <div class="mb-3">
                            <div class="row">
                                <div class="col-sm-12">
                                    <label class="form-label"> تعديل تاريخ الانتهاء الى  </label>
                                    <input type="date" wire:model='expires_at' placeholder="Kopyov" class="form-control">
                                    @error('expires_at')
                                    <p class='text-danger'> {{ $message }} </p>
                                    @enderror
                                </div>
                                <div class="col-sm-12">
                                    <label class="form-label"> تفعيل الكورس  </label> <br>
                                    <div class="form-check form-switch mb-2">
                                        <input type="checkbox" class="form-check-input" id="sc_ls_c" wire:model='allowed' {{ $allowed == 1 ? 'checked' : ''  }}>
                                        <label class="form-check-label" for="sc_ls_c"> نعم </label>
                                    </div>
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
        Livewire.on('userCourseExpirationDateUpdated', () => {
            $(document).find('#modal_form_vertical').modal('hide');
            new Noty({
                text: 'تم تعديل التاريخ بنجاح',
                type: 'info'
            }).show();
        })


        $(document).on('click', 'a.edit_item', function(event) {
            event.preventDefault();
            var item_id = $(this).attr('data-item_id');
            Livewire.emit('setItemIDTo' , item_id );
            $(document).find('#modal_form_vertical').modal('show');
        });


        $(document).on('click', 'a.delete_item', function(event) {
            event.preventDefault();
            var item_id = $(this).attr('data-item_id');
            swalInit.fire({
                title: 'تاكيد الحذف',
                text: "هل انت متاكد من رغبتك فى حذف الدوره للطالب  ؟",
                icon: 'danger',
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