<?php

if(isset($_POST['submit'])){

    // initialise un tableau pour les éventuelles erreurs du formulaire
    $form_error = array();
    
    // Si l'email n'est pas renseigné, affichage erreur
    if (    !isset($_POST["email"]) || empty($_POST["email"]) ){  
        $form_error['email'] = "Veuillez renseigner votre email";  
        echo $form_error['email'];
    }

    else{   

        //$email = mysql_real_escape_string($_POST['email']);
        $email = $_POST['email'];

        // Vérification de la présence du compte dans la BDD
        $selectEmail = $PDO->prepare("SELECT email FROM utilisateurs WHERE email = :email ");
        $selectEmail->execute(array(
            ':email' => $email
        ));

        // L'email n'existe pas, vérification champs puis création du compte en BDD
        if($selectEmail->rowCount() == 0){



                if (    !isset($_POST["lastname"]) || empty($_POST["lastname"]) ){  $form_error['lastname'] = "Veuillez renseigner votre nom";  }
                //else{   $lastname =  mysql_real_escape_string($_POST['lastname']);}
                else{   $lastname =  $_POST['lastname'];}

                if (    !isset($_POST["firstname"]) || empty($_POST["firstname"]) ){$form_error['firstname'] = "Veuillez renseigner votre prénom";}
                //else{   $firstname =  mysql_real_escape_string($_POST['firstname']);}
                else{   $firstname =  $_POST['firstname'];}

                if (!isset($_POST["email"]) || empty($_POST["email"]) ){    $form_error['email'] = "Veuillez renseigner votre email";}
                else{
                    if(filter_var($email, FILTER_VALIDATE_EMAIL)){
                        //$email =  mysql_real_escape_string($_POST['email']);
                        $email =  $_POST['email'];
                    }
                    else{
                        $form_error['email'] = "Email invalide";
                    }       
                }

                if (    !isset($_POST["password"]) || empty($_POST["password"]) ){$form_error['password'] = "Veuillez renseigner un mot de passe";}
                else{   $password = hash('sha256', $_POST['password']);}

                if (    !isset($_POST["birthday"]) || empty($_POST["birthday"]) ){$form_error['birthday'] = "Veuillez renseigner votre date de naissance";}
                else{   
                        //$birthday =  mysql_real_escape_string($_POST['birthday']);
                        $birthday =  $_POST['birthday'];

                        // Conversion du format facebook (02/19/1988) au format SQL Date (1988-02-19)
                        $birthdayDate   = DateTime::createFromFormat('d/m/Y', $_POST['birthday']);
                        $birthdayFormat = $birthdayDate->format('Y-m-d');
                }

                if (    !isset($_POST["skill"]) || empty($_POST["skill"]) ){$form_error['skill'] = "Veuillez renseigner votre niveau";}
                else{   $skill =  $_POST['skill'];}



                if (    !isset($_POST["material"]) || empty($_POST["material"]) ){
                        $material = 0;
                }
                else{   
                        $material = 1;
                }


                if (    !isset($_POST["practice"]) || empty($_POST["practice"]) ){ $practice = ""; }
                else{   $practice = implode(', ', $_POST['practice']);}

                if (    !isset($_POST["description"]) || empty($_POST["description"]) ){$form_error['description'] = "Veuillez renseigner une description";}
                else{   

                        $description =  $_POST['description'];
                        $description = filter_var($description, FILTER_SANITIZE_STRING); 
                }


                /*
                if (    !isset($_POST["phone"]) || empty($_POST["phone"]) ){$form_error['phone'] = "Veuillez renseigner votre téléphone";}
                else{   $phone =  $_POST['phone'];}
                */

                // Si aucune erreur
                if(empty($form_error)){

                    // Return Success - Valid Email  
                    $response = $PDO->prepare("INSERT INTO utilisateurs VALUES(NULL, :nom , :prenom , :email , :date_naissance, :mdp  , :niveau , :technique , :description , :materiel, :telephone) ") or die(print_r($PDO->errorInfo()));

                    $response->execute(
                        array(
                            'nom'               => $lastname,
                            'prenom'            => $firstname,
                            'email'             => $email,
                            'date_naissance'    => $birthdayFormat,
                            'mdp'               => hash('sha256', $_POST['password']),
                            'niveau'            => $skill,
                            'technique'         => $practice,
                            'description'       => $description,
                            'materiel'          => $material,
                            'telephone'         => ""
                        )
                    );

                    // Récupère et sauvegarde la photo de l'utilisateur fb si il était connecté pdt l'inscription
                    if( isset($_POST['fb-picture']) && !empty($_POST['fb-picture']) ){

                            $fbPicture = 'http://graph.facebook.com/'. (int)$_POST['fb-picture'] .'/picture?width=100&height=100';
                            $pictureName = $PDO->lastInsertId(); 

                            copy($fbPicture, './upload/'.$pictureName.'.jpg');

                            // Si copy ne fonctionne pas (version php trop ancienne sur le serveur)
                            /*
                            $content = file_get_contents($fbPicture);
                            $fp = fopen('./upload/'.$pictureName.'.jpg', "w");
                            fwrite($fp, $content);
                            fclose($fp);
                            */
                            
                    }

                    if($response == true){


                        // Vérification de la présence du compte dans la BDD
                        $selectEmail = $PDO->prepare("SELECT id, email, mdp FROM utilisateurs WHERE email = :email ");
                        $selectEmail->execute(array(
                              ':email' => $email
                        ));

                        // DEMARRAGE SESSION
                        if($selectEmail->rowCount() == 1){

                              while ($row = $selectEmail->fetch(PDO::FETCH_ASSOC)) {
                                    $pass = hash('sha256', $_POST['password']);
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
                        }
                        $selectEmail->closeCursor();


                        header("Location: ./carte.php"); /* Redirection du navigateur */
                        exit;

                    }
                    else{
                        echo "Petit erreur technique.. ".$response->errorInfo();
                    }

                    //'materiel'            => $_POST['materiel'],

                     $msg = 'Ok ! mail valide + ajout en BDD';
                     echo $msg; 

                }   
        }
        
        else{
            // Adresse e-mail déjà utilisée !
            $email_error = true;
        }

    }

}





?>