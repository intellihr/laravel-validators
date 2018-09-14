<?php
declare(strict_types=1);

namespace IntelliHR\Validation;

use DirectoryIterator;
use Illuminate\Support\ServiceProvider;
use ReflectionClass;

class ValidatorServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     */
    public function boot(): void
    {
        $files = new DirectoryIterator(__DIR__ . '/Validators');

        foreach ($files as $file) {
            if ($file->isFile() && !$file->isDot()) {
                $this->loadValidator($file);
            }
        }
    }

    /**
     * Register the service provider.
     */
    public function register(): void
    {
    }

    /**
     * @param DirectoryIterator $file
     */
    private function loadValidator(DirectoryIterator $file): void
    {
        $basename = $file->getBasename('.php');
        $className = $this->getValidatorClassName($basename);

        $reflection = new ReflectionClass($className);

        if (!$reflection->isInstantiable()) {
            return;
        }

        $validatorName = $reflection->getStaticPropertyValue('name');
        $validateMethodName = $this->getValidatorMethodName($basename);

        $this->app->validator->extend(
            $validatorName,
            $className . '@' . $validateMethodName,
            $reflection->getStaticPropertyValue('message')
        );

        $replacerMethodName = $this->getReplacerMethodName($basename);

        if ($reflection->hasMethod($replacerMethodName)) {
            $this->app->validator->replacer(
                $validatorName,
                $className . '@' . $replacerMethodName
            );
        }
    }

    /**
     * @param string $basename
     *
     * @return string
     */
    private function getValidatorClassName($basename)
    {
        return 'IntelliHR\\Validation\\Validators\\' . $basename;
    }

    /**
     * @param string $basename
     *
     * @return string
     */
    private function getValidatorMethodName($basename)
    {
        return 'validate' . $basename;
    }

    /**
     * @param string $validator
     *
     * @return string
     */
    private function getReplacerMethodName($validator)
    {
        return 'replace' . $validator;
    }
}
