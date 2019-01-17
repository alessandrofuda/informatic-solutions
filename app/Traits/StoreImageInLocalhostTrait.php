<?php 

namespace App\Traits; 

use Illuminate\Support\Str;
use Storage;

trait StoreImageInLocalhostTrait { 

    public static function StoreImageInLocalhost($remoteImgUrl, $destinationFolder = 'noStore', $keysearch = 'noKeySpecified') {  
        
        $localhostImgUrl = null;
    	$img = file_get_contents($remoteImgUrl);
    	$imgNameFull = substr($remoteImgUrl, strrpos($remoteImgUrl, '/') + 1);
    	//$imgName = Str::slug(  );
    	$imgExtension = substr($imgNameFull, strrpos($imgNameFull, '.'));
    	$imgName = Str::slug(str_replace($imgExtension, '', $imgNameFull));
    	$imgNameSanitized = $imgName.$imgExtension;

    	// store in /storage/app/public/$destinationFolder
    	$stored = Storage::put('public/'.$keysearch.'/'.$destinationFolder.'/'.$imgNameSanitized, $img, 'public'); // bool

    	if($stored) {
    		$localhostImgUrl = 'storage/'.$keysearch.'/'.$destinationFolder.'/'.$imgNameSanitized;
    	} else {
    		$localhostImgUrl = null;
    	}

    	// importante!
    	// ripulire i vecchi file non più utilizzati
        

        return $localhostImgUrl;
    }

}