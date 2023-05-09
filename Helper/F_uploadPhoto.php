<?php
use Intervention\Image\ImageManagerStatic as Image;
class Photo{
    //Return Value
    public static $name;
    function __construct()
    {
        echo ' hi';
    }
    //Image Upload Methods
    public static function upload($file,$path,$prefix,$size=[]){
        if (file_exists(public_path($path))) {
            try {
                $extention = $file->getClientOriginalExtension();
                $name = $prefix.rand(1,2000).rand(1,500).'-'.date('dmy').'.'.$extention; //Name generator
                if(count($size) != 2){ //Check size exists
                    Image::make($file)->save(public_path($path.'/'.$name));
                }else{
                    Image::make($file)->resize($size[0],$size[1])->save(public_path($path.'/'.$name));
                }
                self::$name = $name;// get Last upload Name
                return true;
                }
            catch (\Throwable $th) {
                return false;
                }
        }else {
          return false;
        }
    }

}
?>




