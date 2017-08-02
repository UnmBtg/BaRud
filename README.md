# BaRud
Easy way to produce a highly customisable way to create an basic CRUD Api.


# Basics

This are the basics components of the Crud.

- Entities: They're responsible to represent something that must be stored.
- Criterias: They represent a way to search for something.
- Repositories: They're the way to store one Entity in one permanent state. They're also tasked to be able to retrieve the given Entity
- Services: They're where basic procidures must remain utilizing the Repositories to permament store the given procidures.
- Presenter: They give a better look for one given information.
- Transformer: They make one good looking (Presentable) information into something else.
- Validators: Validations that must be placed before storing something premanentely, used on Repositories.



# Usage
Step 1: Create an Entity

In order to store something create an Entity, something around this lines.

    <?php
     class Foo implements EntityInterface{}

This will make the  Entity recognizeble by all the other methods.
If you're using Elloquent there's already an wrapper that will implements all necessaries methods EloquentWarper\Model

Step 2: Create the Validations
It follows the Laravel Validator ways see more at -https://laravel.com/docs/5.4/validation

Example:
    
    <?php
    
    class FooValdiator extends ValidatorAbstract
    {
        public function createRules()
        {
            return [
                'boo' => 'required'
            ];  
        }

        public function createMessages()
        {
            return [];
        }
    }


Step 3:

Create some endpoits and implement the Controlify Trait

Example:

    <?php

    namespace App\Http\Controllers\Api\V1;
    
    
    use UnmBtg\Controllers\ControllerInterface;
    use UnmBtg\Controllers\Controllify;
    use UnmBtg\Entities\EntityInterface;
    use UnmBtg\Services\DefaultService;
    
    class FooController extends Controller implements ControllerInterface
    {
        use Controllify;
    
        protected $validatorException = ValidateException::class;
    
        protected $serviceClass = DefaultService::class;
    
        /**
         * @var EntityInterface
         */
        protected $entity;
    
        public function __construct()
        {
            \App::setLocale("pt_br");
            $this->service = new $this->serviceClass(new $this->entity);
        }
    
        public function index(Request $request) {
            return $this->indexRequest($request->all());
        }
    
        public function store(Request $request)
        {
            return $this->storeRequest($request->all());
        }
    
        public function update($id, Request $request)
        {
            return $this->updateRequest($id, $request->all());
        }
    
        public function destroy($id) {
            return $this->deleteRequest($id);
        }
    
        public function show($id) {
            return $this->showRequest($id);
        }
    }