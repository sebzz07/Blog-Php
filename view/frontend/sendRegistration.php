<?php
function debug($variable){
    echo '<pre>'. print_r($variable,true) . '</pre>';
}
debug($_POST);

if( !empty($_POST) ) 
{
    $errors =  array();
    
    if( empty( $_POST['pseudo']) || !preg_match('/^[a-zA-Z0-9_]+$/',$_POST['pseudo'] ))
    {
        $errors['pseudo'] = "le Pseudo n'est pas valide (caractères autorisées : lettres majuscules ou minuscules, chiffres et _)";
    };
        
    if( empty( $_POST['first_name'] ))
    {
        $errors['first_name'] = "il manque un Prénom";
    };    
    if( empty($_POST['last_name'] ))
    {
        $errors['last_name'] = "il manque un Nom";
    };    
    if( empty( filter_var( $_POST['email'], FILTER_VALIDATE_EMAIL)))
    {
        var_dump($_POST['email']);
        $errors['email'] = "L\'email est manquant ou incorrect";
    };    
    if( empty( $_POST['password'] ))
    {
        $errors['password'] = "il manque un Mot de passe";
    };    
    if( empty( $_POST['password_confirm'] || $_POST['password'] === $_POST['password_confirm'] )){
        $errors['password_confirm'] = "La confirmation du Mot de passe n'a pas fonctionné";
    };

    debug($errors);
};