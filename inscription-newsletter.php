<?php

$api_key = '33d68ce23f5c55ae3b693783af5f7ec0-us14';
$list_id = '6310c089c7';
$email = $_POST['email'];

$data_center = substr($api_key,strpos($api_key,'-')+1);
$url = 'https://'. $data_center .'.api.mailchimp.com/3.0/lists/'. $list_id .'/members';

$json = json_encode([
    'email_address' => $email,
    'status' => 'subscribed',
]);

$ch = curl_init($url);

curl_setopt($ch, CURLOPT_USERPWD, 'user:' . $api_key);
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 10);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $json);

$result = curl_exec($ch);
$status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($status_code == 200) {
    $response = array('status' => 'success', 'message' => 'Vous avez bien été abonné à notre newsletter.');
    echo json_encode($response);
    die();
} else {
    $response = array('status' => 'error', 'message' => 'Une erreur s\'est produite lors de l\'abonnement à notre newsletter. Veuillez rentrer une adresse mail valide.');
    echo json_encode($response);
    die();
}

?>
