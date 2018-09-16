<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<body>
<p>Publitio</p>
<form action="" method="post" enctype="multipart/form-data">
    {{ csrf_field() }}
    Upload a file:
    <input type="file" name="myfile" id="fileToUpload">
    <input type="submit" name="submit" value="Upload File Now">
</form>
</body>
</html>
