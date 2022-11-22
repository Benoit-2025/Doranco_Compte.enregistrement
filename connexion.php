<?PHP

require_once "inc/init.php";

debug($_SESSION);

// j'attends la validation du formulaire

//if(!empty($_POST)

if(isset($_POST['connexion'])){
   // debug($_SESSION);

    // Etape de sécurisation des données 
    foreach($_POST as $key => $value){

        $_POST[$key] = htmlspecialchars($value, ENT_QUOTES);
    }

    // fin de sécurisation des données

    // Etape des vérification des données 
       if(empty($_POST['username']) || empty($_POST['password']) ){
         $errorMessage = "Les identifiants sont obligatoire";
         debug($errorMessage);
       } else { // si les donneés sont remplis je peux assayer de récupérer un internaute

       //Etape de connexion

       //récuperation d'un membre via son pseudo uniquement.
       $requete = $bdd->prepare("SELECT * FROM membre WHERE username = :username");
       $requete->execute([':username' =>$_POST['username']]);
       //debug($requete = $rowCount());// rowCount () me permet de compter le nombre de résultet depuis mon BDD
       if ( $requete->rowCount()==1) {

          $user = $requete->fetch();
          debug($user);
          // maintenant que j'ai un utilisateur je peux essayer de vérifier son mot de epasse .

          // le mot de passe en BDD est haché donc pour vérifier et comparer le mdp reçu dans le formulaire  je dois utiliser la fonction passeword_verify()
          // cette fonction attend en premier le mot de passe 'normal' eet en deuxieme parametres le mot de passe haché. la fonction renvera TRUE ou FALSE en fonction du resultat.

          if( password_verify($_POST['password'], $user['password']) ){
            //une fois le mot de passe vérifier je peux stoker dans la session les informations de cet utilisateur.
            // insera à partir de ce dmoment , connecté 'à mon site
             $_SESSION['membre'] = $user;

            $_SESSION['successMessage'] = "Bonjour $user[username], Bienvenue sur votre compte";
            //$_SESSION['successMessage] = "Bonjour".$_SESSION['membre']

            header('location:profil.php');
            exit;
          
        } else {
            $errorMessage = "Mot de passe ou identifiant incorrects";
          }
       ####code...
       } else {
        $errorMessage = "Mot de passe ou identifian incorrects";
       }

    }
       //$user = $requete->fatch();

       //$requete->rowCount();
       
 
       //Fin de vérification des données


       //Fin de connexion
}
debug($_SESSION);


require_once "inc/header.php";
?>

<H1 class="text-center">Connexion</H1>

<?php if( !empty($successMessage) ){ ?>
    <div class="alert alert-success col-md-6 text-center mx-auto">
            <?php echo $successMessage ?>
    
        </div>
      <?php } ?>
    
    
      <?php if( !empty($_SESSION['successMessage']) ){ ?>
        <div class="alert alert-success  col-md-6 text-center mx-auto">
            <?php echo $_SESSION['successMessage'] ?>
    
        </div>
        <?php unset($_SESSION['successMessage']); ?>
      <?php } ?>

    
    
      <?php if( !empty($errorMessage) ){ ?>
        <div class="alert alert-danger col-md-6 text-center mx-auto">
            <?php echo $errorMessage ?>
    
        </div>
      <?php } ?>
        <form action="" method="post" class="col-md-6 mx-auto">

                <label for="username" class="form-label" >Pseudo</label>
                <input type="text" placeholder="Votre Pseudo" name="username"               id="username" class="form-control">

                <label for="password" class="form-label">Mot de Passe</label>
                <input type="password" placeholder="Votre Mot de Passe" name="password"                 id="password" class="form-control">

                <button class="d-block mx-auto btn btn-primary mt-3"                name="connexion">Connexion</button>

</form>

 

      <?php
debug($_SESSION);
require_once "inc/footer.php";
?>