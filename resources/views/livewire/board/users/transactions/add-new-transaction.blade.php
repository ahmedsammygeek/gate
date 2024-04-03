<div>
    <a type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal_form_vertical"  style="float: left;margin-left:2px ; ">
        إضافه تحويل بنكى  <i style='margin-left:2px;' class="icon-plus3 "></i>
    </a>

    <div id="modal_form_vertical" wire:ignore.self class="modal fade" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"> إضافه تحويل بنكى للمستخدم </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <form   wire:submit.prevent="saveTransaction">
                    <div class="modal-body">
                        <div class="mb-3">
                            <div class="row">
                                <div class="col-sm-6">
                                    <label class="form-label"> عمليه الشراء التابع لها التحويل </label>
                                    <select wire:model='purchase_id' class='form-control'>
                                        <option value=""></option>
                                        @foreach ($purchases as $purchase)
                                        <option value="{{ $purchase->id }}"> {{ $purchase->purchase_number }} - {{ $purchase->total }} ريال </option>
                                        @endforeach
                                    </select>
                                    @error('purchase_id')
                                    <p class='text-danger' > {{ $message }} </p>
                                    @enderror
                                </div>
                                <div class="col-sm-6">
                                    <label class="form-label"> تاريخ التحويل </label>
                                    <input type="date" wire:model='payment_date' class="form-control">
                                    @error('payment_date')
                                    <p class='text-danger' > {{ $message }} </p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="row">
                                <div class="col-sm-6">
                                    <label class="form-label"> المبلغ </label>
                                    <input type="number" wire:model='amount' class="form-control">
                                    @error('payment_date')
                                    <p class='text-danger' > {{ $message }} </p>
                                    @enderror
                                </div>

                                <div class="col-sm-6">
                                    <label class="form-label"> صوره التحويل </label>
                                    <input type="file" wire:model='file' class="form-control">
                                    @error('file')
                                    <p class='text-danger' > {{ $message }} </p>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="form-label"> الرقم المرجعى للتحويل </label>
                                    <input type="text" wire:model='transaction_number' class="form-control">
                                    @error('transaction_number')
                                    <p class='text-danger' > {{ $message }} </p>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 mt-2">
                                    <label class="form-label"> تفعيل الكورس </label>
                                    <div class="form-check form-switch mb-2">
                                        <input type="checkbox" class="form-check-input" id="sc_ls_c" wire:model='allowed' >
                                        <label class="form-check-label" for="sc_ls_c"> </label>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-link" data-bs-dismiss="modal"> اغلاق </button>
                        <button type="submit" class="btn btn-primary"> إضافه </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


@section('scripts')

<script>
        // 
    $(function() {
        Noty.overrideDefaults({
            theme: 'limitless',
            layout: 'topLeft',
            type: 'alert',
            timeout: 2500
        });


        Livewire.on('transactionAdded', () => {
            $(document).find('#modal_form_vertical').modal('hide');
            new Noty({
                text: 'تم إضافه التحويل بنجاح',
                type: 'info'
            }).show();
        })
    });
</script>
@endsection