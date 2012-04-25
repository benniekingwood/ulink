<?php
$up_file=$_REQUEST['sub_file']; 
$tot=explode(".",$up_file);
$total=count($tot);

$total=$total-1;
$tot=$tot[$total];

if (($tot == "pdf") || ($tot =="jpeg")||($tot== "jpg") ||($tot == "PDF") || ($tot =="JPEG")||($tot== "JPG")||($tot== "DOC") ||($tot== "XLS") ||($tot== "xls") || ($tot== "DOC") || ($tot== "MP3") || ($tot== "mp3") || ($tot== "exe") || ($tot== "EXE") || ($tot== ""))
{
echo "0";
}

elseif (($tot == "avi") || ($tot =="AVI")||($tot== "3gp") ||($tot == "mov") || ($tot =="MOV")||($tot== "AVI")||($tot== "avi") ||($tot== "flv") ||($tot== "FLV") || ($tot== "MP4") || ($tot== "mp4") || ($tot== "wmv") || ($tot== "WMV") || ($tot== "3GP"))
{
echo "1";
}

else {
echo "0";
}
 ?>
 
 