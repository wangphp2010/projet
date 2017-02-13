<?php
require_once("conn/conn.php");

//  $_POST[];

/*
$re = mysqli_query($conn,"select * from client ");
$gb  = mysqli_fetch_array($re);

*/

if($_GET['s']!=1)
{
  ##  inscription -----------------------------------

$nom = $_POST['nom'] ;
$prenom = $_POST['prenom'];
$email = $_POST['email'];
$login = trim($_POST['login']);
$pw = $_POST['pw'];
$pw2 = $_POST['pw2'];
$tel = $_POST['tel'];


if(!$nom) exit("Veuillez saisir votre nom");
if(!$prenom) exit("Veuillez saisir votre prenom");

if(!$email) exit("Veuillez saisir votre email");
$patern  = "#[\w\.\_\-]+@[\w\.\_\-]+\.\w#";
if(!preg_match($patern,$email))exit("Veuillez saisir l'adresse mail valide!");

if(!$tel) exit("Veuillez saisir votre numéro de télépone");
$tel = preg_replace("#\D#","",$tel);
if(strlen($tel)!=10)exit("Veuillez un numéro de télépone avec 10 chiffres");
if(substr($tel,0,1)!=0)exit(" le  numéro de télépone doit commencer par 0 ");
if(!is_numeric($tel))exit("Veuillez un numéro de télépone de chiffre");

if(!$login) exit("Veuillez saisir votre login");
if(strlen($login)>=55)exit("nom de utilisateur trop long!");

$re = mysqli_query($conn,"select utilisateur from client where utilisateur like '$login' limit 1 ");
if(!$re) exit(   mysqli_error($conn)) ;

$gb = mysqli_fetch_assoc($re);

if($gb['utilisateur'] == $login )exit("Veuillez saisir un autre nom d'utilisateur ! ");













if(!$pw) exit("Veuillez saisir votre mot de passe");

if(!$pw2) exit("Veuillez saisir la confirmation du mot de passe");

if($pw!=$pw2)exit("Veuillez saisir deux mots de passe identiques!");



$pw = md5($pw);

$sql = " insert into client
( nom , prenom , email , utilisateur , password , telephone)
values
( '$nom' , '$prenom' , '$email' , '$login' , '$pw' , '$tel')
";


if(!mysqli_query($conn,$sql))
exit(" Erreur! Problème de connexion,Veuillez réessayer plus tard !  ").mysqli_error();

$_POST['msg'] =  " Inscription terminer! vous pouvez vous-connecter!";
##  /inscription -----------------------------------
}




if($_GET['s']==1)
{ ##  login -----------------------------------

  $pw = md5(trim($_POST['pw']));
  $login = $_POST['login'];

  $re = mysqli_query($conn,"select password from client where utilisateur like '$login' limit 1 ") ;
  $gb = mysqli_fetch_assoc($re);
  if($gb['password'] != $pw )exit(" votre mot de passe ou votre nom d'utilisateur n'est pas correct !");

##  /login-------------------
}




echo json_encode($_POST);?>
