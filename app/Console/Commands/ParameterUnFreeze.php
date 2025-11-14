<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\{CasesBondLimitStrategy, CasesLimitStrategy, UtilizedLimitStrategys};
use DB;
use Log;

class ParameterUnFreeze extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ParameterUnFreeze';

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
        DB::beginTransaction();

        try {
            
             $cases_bond_limit_strategies_utilized_limits = UtilizedLimitStrategys::with('strategyable')->where(['strategyable_type' => 'CasesBondLimitStrategy'])
            ->where('is_last_of_approved',0)
            ->where('decision_status', 'Approved')
            // ->where('bond_end_date','<',now())
            ->get();


            if (isset($cases_bond_limit_strategies_utilized_limits)) {


                $proposal_codes = $cases_bond_limit_strategies_utilized_limits->pluck('proposal_code');

                $max_of_utilized_approved = UtilizedLimitStrategys::select(DB::raw('MAX(id) as id'))->whereIn('proposal_code', $proposal_codes)
                    ->where(['strategyable_type' => 'CasesBondLimitStrategy'])
                    ->where('decision_status', 'Approved')
                    ->groupBy('proposal_code')
                    ->pluck('id');

                UtilizedLimitStrategys::where(['strategyable_type' => 'CasesBondLimitStrategy'])
                ->whereIn('proposal_code', $proposal_codes)
                    ->update([
                        'is_last_of_approved' => NULL
                    ]);


                UtilizedLimitStrategys::whereIn('id', $max_of_utilized_approved)->update([
                    'is_last_of_approved' => 0
                ]);


                foreach ($cases_bond_limit_strategies_utilized_limits as $cases_bond_limit_strategies_utilized_limit) {

                    $bond_limit_strategy =  CasesBondLimitStrategy::firstWhere([
                        'cases_action_plan_id'=>$cases_bond_limit_strategies_utilized_limit->strategyable->cases_action_plan_id,
                        'bond_type_id'=>$cases_bond_limit_strategies_utilized_limit->strategyable->bond_type_id,
                        'is_current'=>0
                    ]);

                    $bond_current_cap = $bond_limit_strategy->bond_current_cap;
                    $bond_utilized_cap = $bond_limit_strategy->utilizedlimitTopOfApproved($cases_bond_limit_strategies_utilized_limit->strategyable->bond_type_id)->sum('value');


                    $bond_utilized_cap_persontage = safe_divide($bond_utilized_cap * 100, $bond_current_cap);
                    $bond_remaining_cap = $bond_current_cap - $bond_utilized_cap;
                    $bond_remaining_cap_persontage = safe_divide($bond_remaining_cap * 100, $bond_current_cap);

                    $bond_limit_strategy->update([
                        'bond_utilized_cap' => $bond_utilized_cap,
                        'bond_utilized_cap_persontage' => $bond_utilized_cap_persontage,
                        'bond_remaining_cap' => $bond_remaining_cap,
                        'bond_remaining_cap_persontage' => $bond_remaining_cap_persontage
                    ]);
                }

        }

        DB::commit();

        } catch (\Throwable $th) {
            DB::rollBack();
            Log::info('Exception in ParameterUnFreeze : '.$th);
        }
    }
}
