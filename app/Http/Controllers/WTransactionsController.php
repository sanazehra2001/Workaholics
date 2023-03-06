<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\wTransactions;
use App\Models\Milestone;
use App\Models\Job;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class WTransactionsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        # $in_escrow = Milestone::where('');
        $sender_trans = wTransactions::leftjoin('users', 'sender_id', '=', 'users.id')
            ->leftjoin('milestones', 'milestones.id', '=', 'milestone_id')
            ->leftjoin('jobs', 'jobs.id', '=', 'milestones.job_id')
            ->select('wtransactions.*', 'jobs.id as jobID', 'milestones.id as mID')
            ->get();

        $receiver_trans = wTransactions::leftjoin('users', 'receiver_id', '=', 'users.id')
            ->leftjoin('milestones', 'milestones.id', '=', 'milestone_id')
            ->leftjoin('jobs', 'jobs.id', '=', 'milestones.job_id')
            ->select('wtransactions.*', 'jobs.id as jobID', 'milestones.id as mID', 'users.name as name')
            ->get();

        return view('payments.index', ["senderT" => $sender_trans, "receiverT" => $receiver_trans]);
    }

    public function create()
    {
        return view('wTransactions.addToWallet.index');
    }

    public function store()
    {
        $wTransactions = new wTransactions();
        $wTransactions->user_id = request('user_id');
        $wTransactions->type = request('type');
        $wTransactions->account_name = request('account_name');
        $wTransactions->account_number = request('account_number');
        $wTransactions->save();
        return redirect()->route('WTransactions.index');
    }

    public function show($id)
    {
        $user = User::find(Auth::id());
        $spent_transactions = wTransactions::where('sender_id', '=', Auth::id())->get();
        $received_transactions = wTransactions::where('receiver_id', '=', Auth::id())->get();
        $jobs = Job::where('employer');
        #$escrow =

        return view('WTransactions.show', ['spent_transactions' => $spent_transactions, 'received_transactions' => $received_transactions, 'wallet' => $user['wallet']]);
    }

    public function edit($id)
    {
        $wTransactions = wTransactions::find($id);
        return view('WTransactions.edit', ['wTransactions' => $wTransactions]);
    }

    public function update($id)
    {
        $wTransactions = wTransactions::find($id);
        $wTransactions->user_id = request('user_id');
        $wTransactions->type = request('type');
        $wTransactions->account_name = request('account_name');
        $wTransactions->account_number = request('account_number');
        $wTransactions->save();
        return redirect()->route('WTransactions.index');
    }

    public function destroy($id)
    {
        $wTransactions = wTransactions::find($id);
        $wTransactions->delete();
        return redirect()->route('WTransactions.index');
    }
}
