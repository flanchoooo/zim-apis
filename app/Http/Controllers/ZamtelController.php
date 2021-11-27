<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use App\Models\Hit;
use App\Models\Transaction;
use Carbon\Carbon;
use Ramsey\Uuid\Uuid;

class ZamtelController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function balance($id){
        return $agent = Agent::where('agent_code', $id)->first();
    }

    public function topup($id, $amount){
         $agent = Agent::where('agent_code', $id)->first();
         if(!isset($agent)){
            return response()->json(['status' => 'error', 'message' => 'Agent not found']);
         }
         $agent->balance += $amount;
         $agent->save();

         $rrn = Uuid::uuid4()->toString();
         $transaction = new Transaction ();
         $transaction->id = $rrn;
         $transaction->agent = $agent->name;
         $transaction->amount = $amount;
         $transaction->type = '';
         $transaction->rrn = $rrn;
         $transaction->reversed = false;
         $transaction->save();
         return response()->json(['status' => 'success', 'message' => 'Topup successful', 'balance' => $agent->balance, 'rrn' => $rrn]);

    }

    public function reversal($id){
        $transaction = Transaction::where('rrn', $id)->first();
        if(!isset($transaction)){
            return response()->json(['status' => 'error', 'message' => 'Transaction not found']);
        }

        if($transaction->reversed){
            return response()->json(['status' => 'error', 'message' => 'Transaction already reversed']);
        }

        Agent::where('name', $transaction->agent)->decrement('balance', $transaction->amount);
        $transaction->reversed = true;
        $transaction->type=  'topup_reversed';
        $transaction->save();
        return response()->json(['status' => 'success', 'message' => 'Reversal successful', 'rrn' => $transaction->rrn]);
    }

   public function transaction(){
        $transactions = Transaction::all();
        return response()->json(['status' => 'success', 'message' => 'Transaction successful', 'transactions' => $transactions]);
   }

}
