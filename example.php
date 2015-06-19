include('Fileviewer.php');
$viewer = new Fileviewer('YOUR_API_KEY');
$url = $viewer->load('http://viewer.filelabel.co/documents/file.pdf');
header('Location: '.$url);
