<?php
@$fn=$_GET["fn"];
if ($fn=="") 
{
  echo "Usage: getfile.php?fn=xxx.txt -F file=@xxx.txt \n";
}
else
{
if ($_FILES["file"]["error"] > 0)
  {
  echo "Error: " . $_FILES["file"]["error"]."\n";
  }
else
  {
  if ($fn=="") $fn=$_FILES["file"]["name"];
  echo "upload file [" . $fn . "] " . ($_FILES["file"]["size"]) . " bytes\n";
  move_uploaded_file($_FILES["file"]["tmp_name"],"$fn");
  }
}
?>
