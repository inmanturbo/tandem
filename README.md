# Tandem

Run Laravel apps in tandem like packages or modules

There are two ways to use tandem. You can use it as a template or a package.

## As a package

```bash
composer require inmanturbo/tandem
```

## As a template

Clone or fork this repo.

## Usage

Tandem is just a minimal laravel app and/or package with an additional artisan command `tandem`.

```bash
php artisan tandem <package_name> <package_vendor> <package_namespace> --init --install
```

Example:

```bash
php artisan tandem teams Inmanturbo Teams --init --install
```

The above example will create a directory called mod and install a laravel app into a folder called teams inside of it, renaming the App and Database namespaces to `Inmanturbo\Teams` and `Inmanturbo\Teams\Database`, respectively.

Also will update composer.json to reflect namespace, and add `Inmanturbo\Teams\Providers\AppServiceProvider` to the `extras.laravel.providers` array.

Additionally, any stub files found within `base_path('stubs/mod')` will be copied into the "package" as well, at the path relative to their path within `base_path('stubs/mod')`.

Lastly, it will add a local repository to your main app's composer.json at the path `mod/*`, and install the package into you app using a symlink.

You will be able to use your package as a project and/or package, and run and use artisan commands from within the package during development.
