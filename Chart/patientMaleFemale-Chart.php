<?php
function dashboard(){
        //ApexChart Filtering Data
        $patientHistory = DB::table('appoinment_models')->select(
            DB::raw('DATE_FORMAT(created_at, "%M") as month'),
            DB::raw('COUNT(gender) as total'),
            DB::raw('SUM(CASE WHEN gender = "male" THEN 1 ELSE 0 END) as male'),
            DB::raw('SUM(CASE WHEN gender = "female" THEN 1 ELSE 0 END) as female'))
            ->whereYear('created_at',2023)
            ->orderBy('created_at','ASC')
            ->groupBy('month')
            ->get();

        $chart_data = [];
        foreach($patientHistory as $data) {
            $chart_data[] = [
                'month' => $data->month,
                'male' => $data->male,
                'female' => $data->female
            ];
        }
        $chart = [
            'chart' => [
                'type' => 'bar',
                'height' => 350
            ],
            'series' => [
                [
                    'name' => 'Male',
                    'data' => array_column($chart_data, 'male')
                ],
                [
                    'name' => 'Female',
                    'data' => array_column($chart_data, 'female')
                 ]
            ],
            'xaxis' => [
                'categories' => array_column($chart_data, 'month')
            ]
        ];
        // Other Redirection Variables would be here |
        //Type here.....


        return view('backend.index',[
            'data' => json_encode($chart),
        ]);
    }