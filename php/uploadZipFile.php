<?php

/* uploadZipFile.php 
echo("uploadZipFile.php-Create an interface to allow a user to upload a.zip file of code files for parsing.<br/>

Program will ask for a e-mail address to send back the procressed files as a .zip file.<br/>
- system will create a unique working folder using the session id with a salt<br/>
- system will copy the .zip into this folder and extract the files.<br/>
- system will transverse the extraced files and run them all through the parser system creating a<br/>
 new result folder named as the session id with a key id of the user<br/>
- system will then zip up that folder when it is done parsing the working folder then e-mail<br/>
 the payload back to the user that requested it.<br/>
- system will send link to parsed document folder for display on-line<br/>
- system will request a donation from the user after the work is done.");
*/
echo ("<a href='../index.php'>Return to main menu</a></br></br>");
// Vars for the uploader.
$num_of_uploads=2;//Number of upload boxes to create.
$file_types_array=array("txt","zip","php","tar","gz","js","bat","doc","htm","html","pdf");//Array of alloowed file extention types
$max_file_size=99999999;//max file size to allow in bytes
//echo $max_file_size."</br>";//Report file size var value
$upload_dir="../uploads/";//Directory to upload files to.

//Call function to upload a file
uploader($num_of_uploads,$file_types_array,$max_file_size,$upload_dir);


function uploader($num_of_uploads, $file_types_array, $max_file_size, $upload_dir){
  if(!is_numeric($max_file_size)){
    $max_file_size = 1048576;//Sets max file size to 1 mb if not specified.
  }
 // echo (!is_numeric($max_file_size)).":value after check</br>".$max_file_size."</br>";
  if(!isset($_POST["submitted"])){
    $form = "<form action='".$PHP_SELF."' method='post' enctype='multipart/form-data'>Upload files:<br /><input type='hidden' name='submitted' value='TRUE' id='".time()."'><input type='hidden' name='MAX_FILE_SIZE' value='".$max_file_size."'>";
    for($x=0;$x<$num_of_uploads;$x++){
      $form .= "<input type='file' name='file[]'><font color='red'>*</font><br />";
    }
    $form .= "<input type='submit' value='Upload'><br /><font color='red'>*</font>Maximum file length (minus extension) is 15 characters. Anything over that will be cut to only 15 characters. Valid file type(s): ";
    for($x=0;$x<count($file_types_array);$x++){
      if($x<count($file_types_array)-1){
        $form .= $file_types_array[$x].", ";
      }else{
        $form .= $file_types_array[$x].".";
      }
    }
    $form .= "</br>max_file_size=".$max_file_size."</form>";
    echo($form);
  }else{
    foreach($_FILES["file"]["error"] as $key => $value){
      if($_FILES["file"]["name"][$key]!=""){
        if($value==UPLOAD_ERR_OK){
          $origfilename = $_FILES["file"]["name"][$key];
          $filename = explode(".", $_FILES["file"]["name"][$key]);
          $filenameext = $filename[count($filename)-1];
          unset($filename[count($filename)-1]);
          $filename = implode(".", $filename);
          $filename = substr($filename, 0, 15).".".$filenameext;
          $file_ext_allow = FALSE;
          for($x=0;$x<count($file_types_array);$x++){
            if($filenameext==$file_types_array[$x]){
              $file_ext_allow = TRUE;
            }
          }
          if($file_ext_allow){
            if($_FILES["file"]["size"][$key]<$max_file_size){
              if(move_uploaded_file($_FILES["file"]["tmp_name"][$key], $upload_dir.$filename)){
                echo("File uploaded successfully. - <a href='".$upload_dir.$filename."' target='_blank'>".$filename."</a><br />");
                echo ("View upload directory - <a href='".$upload_dir."' target='_blank'>".$upload_dir."</a></br/>");
                
              }else{
                echo($origfilename." was not successfully uploaded 1<br />");
              }
            }else{
              echo($origfilename." was too big, size was:".$_FILES["file"]["size"][$key]." so it was not uploaded max_file_size=".$max_file_size."<br />");
            }
          }else{
            echo($origfilename." had an invalid file extension, not uploaded<br />");
          }
        }else{
          echo($origfilename." was not successfully uploaded 2<br />");
        }
      }
    }
  }
}


//uploader([int num_uploads [, arr file_types [, int file_size [, str upload_dir ]]]]);

//num_uploads = Number of uploads to handle at once.

//file_types = An array of all the file types you wish to use. The default is txt only.

//file_size = The maximum file size of EACH file. A non-number will results in using the default 1mb filesize.

