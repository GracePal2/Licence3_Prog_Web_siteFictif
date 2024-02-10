<?php
require_once('vendor/autoload.php'); // Assurez-vous que le chemin est correct

\Stripe\Stripe::setApiKey('pk_test_51OFx8ZGoxrm9DONFVY3ieULDkCB90AfdhCr1MehdhrJMMHk49pAxi9uvN8hzPbenQu8cMvuC6nwaaOP0oUn4tP4N00Hs6Sf489'
);

$stripe = new \Stripe\StripeClient('sk_test_51OFx8ZGoxrm9DONFGKLAQKUvlbwkeIx5KWxqmH0k75tweX38W9ncxYa78vz7Jka0tl4x5CPcrhJ4mUkl8PkRhPih00FcIxc15p');
?>