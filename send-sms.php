<?php 
/*
Template Name: send-sms
*/ 
?>
<?php 

get_header(); ?>


<div class="wrap">
	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<?php
		
				require_once dirname( __FILE__ ) . '/No2SMS_Client.class.php'; 
				
				$user        = "devjob";
				$password    = base64_decode("cG9vcmx5Y29kZWRwYXNzd29yZA==");
				$destination = "41763847699";  //"+41 (076) 536 37 76"
				$message     = "--------------------------\n";
				$message     .= "- Antonio Luca\n";
				$message     .= "- a link to the code you wrote\n";
				$message     .= "--------------------------\n";
				
				/* affichage des informations avancées du message, nombre de SMS utilsés etc. */
				var_dump(No2SMS_Client::message_infos($message, TRUE));
				var_dump(No2SMS_Client::test_message_conversion($message));
				
				/* on crée un nouveau client pour l'API */
				$client = new No2SMS_Client($user, $password);
				
				try {
				    /* test de l'authentification */
				    if (!$client->auth())
				        die('mauvais utilisateur ou mot de passe');
				
				    /* envoi du SMS */
				    print "===> ENVOI\n";
				    $res = $client->send_message($destination, $message);
				    var_dump($res);
				    $id = $res[0][2];
				    printf("SMS-ID: %s\n", $id);
				
				    /* décommenter pour tester l'annulation */
				    //print "===> CANCEL\n";
				    //$res = $client->cancel_message($id);
				    //var_dump($res);
				
				    print "===> STATUT\n";
				    $res = $client->get_status($id);
				    var_dump($res);
				
				    /* on affiche le nombre de crédits restant */
				    $credits = $client->get_credits();
				    printf("===> Il vous reste %d crédits\n", $credits);
				
				} catch (No2SMS_Exception $e) {
				    printf("!!! Problème de connexion: %s", $e->getMessage());
				    exit(1);
				}
			?>

		</main><!-- #main -->
	</div><!-- #primary -->
	<?php get_sidebar(); ?>
</div><!-- .wrap -->

<?php get_footer();