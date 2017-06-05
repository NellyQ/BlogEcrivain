$app->get('/hashpwd', function() use ($app) {
    $rawPassword = 'Alaska';
    $salt = '%qUgq3NAYfC1MKwrW?yevbE';
    $encoder = $app['security.encoder.bcrypt'];
    return $encoder->encodePassword($rawPassword, $salt);
});
