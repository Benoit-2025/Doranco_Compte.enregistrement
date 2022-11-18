<?php

//############   ETAPE 1 - Inclusion de Init.php

require_once "inc/init.php";


//####### ETAPE 2 - Traitement des données du formulaire 
// je vérifie si le formulaire a été validé. s'il a été je peux traité les données 
//Warning je peux traiter les données si le formulaire n'a pas été envoyé.  


if(!empty($_POST)){

    debug($_POST);
   
// ETAPE DE V2RIFICATION DES DONNées

//

    /// SECURISATION DES DONNEES

//$_POST['username'] = htmlspecialchars($_POST['pseudo']);

foreach($_POST as $Key => $value){
    $_POST['Key'] = htmlspecialchars($value, ENT_QUOTES);


}


    // ETAPE de vérification des données
       
        if(empty($_POST['username'])){
            $errorMessage = "Merci d'indiquer un pseudo <br>";
        
        }

        // strlen()       permet de récupérer la longueur d'une chaine de caractère . Attention les caractères spéciaux compte pour 2 . Exemple : éé comptera pour 4 caratères .
        //iconv_strlen() permet de resoudre ce probleme.
        
        if( iconv_strlen(trim($_POST['username'])) < 3 || iconv_strlen(trim($_POST['username'])) > 20 ){
            $errorMessage .= "le pseudo doit contenir entre 3 et 10 caractères <br>";
        }

        if (empty($_POST['password']) || iconv_strlen(trim($_POST['password'])) < 8 ){
            $errorMessage .= "Merci d'indiquer un mot de passe <br>";
        }
        
        if (empty($_POST['lastname']) || iconv_strlen(trim($_POST['lastname'])) > 70 ){
            $errorMessage .= "Merci d'indiquer un nom Maximum 70 caractères<br>";
        }
        
        
        if (empty($_POST['firstname']) || iconv_strlen(trim($_POST['firstname'])) > 70 ){
            $errorMessage .= "Merci d'indiquer un prenom(maximum 70 caractères <br>";
        }
        
        if (empty($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) ){
            $errorMessage .= "L'email n'est pas valide <br>";
        }


    // fin de vérification des données

    //ETAPE envoi des données
        if (empty($errorMessage)){ 

            $requete = $bdd->prepare("INSERT INTO membre VALUE(NULL, :username, :password, :lastname, :firstname, :email, :status)");
            $success = $requete->execute([
                "username"=> $_POST['username'],
                "password"=> password_hash($_POST['password'], PASSWORD_DEFAULT),// la fonction password_hash() permet de hasher unnmot de passe. on doit lui indiquer en paramètrele type d'algorythme que l'on souhaite utliser. ici on prend l'algorythme défaut
                "lastname"=> $_POST['lastname'],
                "firstname"=> $_POST['firstname'],
                "email"=> $_POST['email'],
                ":status" =>  "user"

            ]);

            if ($success) {
                $successMessage = "Inscription réussie";
                //si ma requete a fonctionner je suis redirigé vers la page de ma connxion

                header("location:connexion.php");
                exit;

            } else {
                $errorMessage = "Erreur lors de l'inscription";
            }

        }
    // Fin d'envoie de données
}




require_once "inc/header.php";
?>enter mx-auto">
        <?php echo $successMessage ?>

    </div>
  <?php } ?>


  <?php if( !empty($errorMessage) ){ ?>
    <div class="alert alert-Danger col-md-6 text-center mx-auto">
        <?php echo $errorMessage ?>

    </div>
  <?php } ?>

  
  

<form action="" method="post" class="col-md-6 mx-auto">

    <label for="username" class="form-label">Pseudo</label>
    <input type="text" name="username" id="username" class="form-control"
    value="<?= $_POST['username'] ??"" ?>"
    >

    <!-- si $_POST ['username'] existe alors j'affiche sa value SINO j'affiche une chaine de caractère vide .
on utilise ici l'operateur NULL COALESCENT -->

    <div class="invalid-feedback"></div>

    <label for="password" class="form-label">Mot de Passe</label>
    <input type="password" name="password" id="password" class="form-control"
    value="<?= $_POST['password'] ??"" ?>"
    >
    
    
    <div class="invalid-feedback"></div>

    <label for="lastname" class="form-label">Nom</label>
    <input type="text" name="lastname" id="lastname" class="form-control"
    value="<?= $_POST['lastname'] ??"" ?>"
    >
    
    <div class="invalid-feedback"></div>

    <label for="firstname" class="form-label">Prénom</label>
    <input type="text" name="firstname" id="firstname" class="form-control"
    value="<?= $_POST['firstname'] ??"" ?>"
    >
    
    <div class="invalid-feedback"></div>

    <label for="email" class="form-label">Email</label>
    <input type="email" name="email" id="email" class="form-control"
    value="<?= $_POST['email'] ??"" ?>"
    >
    
    <div class="invalid-feedback"></div>

    <button class="btn btn-success d-block mx-auto mt-3">S'inscrire</button>

</form>


<?php
require_once "inc/footer.php";
