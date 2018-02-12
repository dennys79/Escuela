<?php

require_once 'Countries.php';
require_once 'ModeloCountries.php';
$modelo = new LibQ_Countries_ModeloCountries();
$countries = $modelo->getCountries();