<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<title>JSON 2 HTML</title>
<link rel="StyleSheet" type="text/css" href="style.css" />
<script type="text/javascript" src="scripts/json-min.js"></script>
<script type="text/javascript" src="scripts/BubbleTooltips.js"></script>
<script type="text/javascript" src="scripts/parse.js"></script>
<!--[if lt IE 7]>
<script defer type="text/javascript" src="scripts/pngfix.js"></script>
<![endif]-->

</head>
<body id="body" >
<div class="mainbody">
   <div id="bodywrap" class="bodywrap"></div>
   <div id="desc" class="desc">
      <p><img class="jsonlogo" src="images/json.gif" alt="JSON logo" /><h3>json</h3>
      <span class='string'>Colour for text and null values.</span><br />
      <span class='number'>Colour for numbers.</span><br />
      <span class='boolean'>Colour for true and false values.</span><br />
      <span class='void'>Colour for void values.</span><br />
      <img class="ex" src="images/object.png" /> Background for Objects.<br />
      <img class="ex" src="images/array.png" /> Background for Arrays.<br />
      <img class="ex" src="images/objectt.png" /> Background for Object name/value pair tables.<br />
      <img class="ex" src="images/arrayt.png" /> Background for Array value tables.</p>
   </div>

   <div>
      <div id="inputcontainer">
      <textarea id="text" rows="12">
      <?php
      	if (isset($_GET['content']))
      		echo  trim(base64_decode($_GET['content']));
      ?>
      </textarea></div>
      <hr />
      <a name="_output" class="noa"></a>
      <div id="stats" class="stats"></div>
      <div id="output" class="output"></div>
  </div>
  <?php
  	echo "<script language=javascript>doParse();</script>";
  ?>
</body>
</html>