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

This requires at least a "pro" account.

## Server Side URLs
You may want the URL completely hidden and transmitted server side in order to get even better security. Use the following:

    $viewer = new Fileviewer(
        'YOUR_API_KEY',
        'http://viewer.filelabel.co/documents/file.pdf'
    );
    $viewer->load();

This requires at least a "pro" account.
    
## Permissions

You may want to limit access to certain features programmatically, depending on your user. The permissions currently available in the app are:

    $permissions = array(
        'annotate',
        'download',
        'hideAnnotations',
        'print',
        'share',
        'stickyNotes'
    );
