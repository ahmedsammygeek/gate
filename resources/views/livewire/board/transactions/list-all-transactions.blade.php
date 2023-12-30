<div class="row">


    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-primary">
                <h5 class="mb-0 text-white">عرض كافه  المعاملات الماليه</h5>
            </div>

            <div class="card-body">
                <div class="d-sm-flex align-items-sm-start">
                    <div class="form-control-feedback form-control-feedback-start flex-grow-1 mb-3 mb-sm-0">
                        <input type="text" wire:model='search' class="form-control" placeholder="البحث داخل المعاملات الماليه">
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
                        <select wire:model='payment_method' class="form-select">
                            <option value=""> جملع طرق الدفع </option>
                            <option value="cashe"> كاش  </option>
                            <option value="bank_transfer"> تحويل بنكى  </option>
                            <option value="my_fatoorah"> ماى فاتوره  </option>
                            <option value="bank_misr"> بنك مصر  </option>
                        </select>
                    </div>
                    <div class="dropdown ms-sm-3  mb-sm-0">
                        <input type="date"  wire:model='payment_date'  class='form-control'>
                    </div>

                </div>
            </div>

            <div class="table-responsive">
                <table class="table text-nowrap">
                    <thead>
                        @if (count($transactions))
                           <tr>
                            <th > رقم المعامله  </th>
                            <th > المستخدم </th>
                            <th >  قيمه المعامله </th>
                            <th >  تاريخ المعامله  </th>
                            <th >  طريقه الدفع  </th>
                            <th class="text-center" style="width: 20px;">خصائص</th>
                        </tr>
                        @endif
                    </thead>
                    <tbody>
                       @if (count($transactions))
                           @foreach ($transactions as $transaction)
                        <tr>
                            <td> {{ $transaction->payment_id }} </td>
                            <td> <a href="{{ route('board.users.show' , $transaction->user_id ) }}"> {{ $transaction->user?->name }} </a> </td>
                            
                            <td> {{ $transaction->amount }} <span class='text-muted' >  ريال سعودى </span> </td>
                            <td> {{ $transaction->payment_date }}  </td>

                            <td>
                                @switch($transaction->payment_method)
                                @case('cashe')
                                <span class='badge bg-warning' > كاش </span>
                                @break
                                @case('bank_transfer')
                                <span class='badge bg-success' > تحويل بنكى </span>
                                @break
                                 @case('my_fatoorah')
                                <span class='badge bg-primary' > ماى فاتوره </span>
                                @break
                                 @case('bank_misr')
                                <span class='badge bg-info' > بنك مصر </span>
                                @break
                                @endswitch
                            </td>
                            <td class="text-center">
                                <a  href="{{ route('board.transactions.show'  , $transaction ) }}"  class="btn btn-sm btn-primary  ">
                                    <i class="icon-eye  "></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                        @else
                        <tr>
                            <td class="text-center text-danger" colspan="5"> لا يوجد بيانات  </td>
                        </tr>
                       @endif
                    </tbody>
                </table>
            </div>

            <div class="card-footer d-flex justify-content-end ">
                {{ $transactions->links() }}
            </div>
        </div>
    </div>
</div>

