<?
	require_once($_SERVER['DOCUMENT_ROOT'].'/payment/stripe-php/init.php');
	
	\Stripe\Stripe::setApiKey("sk_test_xxxxxxxx");
	
	$token = $_POST['stripeToken'];
	$stripeEmail = $_POST['stripeEmail'];
	
	try 
	{
		$charge = \Stripe\Charge::create(array(
		'amount' => 999,
		'currency' => 'usd',
		'description' => 'Example charge',
		'source' => $token,
		'receipt_email' => $stripeEmail,
        ));
	}
	catch(\Stripe\Error\Card $e) 
	{
		// The card has been declined
		
		echo "ERORR:" . $e->getMessage();
		exit;
	}
	
	header("Content-type: text/html; charset=utf-8");
	echo "決済が完了しました<br>";
	echo "ID:" . $charge->id . "<br>";
?>

<!doctype html>
<html lang="ja">
	<form action="/payment/pay.php" method="POST">
		<script
		src="https://checkout.stripe.com/checkout.js" class="stripe-button"
		data-key="pk_test_xxxxxxx"
		data-amount="999"
		data-name="一括払い"
		data-description="Widget"
		data-image="https://stripe.com/img/documentation/checkout/marketplace.png"
		data-locale="ja"
		data-currency="jpy">
		</script>
	</form>
</html>
