<?php
session_start();
$recette = $_GET['p'];
$_SESSION['panier'][$recette] = true;