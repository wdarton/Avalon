<?php

$myTemplates = [
    'errorClass' => 'is-invalid',
    'error' => '<div class="invalid-feedback">{{content}}</div>',
    'inputContainerError' => '<div class="row {{required}} is-invalid">{{content}}</div>',

    'inputContainer' => '<div class="row mb-3">{{content}}</div>',
    'formGroup' => '{{label}}<div>{{input}}</div>',
    'label' => '<label{{attrs}}>{{text}}</label>',
    'input' => '<input type="{{type}}" name="{{name}}" class="form-control" {{attrs}} >',
    'select' => '<select name="{{name}}" class="form-control" {{attrs}}>{{content}}</select>',
    'selectMultiple' => '<select name="{{name}}[]" class="form-control" multiple="multiple"{{attrs}}>{{content}}</select>',
    'textarea' => '<textarea name="{{name}}" class="form-control" {{attrs}}>{{value}}</textarea>',
    'file' => '<input type="file" class="btn btn-light" name="{{name}}"{{attrs}}>',
    'radio' => '<input type="radio" class="form-check-input" name="{{name}}" value="{{value}}"{{attrs}}>',
    'radioWrapper' => '<div class="form-check">{{label}}</div>',

    'checkboxFormGroup' => '<div class="offset-sm-4">{{label}}</div>',
    'checkbox' => '<input type="checkbox" class="form-check-input" name="{{name}}" value="{{value}}"{{attrs}}>',
    'checkboxWrapper' => '<div class="form-check">{{label}}</div>',

    'inputSubmit' => '<input type="{{type}}" class="btn btn-primary" {{attrs}}/>',
    'button' => '<button class="btn btn-primary" {{attrs}}>{{text}}</button>',
];

$this->Form->setTemplates($myTemplates);

?>