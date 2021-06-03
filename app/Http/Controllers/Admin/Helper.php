<?php 


namespace App\Http\Controllers\Admin;
use App\Models\Activity;

class Helper{
  public static function printlog($message)
  {
      Activity::create(['user_id' => auth()->user()->id, 'action' => $message]);
  }

  public static function removeFile($file)
  {
     if (file_exists($file)) {
        unlink($file);
      }
  }
}
