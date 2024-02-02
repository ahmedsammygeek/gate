<div>

    @if (count($user->installments))
       <div class="col-md-12">
        <div class="card">


            <div class="table-responsive">
                <table class="table text-nowrap">
                    <thead>
                        <tr>
                            <th> رقم القسط </th>
                            <th> تاريخ الاستحقاق </th>
                            <th> المبلغ </th>
                            <th>  حاله القسط </th>
                            <th class="text-center" style="width: 20px;">خصائص</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($user->installments as $user_installment)
                        <tr>
                            <td>
                                {{ $user_installment->installment_number }}
                            </td>
                            <td> {{ $user_installment->due_date->toDateString() }} - {{ $user_installment->due_date->diffForHumans() }} </td>
                           
                            <td> {{ $user_installment->amount }} <span>  ريال </span> </td>
                            <td> 
                                @switch($user_installment->status)
                                @case(1)
                                <span class='badge bg-info' > مدفوع </span>
                                @break
                               
                                @case(0)
                                <span class='badge bg-dark' > غير مدفوع  </span>
                                @break
                                @endswitch
                            </td> 
                            <td class="text-center">
                                <a  href="{{ route('board.installments.show' , $user_installment->id ) }}"  class="btn btn-primary btn-sm">
                                    <i class="icon-eye"></i>
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
        <span class="fw-semibold"> لا يوجد اقساط للعرض  حاليا </span> 
    </div>
</div>
    @endif
    
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