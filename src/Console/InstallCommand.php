<?php

namespace Greeate\Greeate\Console;

use Greeate\Greeate\Database\Seeders\GreeateDatabaseSeeder;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Process;

class InstallCommand extends Command
{
    protected $signature = 'greeate:install
                            {--force : Overwrite existing files}
                            {--no-seed : Skip seeding}
                            {--no-migrate : Skip migrations}
                            {--no-assets : Skip npm install}';

    protected $description = 'Install the Greeate SaaS Admin Panel package';

    public function handle(): int
    {
        $this->components->info('Installing Greeate SaaS Admin Panel...');

        $this->publishConfigs();
        $this->publishMigrations();
        $this->publishViews();
        $this->publishLang();
        $this->publishAssets();
        $this->publishViteResources();
        $this->wireViteConfig();

        if (! $this->option('no-migrate')) {
            $this->runMigrations();
        }

        $this->createStorageLink();

        if (! $this->option('no-seed')) {
            $this->runSeeders();
        }

        $this->setupBroadcasting();
        $this->setupFirebase();
        $this->installNpmDependencies();
        $this->buildAssets();

        $this->newLine();
        $this->components->info('Greeate installed successfully!');
        $this->line('Admin URL: /'.config('greeate.admin_prefix', 'admin'));
        $this->line('Login URL: /login');
        $this->line('Default admin: '.config('greeate.default_admin.email'));
        $this->line('Default password: '.config('greeate.default_admin.password'));
        $this->newLine();
        $this->components->warn('Run: npm run build  (or npm run dev) so Greeate CSS/JS load in the admin panel.');

        return self::SUCCESS;
    }

    protected function publishConfigs(): void
    {
        $this->components->task('Publishing configs', function () {
            $this->callSilent('vendor:publish', [
                '--tag' => 'greeate-config',
                '--force' => $this->option('force'),
            ]);
        });
    }

    protected function publishMigrations(): void
    {
        $this->components->task('Publishing migrations', function () {
            $this->callSilent('vendor:publish', [
                '--tag' => 'greeate-migrations',
                '--force' => $this->option('force'),
            ]);
        });
    }

    protected function publishViews(): void
    {
        $this->components->task('Publishing views', function () {
            $this->callSilent('vendor:publish', [
                '--tag' => 'greeate-views',
                '--force' => $this->option('force'),
            ]);
        });
    }

    protected function publishLang(): void
    {
        $this->components->task('Publishing language files', function () {
            $this->callSilent('vendor:publish', [
                '--tag' => 'greeate-lang',
                '--force' => $this->option('force'),
            ]);
        });
    }

    protected function publishAssets(): void
    {
        $this->components->task('Publishing assets', function () {
            $this->callSilent('vendor:publish', [
                '--tag' => 'greeate-assets',
                '--force' => $this->option('force'),
            ]);
        });
    }

    protected function publishViteResources(): void
    {
        $this->components->task('Publishing Vite resources (css/js)', function () {
            $this->callSilent('vendor:publish', [
                '--tag' => 'greeate-vite',
                '--force' => $this->option('force'),
            ]);
        });
    }

