<?php

namespace App\Helpers;

use App\Model\Admin;
use View;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Schema;
use PHPMailer;
use DateTime;

class FrontHelper {

     // $maxWidth = FrontHelper::$resizeDimentions[$type][0];
     //  $maxHeight = FrontHelper::$resizeDimentions[$type][1];
   private static $fileBasePaths = array('profile' => 'public/images/profile/','report' => 'public/images/report/','logo'=>'public/images/','badge' => 'public/images/profile/','template' => 'public/pdf/template/','location' => 'public/pdf/location/','ba' => 'public/images/ba/');
   private static $resizeDimentions = array("profile" => [130, 130],'logo'=>[185,60],"badge" => [130, 130],"report"=>[480,800]);

   public static $months = ['01'=>'january','02'=>'february','03'=>'march','04'=>'april','05'=>'may','06'=>'june','07'=>'july','08'=>'august','09'=>'september','10'=>'october','11'=>'november','12'=>'december'];

   public static function getBaseURL() {
      return \Illuminate\Support\Facades\URL::to("");
   }

   public static function getFavicon() {
      //return GeneralSetting::first();
   }

   public static function createHandle($string) {
      return strtolower(preg_replace('/[^A-Za-z0-9-]+/', '-', $string));
   }

   public static function getPath($path) {
      return base_path() . '/' . $path;
   }

   public static function generatePassword($length = 8, $add_dashes = false, $available_sets = 'luds') {
      $sets = array();
      if (strpos($available_sets, 'l') !== false)
         $sets[] = 'abcdefghjkmnpqrstuvwxyz';
      if (strpos($available_sets, 'u') !== false)
         $sets[] = 'ABCDEFGHJKMNPQRSTUVWXYZ';
      if (strpos($available_sets, 'd') !== false)
         $sets[] = '23456789';
      if (strpos($available_sets, 's') !== false)
         $sets[] = '!@#$%&*?';
      $all = '';
      $password = '';
      foreach ($sets as $set) {
         $password .= $set[array_rand(str_split($set))];
         $all .= $set;
      }
      $all = str_split($all);
      for ($i = 0; $i < $length - count($sets); $i++)
         $password .= $all[array_rand($all)];
      $password = str_shuffle($password);
      if (!$add_dashes)
         return $password;
      $dash_len = floor(sqrt($length));
      $dash_str = '';
      while (strlen($password) > $dash_len) {
         $dash_str .= substr($password, 0, $dash_len) . '-';
         $password = substr($password, $dash_len);
      }
      $dash_str .= $password;
      return $dash_str;
   }

   public static function saveUploadedFile($uploadedFile, $typeOfUpload, $oldFile = null) {
      $filePath = self::$fileBasePaths[$typeOfUpload];
      $destinationPath = self::getPath($filePath);
      // $oldFile = $filePath.$oldFile;
      // var_dump(self::getPath($oldFile),$destinationPath);die();
      $fileName = rand(10000, 1000000000) . '-' . str_replace(' ', '', $uploadedFile->getClientOriginalName());

      if (!empty($oldFile)) {
         $oldfile = $filePath.$oldFile;
         // Storage::delete(self::getPath($oldFile));
         $filepath = public_path().'/images/profile/'.$oldFile;

         //var_dump($filepath);die();
         if(file_exists(self::getPath($oldfile)))
         {
           unlink($filepath);
         }
      }
      // var_dump(self::getPath($filePath));die();
      $uploadedFile->move($destinationPath, $fileName);
      // if ($typeOfUpload == 'profile' || $typeOfUpload == 'badge') {
      if ($typeOfUpload == 'report') {

      FrontHelper::resizeQAImage($destinationPath . $fileName, $destinationPath . $fileName, $typeOfUpload);
      }
      return  $fileName;
   }
   public static function saveBAUploadedFile($uploadedFile, $typeOfUpload, $oldFile = null) {
      $filePath = self::$fileBasePaths[$typeOfUpload];
      $destinationPath = self::getPath($filePath);
      // $oldFile = $filePath.$oldFile;
      // var_dump(self::getPath($oldFile),$destinationPath);die();
      $fileName = rand(10000, 1000000000) . '-' . str_replace(' ', '', $uploadedFile->getClientOriginalName());

      if (!empty($oldFile)) {
         $oldfile = $filePath.$oldFile;
         // Storage::delete(self::getPath($oldFile));
         $filepath = public_path().'/images/profile/'.$oldFile;

         //var_dump($filepath);die();
         if(file_exists(self::getPath($oldfile)))
         {
           unlink($filepath);
         }
      }
      $uploadedFile->move($destinationPath, $fileName);
      $source = $destinationPath . $fileName;
      $destination = $destinationPath . $fileName;

      $image = new SimpleImage();
      $maxWidth = FrontHelper::$resizeDimentions['report'][0];
      $maxHeight = FrontHelper::$resizeDimentions['report'][1];
      $image->fromFile($source)
              ->autoOrient()                        // adjust orientation based on exif data
              ->bestFit($maxWidth, $maxHeight)      // proportinoally resize to fit inside a 250x400 box              
              ->toFile($destination, 'image/jpeg', 90); 

      return  $fileName;
   }

