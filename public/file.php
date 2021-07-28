<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
	<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/clappr@latest/dist/clappr.min.js"></script>
	<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/clappr-pip-plugin@latest/dist/clappr-pip-plugin.js"></script>
	<script type="text/javascript" src="https://cdn.jsdelivr.net/clappr.thumbnails-plugin/latest/clappr-thumbnails-plugin.js"></script>

	<title>文件管理</title>
<script>
function playvideo(url,flag) {
	document.getElementById('player').innerHTML='';
	var w = window.innerWidth ||  document.documentElement.clientWidth || document.body.clientWidth;
	var h = window.innerHeight || document.documentElement.clientHeight || document.body.clientHeight;
	if (flag == 2) { w=400; h=160; }
    var player = new Clappr.Player({source: url, plugins: [ClapprPIPPlugin], autoPlay: true, playInline: false, width: w, height: h, parentId: "#player"});			
}

</script>
</head>
<body>
<div id="player" align="center"></div>
<?php

function read_all ($dir){
    if(!is_dir($dir)) return false;
    $files = array();
	$fs_count = array();
	$cur = 0;
    $handle = opendir($dir);

    if($handle){
        while(($fl = readdir($handle)) !== false){
			if($fl=='.DS_Store' ) continue;
            if($fl=='.' || $fl == '..') continue;
			$temp = $dir.DIRECTORY_SEPARATOR.$fl;
			$ext=strtolower(substr(strrchr($fl, '.'), 1));
			$files[$cur]='';
			if(is_dir($temp))    if (substr($fl,0,1)!='.') { $files[$cur] = '0'.$fl;   $fs_count[0]++; }
			if ($ext=='mp4' || $ext=='mkv' || $ext=='avi' || $ext=='wmv' || $ext=='mov' || $ext=='ts')  { $files[$cur] = '1'.$fl; $fs_count[1]++; }
			if ($ext=='wav' || $ext=='mp3' || $ext=='flc' || $ext=='ape')   { $files[$cur] = '2'.$fl; $fs_count[2]++; }
			if ($ext=='jpg' || $ext=='bmp' || $ext=='png' || $ext=='pcx')  { $files[$cur] = '3'.$fl;  $fs_count[3]++; }
			if ($ext=='apk' || $ext=='exe' || $ext=='com' || $ext=='ipk')  { $files[$cur] = '4'.$fl;  $fs_count[4]++; }
			if ($ext=='zip' || $ext=='rar' || $ext=='tar' || $ext=='gz')  { $files[$cur] = '5'.$fl;  $fs_count[5]++; }			
			if ($ext=='txt' || $ext=='ini' || $ext=='inf' || $ext=='doc' || $ext=='docx' || $ext=='xls' || $ext=='xlsx')  { $files[$cur] = '6'.$fl; $fs_count[6]++;  }					
//			if ($ext=='html' || $ext=='php' || $ext=='asp' )  { $files[$cur] = '7'.$fl;  $fs_count[7]++; }		

			
//			if ($files[$cur]=='') {$files[$cur] = 'z'.$fl; $fs_count[29]++; }
			$cur = $cur+1;
        }
    
		sort($files,0);
		echo '<tr><td>0</td><td>种类</td><td>';
//		for ($x=0;$x<29;$x++) if ($fs_count[$x]>0){ echo $x.':'.$fs_count[$x].' '; }
//		echo '</td></tr>';
		for($x=0;$x<$cur;$x++) {
			$fl = substr($files[$x],1);
			$temp = $dir.DIRECTORY_SEPARATOR.$fl;
			if (substr($temp,0,2)=='./') $temp=substr($temp,2);
			$ftype= substr($files[$x],0,1);
			if ($ftype=='0') { echo '<tr><td>' . ($x+1). '</td><td>目录</td><td><a href="?path=' . $temp . '">' . $fl . '</a></td></tr>';	continue; }		   
			if ($ftype=='1') { echo '<tr><td>' . ($x+1). '</td><td>视频</td><td><a href="javascript:playvideo(\''.$temp.'\',1)">'.$fl.'</a></td></tr>'; continue; }
			if ($ftype=='2') { echo '<tr><td>' . ($x+1). '</td><td>音乐</td><td><a href="javascript:playvideo(\''.$temp.'\',2)">'.$fl.'</a></td></tr>'; continue; }
			if ($ftype=='3') { echo '<tr><td>' . ($x+1). '</td><td>图片</td><td><a href="javascript:playvideo(\''.$temp.'\',3)">'.$fl.'</a></td></tr>'; continue; }
//			if ($ftype=='3') { echo '<tr><td>' . ($x+1). '</td><td>图片</td><td><a href="'.$temp.'">'.$fl.'</a></td></tr>'; continue; }
			if ($ftype=='4') { echo '<tr><td>' . ($x+1). '</td><td>应用</td><td><a href="'.$temp.'">'.$fl.'</a></td></tr>'; continue; }
			if ($ftype=='5') { echo '<tr><td>' . ($x+1). '</td><td>压缩包</td><td><a href="'.$temp.'">'.$fl.'</a></td></tr>'; continue; }
			if ($ftype=='6') { echo '<tr><td>' . ($x+1). '</td><td>文档</td><td><a href="'.$temp.'">'.$fl.'</a></td></tr>'; continue; }		    
			if ($ftype=='7') { echo '<tr><td>' . ($x+1). '</td><td>网页</td><td><a href="'.$temp.'">'.$fl.'</a></td></tr>'; continue; }	
		    if ($fl!='') echo '<tr><td>' . ($x+1). '</td><td>其它</td><td><a href="'.$temp.'">'.$fl.'</a></td></tr>';
		}	

	}
	closedir($handle);
	 
}


@$path=$_GET["path"];
if ($path=='') $path='.';
echo '<table  width="100%" border="1"  cellpadding="1" cellspacing="1">';
echo '<tr><td>序号</td><td>类型</td><td>文件名</td></tr>';
read_all($path);
echo '</table>';
?>

</body>
</html>
