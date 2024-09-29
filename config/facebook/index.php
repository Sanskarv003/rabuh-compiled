<?php
/**
 * Build a simple HTML page with multiple providers, opening provider authentication in a pop-up.
 */

require 'autoload.php';
require 'config.php';
use Hybridauth\Hybridauth;
$hybridauth = new Hybridauth($config);
$adapters = $hybridauth->getConnectedAdapters();
?>
