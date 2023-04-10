$today = Carbon::now()->format('Y-m-d');
            $data = AppoinmentModel::when($request->date != null,function($query) use ($request){
                return $query->whereDate('created_at',$request->date);
            }, function($query) use ($today){
                $query->whereDate('created_at',$today);
            })
            ->when($request->select != null, function ($query) use ($request){
                return $query->where('status',$request->select);
            })
            ->where('appointment_type',1)
            ->paginate(10)
            ->withQueryString();
