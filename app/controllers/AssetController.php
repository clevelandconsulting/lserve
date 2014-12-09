<?php

class AssetController extends BaseController {
	
	public function getPrivateAsset($path) {
    // if the user is not logged in, return a 404 error
    if (!Auth::check()) {
        App::abort(404);
        return;
    }

    // build the file path
    $file= sprintf("%s/private/%s", base_path(), $path);
    //echo $file;
    //return;
    // if the file requested does not exist, return a 404 error
    if (!file_exists($file)) {
      App::abort(404);
      return;
    }

    // use your favorite mime checker here
    // for illustrative purposes a simple mime checker follows:
    $type = pathinfo($file)['extension'];

    $mime = null;

    switch ($type) {
      case 'html' :
        $mime = 'text/html';
        break;
      case 'js' :
      case 'json' :
        $mime = 'text/javascript';
        break;
      case 'css' :
        $mime = 'text/css';
        break;
      case 'png' :
        $mime = 'image/png';
        break;
    }

    $headers = [];

    // set the Content-type header
    if ($mime) {
      $headers['Content-Type'] = $mime;  
    }

    // set any other cache headers you may need for your static resources
    // $headers['whatever'] = 'whatever'; 

    // return the file as output with 200 success code
    return Response::make(file_get_contents($file), 200, $headers);
 }
 
 }