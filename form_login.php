<?php


/* TEMP 

if(isset($_SESSION) && !empty($_SESSION)){
      echo "Session active : <br/>";
      var_dump($_SESSION);
}
else{
      echo "pas de session active <br/>";
}

*/


if(isset($_POST['login'])){

      $form_error = array();


      if (    !isset($_POST["email"]) || empty($_POST["email"]) ){  
            $form_error['email'] = "Veuillez renseigner votre email";  
      }
      else{  
            //$email =  mysql_real_escape_string(strtolower($_POST['email']));
            $email =  strtolower($_POST['email']);
      }


      if (    !isset($_POST["password"]) || empty($_POST["password"]) ){  
            $form_error['password'] = "Veuillez renseigner votre password";  
      }
      else{  
            ///$password =  mysql_real_escape_string($_POST['password']);
            $password =  $_POST['password'];
      }


      // Affichage des erreurs
      foreach ($form_error as $i => $value) {
          echo $i . " => " .$value ." <br/> ";
      }


      if(empty($form_error)){


            // Vérification de la présence du compte dans la BDD
            $selectEmail = $PDO->prepare("SELECT id, email, mdp FROM utilisateurs WHERE email = :email ");
            $selectEmail->execute(array(
                  ':email' => $email
            ));


            // L'email n'existe pas, vérification champs puis création du compte  ds la BDD
            if($selectEmail->rowCount() == 1){

                  // Affichage email + mdp
                  while ($row = $selectEmail->fetch(PDO::FETCH_ASSOC)) {

                        //echo $row['email'] . ' ' . $row['mdp'] . "\n";

                        $pass = hash('sha256', $_POST['password']);

                        print_r($row);

                        if($pass == $row['mdp']){

                              $_SESSION['membre_id']       = $row['id'];
                              $_SESSION['membre_email']    = $row['email'];
                              $_SESSION['membre_mdp']      = $row['mdp'];
                              $_SESSION['membre_logged_in']= true;

                              // Redirection carte
                              header('Location: carte.php');

                        }
                        else{
                              echo "Incorrect password";
                        }


                  }

                  $selectEmail->closeCursor();


            }
            else{

                  echo "Cette adresse n'existe pas !";
            }
      }

}

?>