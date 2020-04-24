<!DOCTYPE html>
<html>
<head>
    <title>Page not found - 404</title>
</head>
<body>
 
 
<h2><center>The page your looking for is not available</center></h2>
<hr>
<p>
    <center>
        Perhaps you would like to go to
         <a href="{{ url()->previous() }}">previous page</a> or
         <a href="{{{ URL::to('/') }}}">home page</a>?
    </center>
</p>
</body>
</html>