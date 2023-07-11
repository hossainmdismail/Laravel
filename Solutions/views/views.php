<?php


$single_blogs = Blog_Posts::find($id);
        $category = Category::select('id','name')->get();

        $key = 'Blog_'.$single_blogs->id;
        if(!session()->has($key)){
            $single_blogs->increment('views');
            session()->put($key,1);
        }

?>