//upload_dir = The directory to upload to, make sure this ends with a /

//This functions echo()'s the whole uploader, and submits to itself, you need not do a thing but put uploader(); to have a simple 1 file upload with all defaults.

/* Zip File Handeling Functions

function ShellFix($s)
{
  return "'".str_replace("'", "'\''", $s)."'";
}

function zip_open($s)
{
  $fp = @fopen($s, 'rb');
  if(!$fp) return false;
 
  $lines = Array();
  $cmd = 'unzip -v '.shellfix($s);
  exec($cmd, $lines);
 
  $contents = Array();
  $ok=false;
  foreach($lines as $line) 
  {
    if($line[0]=='-') { $ok=!$ok; continue; }
    if(!$ok) continue;
   
    $length = (int)$line;
    $fn = trim(substr($line,58));
   
    $contents[] = Array('name' => $fn, 'length' => $length);
  }
 
  return
    Array('fp'       => $fp, 
          'name'     => $s,
          'contents' => $contents,
          'pointer'  => -1);
}                          
function zip_read(&$fp)
{
  if(!$fp) return false;
 
  $next = $fp['pointer'] + 1;
  if($next >= count($fp['contents'])) return false;
 
  $fp['pointer'] = $next;
  return $fp['contents'][$next];
}
function zip_entry_name(&$res)
{
  if(!$res) return false;
  return $res['name'];
}                          
function zip_entry_filesize(&$res)
{
  if(!$res) return false;
  return $res['length'];
}
function zip_entry_open(&$fp, &$res)
{
  if(!$res) return false;

  $cmd = 'unzip -p '.shellfix($fp['name']).' '.shellfix($res['name']);
 
  $res['fp'] = popen($cmd, 'r');
  return !!$res['fp'];  
}
function zip_entry_read(&$res, $nbytes)
{
  return fread($res['fp'], $nbytes);
}
function zip_entry_close(&$res)
{
  fclose($res['fp']);
  unset($res['fp']);
}
function zip_close(&$fp)
{
  fclose($fp['fp']);
}

*/
/*Zip class functions
$ARCHIVE = new zip;

$ARCHIVE->makeZip('./','./toto.zip'); // make an ZIP archive
var_export($ARCHIVE->infosZip('./toto.zip'), false); // get infos of this ZIP archive (without files content)
var_export($ARCHIVE->infosZip('./toto.zip')); // get infos of this ZIP archive (with files content)
$ARCHIVE->extractZip('./toto.zip', './1/'); //

class zip
{
    public function infosZip ($src, $data=true)
    {
        if (($zip = zip_open(realpath($src))))
        {
            while (($zip_entry = zip_read($zip)))
            {
                $path = zip_entry_name($zip_entry);
                if (zip_entry_open($zip, $zip_entry, "r"))
                {
                    $content[$path] = array (
                        'Ratio' => zip_entry_filesize($zip_entry) ? round(100-zip_entry_compressedsize($zip_entry) / zip_entry_filesize($zip_entry)*100, 1) : false,
                        'Size' => zip_entry_compressedsize($zip_entry),
                        'NormalSize' => zip_entry_filesize($zip_entry));
                    if ($data)
                        $content[$path]['Data'] = zip_entry_read($zip_entry, zip_entry_filesize($zip_entry));
                    zip_entry_close($zip_entry);
                }
                else
                    $content[$path] = false;
            }
            zip_close($zip);
            return $content;
        }
        return false;
    }
    public function extractZip ($src, $dest)
    {
        $zip = new ZipArchive;
        if ($zip->open($src)===true)
        {
            $zip->extractTo($dest);
            $zip->close();
            return true;
        }
        return false;
    }
    public function makeZip ($src, $dest)
    {
        $zip = new ZipArchive;
        $src = is_array($src) ? $src : array($src);
        if ($zip->open($dest, ZipArchive::CREATE) === true)
        {
            foreach ($src as $item)
                if (file_exists($item))
                    $this->addZipItem($zip, realpath(dirname($item)).'/', realpath($item).'/');
            $zip->close();
            return true;
        }
        return false;
    }
    private function addZipItem ($zip, $racine, $dir)
    {
        if (is_dir($dir))
        {
            $zip->addEmptyDir(str_replace($racine, '', $dir));
            $lst = scandir($dir);
                array_shift($lst);
                array_shift($lst);
            foreach ($lst as $item)
                $this->addZipItem($zip, $racine, $dir.$item.(is_dir($dir.$item)?'/':''));
        }
        elseif (is_file($dir))
            $zip->addFile($dir, str_replace($racine, '', $dir));
    }
}
*/

?>