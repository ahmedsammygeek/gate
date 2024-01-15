$user_installments = [];
            switch ($order->payment_type) {
                case 'installments':
                $course_installments = $order->course?->installments()->get();
                foreach ($course_installments as $course_installment) {
                    $user_installments[] = new UserInstallments([
                        'user_id' => $order->user_id , 
                        'installment_number' => Str::uuid() , 
                        'course_id' => $order->course_id , 
                        'amount' => $course_installment->amount , 
                        'due_date' => Carbon::today()->addDays($course_installment->days) , 
                        'status' => 0 , 
                        'purchase_id' => $purchase->id , 
                    ]);
                }
                break;
                case 'one_later_installment':
                $user_installments[] = new UserInstallments([
                    'user_id' => $order->user_id , 
                    'installment_number' => Str::uuid() , 
                    'course_id' => $order->course_id , 
                    'amount' => $order->course?->price_later , 
                    'due_date' => Carbon::today()->addDays($order->course?->days) , 
                    'status' => 0 , 
                    'purchase_id' => $purchase->id , 
                ]);
                break;
                default:
                break;
            }
            $order->user->installments()->saveMany($user_installments);