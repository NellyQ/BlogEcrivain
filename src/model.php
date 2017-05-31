<?php

// Return all billets
function getBillets() {
    //Data access
    $bdd = new PDO('mysql:host=localhost;dbname=blog_ecrivain;charset=utf8', 'Forteroche', 'Alaska');
    $billets = $bdd->query('select * from billets order by billet_id desc');
    //return all billets
    return $billets;
}