# fileviewer-php
PHP Library for using viewer.filelabel.co in your application.

## Basic Usage
    $viewer = new Fileviewer('YOUR_API_KEY');
    $url = $viewer->load('http://viewer.filelabel.co/documents/file.pdf');
    header('Location: '.$url);

## URL Obfuscation
If you load the document with the basic code above, the URL to your document will be made public. If you'd like to hide the URL, use the following:

  $viewer = new Fileviewer('YOUR_API_KEY');
  $url = $viewer->load('http://viewer.filelabel.co/documents/file.pdf', true);
