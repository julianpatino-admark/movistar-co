<?php

require '/var/www/html/vendor/autoload.php';

$app = require '/var/www/html/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

for ($attempt = 1; $attempt <= 30; $attempt++) {
    try {
        $connection = Illuminate\Support\Facades\DB::connection();
        $connection->select('SELECT 1');
        $cipher = $connection->selectOne("SHOW SESSION STATUS LIKE 'Ssl_cipher'");
        if (env('MYSQL_ATTR_SSL_CA') && empty($cipher->Value)) {
            throw new RuntimeException('The database connection must use TLS.');
        }
        fwrite(STDOUT, "Cloud SQL connection verified using TLS.\n");
        exit(0);
    } catch (Throwable $exception) {
        if ($attempt === 30) {
            fwrite(STDERR, "Database connection failed: {$exception->getMessage()}\n");
            exit(1);
        }

        sleep(1);
    }
}
