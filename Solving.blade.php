// Multiple input and Two array insert at a same time

        $test = null;
        $mi = new MultipleIterator();
        $mi->attachIterator(new ArrayIterator($request->value));
        $mi->attachIterator(new ArrayIterator($request->value2));
        foreach ($mi as list($value, $value2) ) {
            MedicineOrder::insert([
                'user_id' => Auth::user()->id,
                'order_id' => $order_id,
                'medicine' => $value,
                'quantity' => $value2,
                'created_at' => Carbon::now(),
            ]);
        }
