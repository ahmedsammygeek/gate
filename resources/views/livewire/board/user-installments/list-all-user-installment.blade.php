<div class="row">


    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-primary">
                <h5 class="mb-0 text-white">عرض كافه  الاقساط</h5>
            </div>

            <div class="card-body">
                <div class="d-sm-flex align-items-sm-start">
                    <div class="form-control-feedback form-control-feedback-start flex-grow-1 mb-3 mb-sm-0">
                        <input type="text" wire:model='search' class="form-control" placeholder="البحث داخل الاقساط">
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
                    <div class="dropdown ms-sm-3  mb-sm-0">
                        <select wire:model='status' class="form-select">
                            <option value="all"> جملع الحاات الدفع </option>
                            <option value="0"> لم يتم الدفع  </option>
                            <option value="1"> تم الدفع  </option>
                        </select>
                    </div>
                    <div class="dropdown ms-sm-3  mb-sm-0">
                        <select wire:model='due_date_status' class="form-select">
                            <option value="all"> جملع الحلات الاستحقاق </option>
                            <option value="1"> تم تخطى تاريخ الاستحقاق  </option>
                            <option value="2"> لم يتم تخطى تاريخ الاستحقاق  بعد </option>
                            <option value="3"> تاريخ استحقاق اليوم </option>
                        </select>
                    </div>
                    <div class="dropdown ms-sm-3  mb-sm-0">
                        <input type="date"  wire:model='due_date'  class='form-control'>
                    </div>
                    <div class=" ms-sm-3  mb-sm-0">
                        <button wire:loading.attr="disabled"  wire:click='resetFilters' type="button" class="btn btn-flat-primary btn-labeled btn-labeled-start ">
                            <span  class="btn-labeled-icon bg-primary text-white">
                                <i class="icon-reset"></i>
                            </span>
                            إعادة ضبط الفلتر
                        </button>
                    </div>

                    <div class=" ms-sm-3  mb-sm-0">
                        <button wire:loading.attr="disabled"  wire:click='excelSheet' type="button" class="btn btn-flat-primary btn-labeled btn-labeled-start ">
                            <span  class="btn-labeled-icon bg-primary text-white">
                                <i class="icon-file-excel "></i>
                            </span>
                            Excel
                        </button>
                    </div>

                </div>
            </div>

            <div class="table-responsive">
                <table class="table text-nowrap">
                    <thead>
                        <tr>
                            <th > رقم القسط  </th>
                            <th > المستخدم </th>
                            <th >  قيمه القسط </th>
                            <th >  تاريخ الاستحقاق  </th>
                            <th >  هل تم الدفع  </th>
                            <th class="text-center" style="width: 20px;">خصائص</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($installments as $installment)
                        <tr>
                            <td> {{ $installment->installment_number }} </td>
                            <td> <a href="{{ route('board.users.show' , $installment->user_id ) }}"> {{ $installment->user?->name }} </a> </td>
                            
                            <td> {{ $installment->amount }} <span class='text-muted' >  ريال سعودى </span> </td>
                            <td> {{ $installment->due_date->toDateString() }} - <span class='text-muted'> {{ $installment->due_date->diffForHumans() }} </span>  </td>

                            <td>
                                @switch($installment->status)
                                @case(0)
                                <span class='badge bg-danger' > لم يتم الدفع بعد </span>
                                @break
                                @case(1)
                                <span class='badge bg-success' > تم الدفع </span>
                                @break
                                
                                @endswitch
                            </td>
                            <td class="text-center">
                                <a  href="{{ route('board.installments.show'  , $installment ) }}"  class="btn btn-sm btn-primary  ">
                                    <i class="icon-eye  "></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="card-footer d-flex justify-content-end ">
                {{ $installments->links() }}
            </div>
        </div>
    </div>
</div>

