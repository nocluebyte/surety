<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Proposal;
use Carbon\Carbon;

class BondStatusChange extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:BondStatusChange';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $today = Carbon::now()->format('Y-m-d');
        $proposal = Proposal::where('bond_end_date', '<', $today)->get();

        foreach ($proposal as $item) {
            $item->status = 'Expired';
            $item->save();
        }
    }
}
