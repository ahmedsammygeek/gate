<div>
 <div class="col-md-12 mt-2">
    <div class="card">

        <div class="table-responsive">
            <table class="table text-nowrap">
                <thead>
                    <tr>
                        <th> رقم القسط </th>
                        <th > قيمه القسط </th>
                        <th >  تاريخ المطالبه بالقسط </th>
                        <th >  حاله الدفع </th>
                        <th class="text-center" style="width: 20px;">خصائص</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($installments as $installment)
                    <tr>
                        <td>
                            {{ $installment->installment_number }} 
                        </td> 
                        <td>
                            {{ $installment->amount }} <span class='text-muted' > ريال </span> 
                        </td>
                        <td>
                            @if ($installment->due_date == Carbon\Carbon::today() )
                            <span class='text-muted'> اليوم </span>
                            @endif
                            @if($installment->due_date >= Carbon\Carbon::today() )
                            {{ $installment->due_date }}
                            @else 
                            {{ $installment->due_date }} <span class='text-muted' > {{ $installment->due_date->diffForHumans() }} </span>
                            @endif
                        </td>
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
                            <a target="_blank" href="{{ route('board.installments.show'  ,  $installment  ) }}"  class="btn btn-sm btn-primary  ">
                                <i class="icon-eye "></i>
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
