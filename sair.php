<?php
include_once('config/includes.php');
session_destroy();
session_unset();
header("Location: " . URLADM);
