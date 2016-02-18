<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>phpChart - Basic Chart</title>
<script src='https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js'></script>
</head>
<body>
	<script>
	$(function() {
  var menuVisible = false;
  $('#menuBtn').click(function() {
    if (menuVisible) {
      $('#myMenu').css({'display':'none'});
      menuVisible = false;
      return;
    }
    $('#myMenu').css({'display':'block'});
    menuVisible = true;
  });
  $('#myMenu').click(function() {
    $(this).css({'display':'none'});
    menuVisible = false;
  });
});
	</script>
<div id="menuBtn">click me</div>
<nav id="myMenu">
  <ul>
    <li>entry 1</li>
    <li>entry 2</li>
    <li>entry 3</li>
    <li>entry 4</li>
  </ul>
</nav>
</body>
</html>