   public static function resizeImage($source, $destination, $type, $quality = 90) {
      $image = new SimpleImage();
      $maxWidth = FrontHelper::$resizeDimentions[$type][0];
      $maxHeight = FrontHelper::$resizeDimentions[$type][1];
      $image->fromFile($source)
              ->autoOrient()                        // adjust orientation based on exif data
              ->bestFit($maxWidth, $maxHeight)      // proportinoally resize to fit inside a 250x400 box              
              ->toFile($destination, 'image/jpeg', $quality);  // output to the screen
   }

   
   public static function saveFileFromBase64($string, $typeOfUpload) {
      $filePath = self::$fileBasePaths[$typeOfUpload];
      $destinationPath = self::getPath($filePath);
      $fileName = rand(10000, 1000000000) . '-' . rand(10000, 1000000000) . '.jpg';

      $file = explode(',', $string, 2)[1];
      $img = str_replace(' ', '+', $file);
      $data = base64_decode($img);

      file_put_contents($destinationPath . $fileName, $data);
      if ($typeOfUpload == 'property') {
         FrontHelper::resizeImage($destinationPath . $fileName, $destinationPath . $fileName, $typeOfUpload);
      }
      return $filePath . $fileName;
   }

   public static function saveFileFromURL($url, $typeOfUpload) {
      $filePath = self::$fileBasePaths[$typeOfUpload];
      $destinationPath = self::getPath($filePath);
      $fileName = rand(10000, 1000000000) . '-' . rand(10000, 1000000000) . '.jpg';
      $content = file_get_contents($url);

      file_put_contents($destinationPath . $fileName, $content);

      if ($typeOfUpload == 'property') {
         FrontHelper::resizeImage($destinationPath . $fileName, $destinationPath . $fileName, $typeOfUpload);
      }

      return $filePath . $fileName;
   }

   public static function createThumbFromImage($path) {
      $filePath = base_path() . "/" . $path;
      $destPath = self::$fileBasePaths["property_thumb"];
      $destination = self::getPath($destPath);
      $fileName = rand(10000, 1000000000) . '-' . rand(10000, 1000000000) . '.jpg';
      try {
         FrontHelper::resizeImage($filePath, $destination . $fileName, "property_thumb");
      } catch (Exception $e) {
         echo $e->getMessage();
      }
      return $destPath . $fileName;
   }

   public static function time_since($time) {
      $since = time() - $time;
      $chunks = array(
          array(60 * 60 * 24 * 365, 'year'),
          array(60 * 60 * 24 * 30, 'month'),
          array(60 * 60 * 24 * 7, 'week'),
          array(60 * 60 * 24, 'day'),
          array(60 * 60, 'hour'),
          array(60, 'minute'),
          array(1, 'second')
      );

      for ($i = 0, $j = count($chunks); $i < $j; $i++) {
         $seconds = $chunks[$i][0];
         $name = $chunks[$i][1];
         if (($count = floor($since / $seconds)) != 0) {
            break;
         }
      }

      return array('count' => $count, 'unit' => $name);
   }
   
   public static function getNumberFormat($value=''){
      return number_format($value, 2, '.', ',');
   }    


   public static function removeNULL($input) {
      $return = array();
      foreach ($input as $key => $val) {
         if (is_array($val)) {
            $return[$key] = self::removeNULL($val);
         } else {
            if ($val === NULL) {
               $return[$key] = "";
            } else {
               $return[$key] = $val;
            }
         }
      }
      return $return;
   }


