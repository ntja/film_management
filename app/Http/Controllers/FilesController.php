<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;
use App\Repositories\Util\LogRepository;
use App\Repositories\Custom\UserCustom;
use Validator;
use Route;

class FilesController extends Controller {

    public function __construct() {
        
    }

    /*
     *upload file
     */

	public function uploadImage(Request $request) {
		try {
			$destinationPath = public_path() . DIRECTORY_SEPARATOR ."uploads". DIRECTORY_SEPARATOR . "images". DIRECTORY_SEPARATOR;
			$images = $request->only('image')['image'];
			//var_dump($images);die();
			$old_image = $request->only('old_image')["old_image"];
			//var_dump($images);die();
			if(!is_array($images)){
				$this->validate($request, [
					'image' => 'required|image|mimes:jpeg,jpg,JPG,png,gif,svg|max:2048',
				]);
			}
			if($images){
				if(is_array($images)){
					//die("here");
					$file_names = array();
					for($i=0; $i<count($images); $i++){
						$image = $images[$i];
						$extension = $images[$i]->getClientOriginalExtension();
						$original_name = $images[$i]->getClientOriginalName();
						$photo_name = sha1(time() . time().$original_name) . ".{$extension}";
						$file_name =  "uploads". DIRECTORY_SEPARATOR . "images". DIRECTORY_SEPARATOR . $photo_name;
						$image->move($destinationPath, $file_name);
						$file_names[] = $file_name;
					}
					$result = array("code" => 200, "file_name" => $file_names);
					return response()->json($result, 200);
				}elseif ($request->hasFile('image')) {
					$image = $request->file('image');
					if($image->isValid()) {
						$extension = $image->getClientOriginalExtension();
						$original_name = $image->getClientOriginalName();
						$photo_name = sha1(time() . time().$original_name) . ".{$extension}";
						$file_name = "uploads". DIRECTORY_SEPARATOR . "images". DIRECTORY_SEPARATOR . $photo_name;
						$image->move($destinationPath, $file_name);
						$result = array("code" => 200, "file_name" => $file_name);
						if($old_image){
							$file = public_path() . DIRECTORY_SEPARATOR .$old_image;
							//var_dump($file);die();
							if($file){
								File::delete($file);
							}
						}
						return response()->json($result, 200);
					}
				}else {
					$result = "file not found";
					return response()->json($result, 400);
				}
			}
		} catch (Exception $ex) {
			LogRepo::printLog('error', $ex->getMessage());
			$result = "Validation failed";
			return response()->json($result, 400);
			//die();
		}
	}
}
