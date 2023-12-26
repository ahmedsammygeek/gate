<div class="row">
    @if ($installments)
           <div class="col-lg-12">
    <br>
    <br>


    <div class="alert alert-warning alert-dismissible fade show">
        <span class="fw-semibold"> لا يوجد اقساط حاليا للعرض داخل الكورس !</span> 
        
    </div>


</div>    @else
    <div class="col-md-12 mt-2">
        <div class="card">

            <div class="table-responsive">
                <table class="table text-nowrap">
                    <thead>
                        <tr>
                            <th > قيمه القسط </th>
                            <th >  عدد الايم قبل المطالبه </th>
                            <th class="text-center" style="width: 20px;">خصائص</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($installments as $installment)
                        <tr>
                            <td>
                                {{ $installment->amount }} <span class='text-muted' > ريال </span>
                            </td>
                            <td>
                                {{ $installment->days }} <span class='text-muted' > يوم بعد عمليه الشراء </span>
                            </td>
                            <td class="text-center">
                                <a  href="{{ route('board.courses.installments.show'  , ['course' => $course , 'installment' => $installment ] ) }}"  class="btn btn-sm btn-primary  ">
                                    <i class="icon-eye "></i>
                                </a>
                                <a href="{{ route('board.courses.installments.edit'  ,['course' => $course , 'installment' => $installment ] ) }}"  class="btn btn-sm btn-warning ">
                                    <i class="icon-database-edit2  "></i>
                                </a>
                                <a data-item_id='{{ $installment->id }}' class="btn btn-danger btn-sm delete_item">
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
