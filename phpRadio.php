<!DOCTYPE html>
<html>
<head>
<title>PHPRadio</title>
<script type="text/javascript">
var artist,album,songname;
var infoExists=false;
function loadPHPRadio(){
if(!infoExists){return;}
artist=document.getElementById("artist").innerText;
album=document.getElementById("album").innerText;
songname=document.getElementById("songname").innerText;
}
function nextSong(){
var now=new Date();
location.href="phpRadio.php?t="+now.getTime();
}
function eBay(){window.open("https://www.ebay.com/sch/i.html?_nkw="+escape(artist+' '+album));}
function lyrics(){window.open("https://search.azlyrics.com/search.php?q="+escape(songname+' '+artist));}
function google(){window.open("https://www.google.com/search?q="+escape(artist));}
</script>
<style type="text/css">
.center{text-align: center;}
.mp3info{text-align: left;}
</style>
</head>
<body onload="loadPHPRadio()"><p class="center">
<?php 
define("mp3HTML",'<script type="text/javascript">infoExists=true;</script></span><p class="center"><a href="javascript:eBay()">Buy album on eBay</a>&nbsp;<a href="javascript:lyrics()">Get lyrics</a>&nbsp;<a href="javascript:google()">Google Artist</a></p><p class="center">');
$mp3s=file(".htsongs", FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES );
$played=explode(".",$_COOKIE['played']);
function getMP3Tags($fn){
$fp = fopen(urldecode($fn), 'rb');
fseek($fp,-128,SEEK_END);
$tagdata = fread($fp,128);
fclose($fp);
$tagfmt = 'A3ID/A30Title/A30Artist/A30Album/A4Year';
$tags = unpack($tagfmt,$tagdata);
if($tags['ID']!='TAG'){return basename($fn,'.mp3');}
return str_replace(chr(0),"",'<span class="mp3info">Title: <span id="songname">'.$tags['Title'].'</span><br>Artist: <span id="artist">'.$tags['Artist'].'</span><br>Album: <span id="album">'.$tags['Album'].'</span><br>Year: '.$tags['Year'].mp3HTML);
}
function artwork($fn,$index){
$ig=glob(dirname($fn)."/*.jpg");
if(count($ig)>0){return '<img src="getfile.php?index='.$index.'&typ=1">';}
$ig=glob(dirname($fn)."/*.jpeg");
if(count($ig)>0){return '<img src="getfile.php?index='.$index.'&typ=2">';}
$ig=glob(dirname($fn)."/*.gif");
if(count($ig)>0){return '<img src="getfile.php?index='.$index.'&typ=3">';}
$ig=glob(dirname($fn)."/*.png");
if(count($ig)>0){return '<img src="getfile.php?index='.$index.'&typ=4">';}
return 'No Artwork';
}
if(count($mp3s)==0){
?>
No mp3 files found in <u>.htsongs</u> file<br>
On windows use the <u>makedb.bat</u> file.<br>
On linux use the <u>makedb.sh</u> file.<br>
Those scripts will scan and create the .htsongs file.
</p>
</body>
</html>
<?php die();}
randSong:
$mp3index=mt_rand(0,count($mp3s)-1);$mp3id=base_convert($mp3index,10,36);
if(count($played)>=count($mp3s)){$played=array();}
if(in_array($mp3id,$played)){goto randSong;}
$played[]=$mp3id;
echo artwork($mp3s[$mp3index],$mp3index)."<br>".getMP3Tags($mp3s[$mp3index])."<br>";
?><script type="text/javascript">document.cookie = "played=<?php echo implode(".",$played);?>";</script>
<audio controls autoplay onended="nextSong()">
<source src="getfile.php?index=<?php echo $mp3index;?>" type="audio/mpeg">
This page only works with HTML5 browsers.
</audio><input type="button" value="Skip" onclick="nextSong()"><p class="center">
You have played <?php echo count($played)-1;?>/<?php echo count($mp3s);?> songs<br>
<a href="http://phpradio.delphijustin.biz/">Powered by PHPRadio v1.0</a></p>
</body>
</html>