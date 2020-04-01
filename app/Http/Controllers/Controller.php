<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Etsy\EtsyClient;
use Etsy\OAuthHelper;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


    public function token() {
    	putenv("ETSY_CONSUMER_KEY=qg4c385jbimgjbwe4d15oxcg");
		putenv("ETSY_CONSUMER_SECRET=acnljj24rt");

		$destination_file = asset('settings.php');

		$consumer_key = getenv('ETSY_CONSUMER_KEY');
		$consumer_secret = getenv('ETSY_CONSUMER_SECRET');

		if (empty($consumer_key) || empty($consumer_secret))
		{
		    error_log("Env vars ETSY_CONSUMER_KEY and ETSY_CONSUMER_SECRET are required\n\nExample:\nexport ETSY_CONSUMER_KEY=qwertyuiop123456dfghj\nexport ETSY_CONSUMER_SECRET=qwertyuiop12");
		    exit(1);
		}

		$client = new EtsyClient($consumer_key, $consumer_secret);
		$helper = new OAuthHelper($client);

	    // In case you want to setup specific permissions pass a space separated) list of permissions
	    // Example: $helper->requestPermissionUrl('email_r profile_w recommend_rw')
	    // List of all allowed permissions: https://www.etsy.com/developers/documentation/getting_started/oauth#section_permission_scopes
	  	$url = $helper->requestPermissionUrl('transactions_r');
	    
	    // read user input for verifier
	    print "Please sign in to this url and paste the verifier below: $url \n";

	    print '$ ';
	    $verifier = trim(fgets(STDIN));

	    $helper->getAccessToken($verifier);

	    file_put_contents($destination_file, "<?php\n return " . var_export($helper->getAuth(), true) . ";");

	    echo "Success! auth file '{$destination_file}' created.\n";
    }
}
