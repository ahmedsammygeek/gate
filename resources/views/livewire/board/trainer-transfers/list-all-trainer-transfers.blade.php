<div class="row">


    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-primary">
                <h5 class="mb-0 text-white">عرض كافه تحويلات المدربين </h5>
            </div>

            <div class="card-body">
                <div class="d-sm-flex align-items-sm-start">
<div class="dropdown ms-sm-3  mb-sm-0">
                        <select wire:model='transfer_type' class="form-select">
                            <option value=""> جملع طرق الدفع </option>
                            <option value="1">  تحويل بنكى  </option>
                            <option value="2"> paypal  </option>
                            <option value="3"> فودافون كاش  </option>
                        </select>
                    </div>
                    <div class="dropdown ms-sm-3  mb-sm-0">
                        <input type="date"  wire:model='transfer_date'  class='form-control'>
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
                        @if (count($transfers))
                        <tr>
                            <th > المدرب </th>
                            <th > الكورس </th>
                            <th >  قيمه المبلغ </th>
                            <th >  طريقه التحويل  </th>
                            <th >  تم اضافه التحويل بواسطه </th>
                            <th class="text-center" style="width: 20px;">خصائص</th>
                        </tr>
                        @endif
                    </thead>
                    <tbody>
                     @if (count($transfers))
                     @foreach ($transfers as $transfer)
                     <tr>
                        <td> {{ $transfer->trainer?->name }} </td>
                        <td> {{ $transfer->course?->title }} </td>
                        <td> {{ $transfer->amount }} </td>
                        <td> 
                            @switch($transfer->transfer_type)
                            @case(1)
                            <span class='badge bg-primary' > تحويل بنكى</span>
                            @break
                            @case(2)
                            <span class='badge bg-success' > paypal</span>
                            @break
                            @case(3)
                            <span class='badge bg-info' >فودافون كاش </span>
                            @break
                            @endswitch

                        </td>
                        <td> {{ $transfer->user?->name }} </td>

                        <td class="text-center">
                            <a  href="{{ route('board.trainers_transfers.show'  , $transfer ) }}"  class="btn btn-sm btn-primary  ">
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
            {{ $transfers->links() }}
        </div>
    </div>
</div>
</div>

