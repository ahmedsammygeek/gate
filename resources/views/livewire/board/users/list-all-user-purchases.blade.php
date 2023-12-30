<div>
    @if (count($user->purchases))
       <div class="col-md-12">
        <div class="card">
            <div class="table-responsive">
                <table class="table text-nowrap">
                    <thead>
                        <tr>
                            <th > رقم العمليه </th>
                            <th> تاريخ العمليه </th>
                            <th> المبلغ الفرعى </th>
                            <th> المبلغ الكلى </th>
                            <th> هل تم الدفع </th>
                            <th> نو علميه الشراء </th>
                            <th class="text-center" style="width: 20px;">خصائص</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($user->purchases as $user_purchase)
                        <tr>
                            <td>
                                {{ $user_purchase->purchase_number }}
                            </td>
                            <td> 
                                {{ $user_purchase->created_at }}
                                <span class='text-muted' > {{ $user_purchase->created_at->diffForHumans() }} </span>
                            </td>
                            <td> {{ $user_purchase->subtotal }} <span>  ريال </span> </td>
                            <td> {{ $user_purchase->total }} <span>  ريال </span> </td>
                            <td> 
                                @switch($user_purchase->is_paid)
                                @case(0)
                                <span class='badge bg-danger' > لم يتم الدفع</span>
                                @break
                                @case(1)
                                <span class='badge bg-success' > تم الدفع بشكل جزئى </span>
                                @break
                                @case(2)
                                <span class='badge bg-primary' > تم الدفع بشكل كامل</span>
                                @break
                                @endswitch
                                
                            </td> 
                            <td> 
                                @switch($user_purchase->purchase_type)
                                @case('one_later_installment')
                                <span class='badge bg-info' > قسط واحد مؤجل </span>
                                @break
                                @case('installments')
                                <span class='badge bg-success' > الدفع على عده اقساط </span>
                                @break
                                @case('total_amount')
                                <span class='badge bg-primary' >  دفع القميه مباشرا </span>
                                @break
                                @endswitch
                                
                            </td>
                            


                            <td class="text-center">
                                <a  href="{{ route('board.purchases.show' , $user_purchase->id ) }}"  class="btn btn-primary btn-sm">
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
        <span class="fw-semibold"> لا يوجد عمليات شراء للعرض  حاليا </span> 
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