   public static function push_notification_android($device_id,$message,$title,$type){

      $url = 'https://fcm.googleapis.com/fcm/send';

      /*api_key available in:
      Firebase Console -> Project Settings -> CLOUD MESSAGING -> Server key*/    
      $api_key = 'AAAAvpCE3DY:APA91bH7YFeH81pUnPLqsQXKcLK7wxZCRUS6-OR7yNUc9mbqnUxA7aUIV1IU68qYdXUdxgxy5CqNfs-suAV3Dvw-GDKigar5apjl8XIlqXEJIBkVGKX19UDCeM1zlXTNvPYJlFAnPyJZ';
                  
        $fields = array
            (
            'to' => $device_id,
            'data' => array (
                  "message" => $message,
                  "title"=> $title,
                  "type"=>$type

          )
        );
      //header includes Content type and api key
      $headers = array(
          'Content-Type:application/json',
          'Authorization:key='.$api_key
      );
                  
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, $url);
      curl_setopt($ch, CURLOPT_POST, true);
      curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
      curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
      $result = curl_exec($ch);
      if ($result === FALSE) {
          die('FCM Send Error: ' . curl_error($ch));
      }
      curl_close($ch);
      return $result;


  }


  public static function push_notification_ios($device_id,$message,$title,$type='')
  {

      $key = 'AAAAvpCE3DY:APA91bH7YFeH81pUnPLqsQXKcLK7wxZCRUS6-OR7yNUc9mbqnUxA7aUIV1IU68qYdXUdxgxy5CqNfs-suAV3Dvw-GDKigar5apjl8XIlqXEJIBkVGKX19UDCeM1zlXTNvPYJlFAnPyJZ';

      $ch = curl_init("https://fcm.googleapis.com/fcm/send");

      //The device token.
      //$token = "cU0ximrklNw:APA91bECLHjmJ3ZwJ-yhz29aLuGzoo0usbT3E1o4wOZ_Dd-WiXajOhP0w2RgMAl3vc9xkn2UgDBLJW3bYBNh781ewbVwUOWt1W3OHuCwPaPpmaztWTKCp11MAgZbnd--dApCtb-PeIJN"; //token here

      $token = "cU0ximrklNw:APA91bECLHjmJ3ZwJ-yhz29aLuGzoo0usbT3E1o4wOZ_Dd-WiXajOhP0w2RgMAl3vc9xkn2UgDBLJW3bYBNh781ewbVwUOWt1W3OHuCwPaPpmaztWTKCp11MAgZbnd--dApCtb-PeIJN";

      //Title of the Notification.
      //$title = "New BA Added";

      //Body of the Notification.
      $body = "";

      //Creating the notification array.
      $notification = array('title' =>$title , 'text' => $message);

      //This array contains, the token and the notification. The 'to' attribute stores the token.
      $arrayToSend = array('to' => $device_id, 'notification' => $notification,'priority'=>'high');

      //Generating JSON encoded string form the above array.
      $json = json_encode($arrayToSend);
      //Setup headers:
      $headers = array();
      $headers[] = 'Content-Type: application/json';
      $headers[] =  'Authorization:key='.$key;

      //Setup curl, add headers and post parameters.
      curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
      curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
      curl_setopt($ch, CURLOPT_HTTPHEADER,$headers);       
      curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
      //Send the request
      $response = curl_exec($ch);

      //Close request
      curl_close($ch);

      // var_dump($response);
      return $response;

  }

  public static function user_check($data){
        //var_dump($data);die();

        $responseArr = [];
        $whereArr=[];

        $whereArr[] = ['email','=', $data['email']];
        $whereArr[] = ['deleted_at','!=',null];

        $admin = Admin::where($whereArr)->orderBy('id', 'desc')->first();

        if(!empty($admin)){

            $responseArr['status']=false;

        } else {

            $responseArr['status']=true;
            
        }

        return $responseArr;

  }

  public static function addColumn($table,$column,$after=''){
    \DB::statement("ALTER TABLE $table CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
      Schema::table($table, function($table1) use ($table,$column,$after)
      {
        if (!Schema::hasColumn($table, $column)){
          if(!empty($after)){
            if (Schema::hasColumn($table, $after))
            {
                $table1->text($column)->after($after)->nullable();
            }else{
              $table1->text($column)->nullable();
            }

          }else{
            $table1->text($column)->nullable();
          }
        }
          
      });
  }

  public static function updateColumn($table,$oldCol,$newCol,$after=''){
    \DB::statement("ALTER TABLE $table CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
      Schema::table($table, function($table1) use ($table,$oldCol, $newCol, $after)
      {
        if (Schema::hasColumn($table, $oldCol)){

          $table1->renameColumn($oldCol, $newCol);
        }
          
      });
  }

  public static function dropColumn($table,$col){
    Schema::table($table, function($table1) use ($col)
    {
        $table->dropColumn($col);
    });
  }

  public static function addLanguageColumn($table,$column,$after='',$dataType){
    //var_dump("ALTER TABLE $table ADD $column $dataType AFTER $after");
    \DB::statement("ALTER TABLE $table CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
      Schema::table($table, function($table1) use ($table,$column,$after,$dataType)
      {
        if (!Schema::hasColumn($table, $column)){
          if(!empty($after)){
            //$table1->text($column)->after($after)->nullable();
            \DB::statement("ALTER TABLE $table ADD $column $dataType AFTER $after");
          }else{
            //$table1->text($column)->nullable();
            \DB::statement("ALTER TABLE $table ADD $column $dataType");
          }
        }
          
      });
  }

  public static function updateLanguageColumn($table,$oldCol,$newCol,$dataType){
    \DB::statement("ALTER TABLE $table CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
      Schema::table($table, function($table1) use ($table,$oldCol, $newCol, $dataType)
      {
        if (Schema::hasColumn($table, $oldCol)){
          \DB::statement("ALTER TABLE $table CHANGE $oldCol $newCol $dataType");
        }
          
      });
  }

  //Function for build tree structure
  public static function buildtree($src_arr, $parent_id = 0, $tree = array())
  {
      foreach($src_arr as $idx => $row)
      {
          if($row['edp_ParentId'] == $parent_id)
          {
              foreach($row as $k => $v)
              $tree[$row['pkEdp']][$k] = $v;
              unset($src_arr[$idx]);
              $tree[$row['pkEdp']]['children'] = FrontHelper::buildtree($src_arr, $row['pkEdp']);
          }
      }
      ksort($tree);
      return $tree;
  }

}

?>