<?php 
//echo '<pre>';print_r($c);echo '</pre>'; 
?><br>
<div align="center">
<p class="title">
	About
	<br><br> 
</p>
</div>
<br>
<div style="padding:0 30px">
<table border="0">
<tr>
<td>
[Updated on 15.03.2023]
<br><br>
<i>The goal of Tsumego Hero is to make solving Go problems more enjoyable.</i>
<br><br>
I’m interested in Go since 2005. My first effort to create a website for Go problems was during my study of Media Computer Science at the University Bremen, Germany in 2010. 
It was front-end oriented and focused on programming a Go board canvas for websites in Adobe Flash. There were many unanswered questions like how to implement the best back-end 
and how to communicate the user actions on the Go board to the server. I didn’t go deep into the topic for several years, 
but I always wanted to do this when I find some time and answers to the open questions.<br><br>

In 2017, I was a scholar of the Yunguseng Dojang by <b>In-seong Hwang</b> (<a target="_blank" href="https://yunguseng.com/">yunguseng.com</a>) and I helped creating files for the EYD practice room. The way Go files were stored, red and displayed on the website were my inspiration for the back-end. I programmed the SGF-reader for Tsumego Hero based on that concept. <br><br>

As the Adobe Flash Player was in 2017 already an outdated technology, I had to start from scratch with the digital Go board. As base, I took jGoBoard by 
<b>Joonas Pihlajamaa</b> (<a target="_blank" href="https://github.com/jokkebk/jgoboard">https://github.com/jokkebk/jgoboard</a>). This looked so amazing, that it gave me a lot of inspiration for later designs. <br><br>
</td>
<td>
<img src="/img/img5214.JPG" height="230px">
</td>
</tr>
<tr>
<td colspan="2">

The first admin I involved in 2019 was <b>Akos “Farkas” Balogh</b>, a high dan player from Hungary. Now we have an awesome crew of 7 admins.<br>

The development of the rating mode is a collaboration with <b>Théo Barollet</b>, a Computer Science PhD student from Grenoble, France. <br><br>




<b>d4rkm4tter</b> wrote 39 comments and 1374 replies. <br>
<b>caranthir</b> wrote 132 comments and 480 replies. <br>
<b>Farkas</b> wrote 15 comments and 450 replies. <br>
<b>Ivan Detkov</b> wrote 105 comments and 210 replies. <br>
<b>Sadaharu</b> wrote 189 comments and 89 replies. <br>
<b>posetcay</b> wrote 120 comments and 158 replies. <br>
<b>jhubert</b> wrote 92 comments and 50 replies. <br>
<b>todbeibrot</b> wrote 89 comments. <br>
<b>Andrey</b> wrote 88 comments. <br>
<b>yaya</b> wrote 65 comments. <br>
<b>Djab</b> wrote 60 comments. <br><br>

Go problems are the core of the website. Here is a list of the file authors (excluding me): <br>
</div>

<?php
	echo '<b>'.$count[10]['author'].'</b> provided '.$count[10]['count'].' files for the collections'.$count[10]['collections'].'<br>';
	echo '<b>'.$count[12]['author'].'</b> provided '.$count[12]['count'].' files for the collection'.$count[12]['collections'].'<br>';
	echo '<b>'.$count[11]['author'].'</b> provided '.$count[11]['count'].' files for the collections'.$count[11]['collections'].'<br>';
	echo '<b>'.$count[9]['author'].'</b> provided '.$count[9]['count'].' files for the collection'.$count[9]['collections'].'<br>';
	echo '<b>'.$count[8]['author'].'</b> provided '.$count[8]['count'].' files for the collection'.$count[8]['collections'].'<br>';
	
	echo '<b>'.$count[4]['author'].'</b> provided '.$count[4]['count'].' files for the collection'.$count[4]['collections'].'<br>';
	echo '<b>'.$count[0]['author'].'</b> provided '.$count[0]['count'].' files for the collection'.$count[0]['collections'].'<br>';
	echo '<b>'.$count[3]['author'].'</b> provided '.$count[3]['count'].' files for the collection'.$count[3]['collections'].'<br>';
	
	echo '<b>'.$count[2]['author'].'</b> provided '.$count[2]['count'].' files for the collection'.$count[2]['collections'].'<br>';
	echo '<b>'.$count[7]['author'].'</b> provided '.$count[7]['count'].' files for the collection'.$count[7]['collections'].'<br>';
	
	
	echo '<b>'.$count[5]['author'].'</b> provided '.$count[5]['count'].' files for the collection'.$count[5]['collections'].'<br>';
	echo '<b>'.$count[6]['author'].'</b> provided 70 files for the collection'.$count[6]['collections'].'<br>';
	echo '<b>'.$count[1]['author'].'</b> provided '.$count[1]['count'].' files for the collection'.$count[1]['collections'].'<br>';
	
	echo '<br>';
	echo 'Here is Dinerchtein\'s website for Go lessons: <a target="_blank" href="http://breakfast.go4go.net/">breakfast.go4go.net</a>';
?>
<div align="center" class="authors">
<table width="100%" class="highscoreTable">
<tr><th></th><th></th><th></th></tr>
<tr><th align="left">Problem</th><th align="left">Author</th><th align="left">Published</th></tr>
<?php
for($i=0; $i<count($t); $i++){
	if($t[$i]['Tsumego']['public']==1){
		echo '<tr class="color12">';
		echo '<td>';
			echo '<a href="/tsumegos/play/'.$t[$i]['Tsumego']['id'].'">'.$t[$i]['Tsumego']['set'].' - '.$t[$i]['Tsumego']['num'].'</a>';
		echo '</td>';
		echo '<td>';
			echo $t[$i]['Tsumego']['author'];
		echo '</td>';
		echo '<td>';
			echo $t[$i]['Tsumego']['created'];
		echo '</td>';
		echo '</tr>';
	}
}
?>
</table>
</tr>
</table>
</div>