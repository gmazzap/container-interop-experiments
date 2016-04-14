Container Interop Experiments
=============================

This repo contains my experiments for Container Interop Service Providers.

See https://github.com/container-interop/service-provider for more info.

## The Application

Repo contains a simple application that shows a web page containing "Hello World" in different languages.

The application uses [**Zend/Diactoros**](https://github.com/zendframework/zend-diactoros) for the
HTTP request / response implementation.

It also uses [**Mustache PHP**](https://github.com/bobthecow/mustache.php) to render the page content.

These libraries are, of course, pulled with Composer.

Finally, there's a single class named **HelloWorld** that is responsible to return the greeting string.

The core of the application, is a single function named `main()` that takes an instance of a
container implementing Container Interop interface, and uses the libraries mentioned above to render
the web page.

## The Experiments

This repo comes with different experiments, one for each service provider interface I want to explore.

Each experiment comes with:

- an interface for service provider
- a container class, that is an implementation of container interop standard, that accepts
  the service provider interface
- concrete implementations of service provider interface, used to register in the container instances
  of the Mustache template engine and of the `HelloWorld` class
  
  
## How to test

All the experiments are fully functional.

To test in your browser, first of all clone this repo:

```bash
git clone https://github.com/Giuseppe-Mazzapica/container-interop-experiments
```

then move to the repo folder and install Composer dependencies:

```bash
cd container-interop-experiments
composer install
```

Use [PHP built-in web server](http://php.net/manual/en/features.commandline.webserver.php) to serve the application:

```bash
php -S localhost:8000
```

and point your browser to `http://localhost:8000`

## Experiments Description

At the moment, there are **3 experiments** in this repo.

The container implementation is very similar for all of them. It is based on [Pimple](http://pimple.sensiolabs.org/) 
and beside the methods enforced by Container Interop standard (`has()` and `get()`) is contains just
another public method: `useProvider()`, which accepts a service provider interface (different for each experiment)
and registers in the container the services provided by the given service provider.

### Experiment 01

This experiment is the concrete implementation of an interface I proposed in the issue 18 of Container Interop
service provider repo, see [here](https://github.com/container-interop/service-provider/issues/18).

The **pros** of this implementation are:

- it's readable and intention revealing: it's very easy to understand what the objects implementing interface
  should do
- it is capable to enforce the signature of factory methods

The **cons** are:

- Services provided can be returned from a single method,`createService`, which makes concrete implementations
  hard to read and maintain if the provider provides several services. The alternative is to use `createService`
  as a "entry point" to call service-specific factory methods, which affect performance increasing the number
  of method called.
  
Code for experiment 1 is [here](https://github.com/Giuseppe-Mazzapica/container-interop-experiments/tree/master/experiment-01/src).
  
### Experiment 02

This is probably the best implementation from the "code quality" point of view. It adheres perfectly
with OOP best practices.

It is made by 2 interfaces: one for service provider itself, one for "service factory".

The provider interface has just one method: `serviceFactories()` which is responsible to return an
array of objects implementing the service factory interface.

Service factory interface has 2 methods: `serviceName()` and `factory()`: the first return the service name as
string and the latter return an instance of the service.

The **pros** of this implementation are:

- strong typed design
- SRP principle respected for all object involved
- readable and intention revealing
- capable to enforce the signature of factory methods

The **cons** are:

- Memory consuming: each service requires its own factory object, so more objects need to be created
  on runtime
- "Harder" to implement: a library that provides 10 services is required to have 11 classes to
  implement this standard: 1 for service provider, 1 factory class for each service.
  (This may not be true with PHP 7 thanks to anonymous classes).
  
Code for experiment 2 is [here](https://github.com/Giuseppe-Mazzapica/container-interop-experiments/tree/master/experiment-02/src).
  
### Experiment 03

In implementation the service provider interface has just 1 method, that returns a map from service
names to service factories in form of PHP `callable`.

This has been discussed in the already mentioned Container Interop service provider
[issue 18](https://github.com/container-interop/service-provider/issues/18).

The **pros** of this implementation are:

- easy to implement
- PHP `callable` are a flexible type, because can be implemented in different ways: closures, 
  plain functions, invokable objects, dynamic and static class methods. This leave implementers
  some room to choose the preferred method.

The **cons** are:

- there's no way to enforce the signature of factory callbacks (at least with current versions of PHP).
  It means that implementation details are not recognizable just from code, but implementers are
  required to read documentation to implement this standard. It also means that it the implementation is not "type safe".
  
Code for experiment 3 is [here](https://github.com/Giuseppe-Mazzapica/container-interop-experiments/tree/master/experiment-03/src).
