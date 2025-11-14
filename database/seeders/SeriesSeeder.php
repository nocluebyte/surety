<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Series;

class SeriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $seriesData = [
            [
                'type'          => "PO",
                'prefix'        => "PO-",
                'next_number'   => 1,
                'suffix'        => "",
            ],
            [
                'type'          => "IC",
                'prefix'        => "IC-",
                'next_number'   => 1,
                'suffix'        => "",
            ],
            [
                'type'          => "PB",
                'prefix'        => "PB-",
                'next_number'   => 1,
                'suffix'        => "",
            ],
            [
                'type'          => "JV",
                'prefix'        => "JV-",
                'next_number'   => 1,
                'suffix'        => "",
            ],
            [
                'type'          => "P",
                'prefix'        => "P-",
                'next_number'   => 1,
                'suffix'        => "",
            ],
            [
                'type'          => "R",
                'prefix'        => "R-",
                'next_number'   => 1,
                'suffix'        => "",
            ],
            [
                'type'          => "QT",
                'prefix'        => "QT-",
                'next_number'   => 1,
                'suffix'        => "",
            ],
            [
                'type'          => "EA",
                'prefix'        => "EA-",
                'next_number'   => 1,
                'suffix'        => "",
            ],
            [
                'type'          => "EL",
                'prefix'        => "EL-",
                'next_number'   => 1,
                'suffix'        => "",
            ],
            [
                'type'          => "PRN",
                'prefix'        => "PRN-",
                'next_number'   => 1,
                'suffix'        => "",
            ],
            [
                'type'          => "RRN",
                'prefix'        => "RRN-",
                'next_number'   => 1,
                'suffix'        => "",
            ],
            [
                'type'          => "PDC",
                'prefix'        => "PDC-",
                'next_number'   => 1,
                'suffix'        => "",
            ],
            [
                'type'          => "TP",
                'prefix'        => "TP-",
                'next_number'   => 1,
                'suffix'        => "",
            ],
            [
                'type'          => "EV",
                'prefix'        => "EV-",
                'next_number'   => 1,
                'suffix'        => "",
            ],
            [
                'type'          => "IPO",
                'prefix'        => "IPO-",
                'next_number'   => 1,
                'suffix'        => "",
            ],
            [
                'type'          => "IIC",
                'prefix'        => "IIC-",
                'next_number'   => 1,
                'suffix'        => "",
            ],
            [
                'type'          => "FI",
                'prefix'        => "FI-",
                'next_number'   => 1,
                'suffix'        => "",
            ],
            [
                'type'          => "FR",
                'prefix'        => "FR-",
                'next_number'   => 1,
                'suffix'        => "",
            ],
            [
                'type'          => "SO",
                'prefix'        => "SO-",
                'next_number'   => 1,
                'suffix'        => "",
            ],
            [
                'type'          => "PRO",
                'prefix'        => "PRO-",
                'next_number'   => 1,
                'suffix'        => "",
            ],
            [
                'type'          => "CNWOS",
                'prefix'        => "CNWOS-",
                'next_number'   => 1,
                'suffix'        => "",
            ],
            [
                'type'          => "DNWOS",
                'prefix'        => "DNWOS-",
                'next_number'   => 1,
                'suffix'        => "",
            ],
            [
                'type'          => "OC",
                'prefix'        => "OC-",
                'next_number'   => 1,
                'suffix'        => "",
            ],
            [
                'type'          => "RFG",
                'prefix'        => "RFG-",
                'next_number'   => 1,
                'suffix'        => "",
            ],
            [
                'type'          => "SR",
                'prefix'        => "SR-",
                'next_number'   => 1,
                'suffix'        => "",
            ],
            [
                'type'          => "CN",
                'prefix'        => "CN-",
                'next_number'   => 1,
                'suffix'        => "",
            ],
            [
                'type'          => "WT",
                'prefix'        => "WT/",
                'next_number'   => 1,
                'suffix'        => "",
            ],
            [
                'type'          => "JWOC",
                'prefix'        => "JWOC/",
                'next_number'   => 1,
                'suffix'        => "",
            ],
            [
                'type'          => "JI",
                'prefix'        => "JI/",
                'next_number'   => 1,
                'suffix'        => "",
            ],
            [
                'type'          => "JWIC",
                'prefix'        => "JWIC/",
                'next_number'   => 1,
                'suffix'        => "",
            ],
            [
                'type'          => "JR",
                'prefix'        => "JR/",
                'next_number'   => 1,
                'suffix'        => "",
            ],
        ];

        foreach ($seriesData as $data) {
            $series = Series::where('type', $data['type'])->first();
            if (!$series) {
                $series = new Series();
                $series->type           = $data['type'];
                $series->prefix         = $data['prefix'];
                $series->next_number    = $data['next_number'];
                $series->suffix         = $data['suffix'];
                $series->save();
            }
        }
    }
}
