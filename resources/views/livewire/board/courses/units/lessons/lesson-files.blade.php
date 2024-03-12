<div class="col-md-12">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0"> ملفات الدرس </h5>
        </div>

        <div class='card-body'>
            <table class='table table-responsive  '>
                <thead>
                    <tr>
                        <th> # </th>
                        <th> اسم الملف </th>
                        <th>  تاريخ الاضافه </th>
                        <th>  تم الاضافه بواسطه </th>
                        <th>  خصائص </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($files as $file)
                    <tr>
                        <td> {{ $loop->index + 1 }} </td>
                        <td> {{ $file->file_name }} </td>
                        <td> {{ $file->created_at->diffForHumans() }} </td>
                        <td> {{ $file->user?->name }} </td>
                        <td> 
                            <a target="_blank"  href="{{ Storage::url('lesson_files/'.$file->file) }}"  class="btn btn-sm btn-primary  ">
                                <i class="icon-eye  "></i>
                            </a>

                            <a data-item_id='{{ $file->id }}' class="btn btn-danger btn-sm delete_item">
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
                text: "هل انت متاكد من رغبتك فى حذف الملف ؟",
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