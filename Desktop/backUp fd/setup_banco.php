<?php
/**
 * setup_banco.php
 * Coloque este arquivo na RAIZ do projeto (mesma pasta do artisan).
 * Execute via Cron Job no cPanel UMA ÚNICA VEZ para criar as tabelas do banco.
 * Depois delete ou renomeie este arquivo por segurança.
 */

define('LARAVEL_START', microtime(true));

// Garante que está na pasta do projeto
chdir(__DIR__);

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);

echo "=== Florescer com Deus — Setup do Banco ===\n";
echo date('Y-m-d H:i:s') . "\n\n";

// 1. Config cache
echo "1. Limpando cache de configuração...\n";
$status = $kernel->call('config:clear');
echo "   Status: $status\n";

// 2. Migração
echo "\n2. Rodando migrations...\n";
$status = $kernel->call('migrate', ['--force' => true]);
echo "   Status: $status\n";

// 3. Cache de rotas
echo "\n3. Cache de configuração...\n";
$status = $kernel->call('config:cache');
echo "   Status: $status\n";

echo "\n=== Concluído! ===\n";
echo "IMPORTANTE: Delete ou renomeie este arquivo agora por segurança.\n";

$kernel->terminate(
    Illuminate\Http\Request::capture(),
    new Illuminate\Http\Response()
);
