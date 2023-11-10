<div class="row">
    <div class="col-md-12 mt-2">
        <div class="card">

            <div class="table-responsive">
                <table class="table text-nowrap">
                    <thead>
                        <tr>
                            <th > اسم الكورس </th>
                            <th >  تاريخ الاضافه </th>
                            <th >  تم الاضافه بواسطه </th>
                            <th class="text-center" style="width: 20px;">خصائص</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($courses as $one_course)
                        <tr>
                            <td>
                                <a href="{{ route('board.courses.show' , $one_course->sub_course_id ) }}"> {{ $one_course->subCourse?->title }} </a>
                            </td>
                            <td>
                                {{ $one_course->created_at }} <span class='text-muted' >  {{ $one_course->created_at->diffForHumans() }} </span>
                            </td>
                            <td>
                                <a href="{{ route('board.admins.show' , $one_course->user_id ) }}">  {{ $one_course->user?->name }}  </a>
                            </td>
                            <td class="text-center">
                                <a data-item_id='{{ $one_course->id }}' class="btn btn-danger btn-sm delete_item">
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
