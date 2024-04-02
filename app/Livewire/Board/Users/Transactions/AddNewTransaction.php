<?php

namespace App\Livewire\Board\Users\Transactions;

use Livewire\Component;
use App\Models\Purchase;
use App\Models\Transaction;
use Livewire\WithFileUploads;
use Auth;
class AddNewTransaction extends Component
{
    use WithFileUploads;
    public $user;
    public $file;
    public $amount;
    public $purchase_id;
    public $payment_date;
    public $transaction_number;

    protected $rules = [
        'file' => 'nullable',
        'amount' => 'required',
        'purchase_id' => 'required',
        'payment_date' => 'required',
        'transaction_number' => 'nullable',
    ];

    protected $messages = [
        'file.required' => 'صوره التحويل مطلوبه',
        'amount.required' => 'قيمه التحويل مطلوبه',
        'purchase_id.required' => 'عمليه الشراء مطلوبه',
        'payment_date.required' => 'تاريخ الدفع مطلوب',
        'transaction_number.required' => 'الرقم المرجعى مطلوب',
    ];

    public function saveTransaction()
    {
        $this->validate();
        $transaction = new Transaction;
        $transaction->payment_id = $this->transaction_number;
        $transaction->user_id = $this->user->id;
        $transaction->amount = $this->amount;
        $transaction->payment_date = $this->payment_date;
        $transaction->purchase_id = $this->purchase_id;
        $transaction->added_by = Auth::id();
        if ($this->file) {
            $transaction->image = basename($this->file->store('transactions'));
        }
        $transaction->payment_method = Transaction::BANK_TRANSFER; 
        $transaction->save();


        $purchase = Purchase::find($this->purchase_id);

        if ($purchase) {

            $purchase_transactions_total_amount = Transaction::where('purchase_id', $this->purchase_id )->sum('amount');

            if ( $purchase_transactions_total_amount >= $purchase->total ) {
                $purchase->is_paid = 2;
            } else {
                $purchase->is_paid = 1;
            }
                $purchase->save();

        }



        $this->emit('transactionAdded');
        $this->emitTo('board.users.list-all-user-transactions' , 'transactionAdded' );
        $this->amount = null;
        $this->payment_date = null;
        $this->purchase_id = null;
        $this->image = null;
        $this->transaction_number = null;
    }

    public function render()
    {
        $purchases = Purchase::where('user_id' , $this->user->id )->get();
        return view('livewire.board.users.transactions.add-new-transaction' , compact('purchases') );
    }
}
