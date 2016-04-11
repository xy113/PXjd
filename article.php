<?php
error_reporting(0);
$id = $_GET['id'];
@header('location:/?m=post&c=detail&id='.$id);