    protected function wireViteConfig(): void
    {
        $this->components->task('Wiring Vite config', function () {
            $viteTs = base_path('vite.config.ts');
            $viteJs = base_path('vite.config.js');
            $vitePath = File::exists($viteTs) ? $viteTs : (File::exists($viteJs) ? $viteJs : null);

            if (! $vitePath) {
                return;
            }

            $content = File::get($vitePath);
            $entries = "'resources/css/greeate.css', 'resources/js/greeate.js'";
            if (File::exists(resource_path('css/greeate-rtl.css'))) {
                $entries .= ", 'resources/css/greeate-rtl.css'";
            }

            if (str_contains($content, 'greeate.css')) {
                if (! str_contains($content, 'greeate-rtl.css') && str_contains($entries, 'greeate-rtl')) {
                    if (preg_match("/input:\s*\[([^\]]+)\]/", $content, $matches)) {
                        $input = rtrim($matches[1]);
                        $replacement = "input: [{$input}, 'resources/css/greeate-rtl.css']";
                        $content = preg_replace("/input:\s*\[[^\]]+\]/", $replacement, $content, 1);
                        File::put($vitePath, $content);
                    }
                }

                return;
            }

            if (preg_match("/input:\s*\[([^\]]+)\]/", $content, $matches)) {
                $input = rtrim($matches[1]);
                $replacement = "input: [{$input}, {$entries}]";
                $content = preg_replace("/input:\s*\[[^\]]+\]/", $replacement, $content, 1);
                File::put($vitePath, $content);
            }
        });
    }

    protected function buildAssets(): void
    {
        if ($this->option('no-assets')) {
            return;
        }

        if (! File::exists(base_path('package.json'))) {
            return;
        }

        $this->components->task('Building frontend assets', function () {
            $result = Process::path(base_path())->run('npm run build');
            if (! $result->successful()) {
                $this->components->warn('npm run build failed. Run it manually after install.');
            }
        });
    }

    protected function runMigrations(): void
    {
        $this->components->task('Running migrations', function () {
            Artisan::call('migrate', ['--force' => true]);
        });
    }

    protected function createStorageLink(): void
    {
        if (! File::exists(public_path('storage'))) {
            $this->components->task('Creating storage link', function () {
                Artisan::call('storage:link');
            });
        }
    }

    protected function runSeeders(): void
    {
        $this->components->task('Seeding default data', function () {
            $seeder = new GreeateDatabaseSeeder;
            $seeder->setCommand($this);
            $seeder->run();
        });
    }

    protected function setupBroadcasting(): void
    {
        $this->components->task('Configuring broadcasting placeholders', function () {
            $envPath = base_path('.env');
            if (! File::exists($envPath)) {
                return;
            }

            $placeholders = [
                'BROADCAST_CONNECTION' => 'log',
                'PUSHER_APP_ID' => '',
                'PUSHER_APP_KEY' => '',
                'PUSHER_APP_SECRET' => '',
                'PUSHER_APP_CLUSTER' => 'mt1',
                'REVERB_APP_ID' => '',
                'REVERB_APP_KEY' => '',
                'REVERB_APP_SECRET' => '',
            ];

            $content = File::get($envPath);
            foreach ($placeholders as $key => $value) {
                if (! str_contains($content, $key)) {
                    File::append($envPath, "\n{$key}={$value}");
                }
            }
        });
    }

    protected function setupFirebase(): void
    {
        $this->components->task('Configuring Firebase placeholders', function () {
            $envPath = base_path('.env');
            if (! File::exists($envPath)) {
                return;
            }

            $placeholders = [
                'GREEATE_FIREBASE_ENABLED' => 'false',
                'FIREBASE_PROJECT_ID' => '',
                'FIREBASE_SERVER_KEY' => '',
                'FIREBASE_SENDER_ID' => '',
                'FIREBASE_API_KEY' => '',
                'FIREBASE_VAPID_KEY' => '',
            ];

            $content = File::get($envPath);
            foreach ($placeholders as $key => $value) {
                if (! str_contains($content, $key)) {
                    File::append($envPath, "\n{$key}={$value}");
                }
            }
        });
    }

    protected function installNpmDependencies(): void
    {
        if ($this->option('no-assets')) {
            return;
        }

        $packageJson = base_path('package.json');
        if (! File::exists($packageJson)) {
            $this->components->warn('No package.json found. Copy vite.config.greeate.js and tailwind.config.greeate.js manually.');

            return;
        }

        $this->components->task('Installing npm dependencies', function () {
            Process::path(base_path())->run('npm install alpinejs chart.js --save-dev');
        });
    }
}
