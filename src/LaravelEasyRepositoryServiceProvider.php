<?php

namespace Mwakalingajohn\LaravelEasyRepository;

use Mwakalingajohn\LaravelEasyRepository\Commands\LaravelEasyRepositoryCommand;
use Mwakalingajohn\LaravelEasyRepository\Commands\MakeRepository;
use Mwakalingajohn\LaravelEasyRepository\Commands\MakeService;
use Spatie\LaravelPackageTools\Exceptions\InvalidPackage;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class LaravelEasyRepositoryServiceProvider extends PackageServiceProvider
{

    public function register()
    {
        $this->registeringPackage();

        $this->package = new Package();

        $this->package->setBasePath($this->getPackageBaseDir());

        $this->configurePackage($this->package);

        if (empty($this->package->name)) {
            throw InvalidPackage::nameIsRequired();
        }

        foreach ($this->package->configFileNames as $configFileName) {
            $this->mergeConfigFrom($this->package->basePath("/../config/{$configFileName}.php"), $configFileName);
        }

        $this->mergeConfigFrom(__DIR__ . "/../config/easy-repository-sys.php", "easy-repository");

        $this->packageRegistered();

        return $this;
    }

    public function configurePackage(Package $package): void
    {
        $package
            ->name('laravel-easy-repository')
            ->hasConfigFile()
            ->hasCommand(MakeRepository::class)
            ->hasCommand(MakeService::class);
    }
}
