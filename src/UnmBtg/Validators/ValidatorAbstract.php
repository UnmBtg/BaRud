<?php
/**
 * Created by PhpStorm.
 * User: unm
 * Date: 22/07/17
 * Time: 20:51
 */

namespace UnmBtg\Validators;


use Illuminate\Filesystem\Filesystem;
use Illuminate\Translation\FileLoader;
use Illuminate\Translation\Translator;
use Illuminate\Validation\Validator;

abstract class ValidatorAbstract implements ValidatorInterface
{

    protected $errors;

    public function validate($attributes, $stage)
    {
        $loader = new FileLoader(new Filesystem(), 'lang');
        $validator = new Validator(new Translator($loader, 'en'), $attributes, $this->getRules($stage), $this->getMessages($stage));

        if ($validator->fails()) {
            $this->errors = $validator->errors();
            throw new \Exception(json_encode($this->errors));
        }

        return true;
    }

    public function getErrors()
    {
        return $this->errors;
    }

    public function getRules($stage) {
        if ($stage == ValidatorStage::CREATE) {
            return $this->createRules();
        }

        return $this->updateRules();
    }

    public function getMessages($stage) {

        if ($stage == ValidatorStage::CREATE) {
            return $this->createMessages();
        }

        return $this->updateMessages();
    }

    public abstract function createRules();

    public function updateRules() {
        return $this->createRules();
    }

    public abstract function createMessages();

    public function updateMessages() {
        return $this->createMessages();
    }

}