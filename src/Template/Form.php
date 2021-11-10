<?php
/**
 * AVOLUTIONS
 *
 * Just another open source PHP framework.
 *
 * @copyright   Copyright (c) 2019 - 2021 AVOLUTIONS
 * @license     MIT License (https://avolutions.org/license)
 * @link        https://avolutions.org
 */

namespace Avolutions\Template;

use Avolutions\Orm\Entity;
use Avolutions\Orm\EntityConfiguration;
use Avolutions\Orm\EntityMapping;

/**
 * Form class
 *
 * Provides methods to create HTML forms with or without a Entity context.
 *
 * @author	Alexander Vogt <alexander.vogt@avolutions.org>
 * @since	0.2.0
 */
class Form
{
    /**
     * The Entity context of the form.
     *
     * @var Entity|null $Entity
     */
    private ?Entity $Entity = null;

    /**
     * The configuration of the Entity.
     *
     * @var EntityConfiguration|null $EntityConfiguration
     */
    private ?EntityConfiguration $EntityConfiguration = null;

    /**
     * The mapping of the Entity.
     *
     * @var EntityMapping|null $EntityMapping
     */
    private ?EntityMapping $EntityMapping = null;

    /**
     * The name of the Entity.
     *
     * @var string|null $entityName
     */
    private ?string $entityName = null;

    /**
     * Validation error messages.
     *
     * @var array $errors
     */
    private array $errors = [];

    /**
     * __construct
     *
     * Creates a new Form instance. If a Entity is given the method loads
     * the EntityConfiguration and EntityMapping automatically.
     *
     * @param Entity|null $Entity $Entity The Entity context of the form.
     * @param array $errors Validation error messages.
     */
    public function __construct(?Entity $Entity = null, array $errors = [])
    {
        if ($Entity instanceof Entity) {
            $this->Entity = $Entity;
            $this->errors = $Entity->getErrors();
            $this->entityName = $this->Entity->getEntityName();
            $this->EntityConfiguration = new EntityConfiguration($this->entityName);
            $this->EntityMapping = $this->EntityConfiguration->getMapping();
        }

        if (is_array($errors)) {
            $this->errors = array_merge($this->errors, $errors);
        }
    }

    /**
     * inputFor
     *
     * Creates a HTML input element for the given Entity field depending on
     * the Mapping of this field.
     *
     * @param string $fieldName The field of the Entity.
     * @param array $attributes The attributes for the input element.
     *
     * @return string A HTML input element for the field.
     */
    public function inputFor(string $fieldName, array $attributes = []): string
    {
        $input = '';

        $attributes['name'] = lcfirst($this->entityName).'['.$fieldName.']';
        $attributes['value'] = $this->Entity->$fieldName;

        $inputType = $this->EntityMapping->$fieldName['form']['type'];

        switch ($inputType) {
            case 'select':
                $options = $this->EntityMapping->$fieldName['form']['options'] ?? [];
                $input .= $this->select($options, $attributes);
                break;

            case 'textarea':
                $input .= $this->textarea($attributes);
                break;

            default:
                $input .= $this->input($inputType, $attributes);
                break;
        }

        return $input;
    }

    /**
     * errorFor
     *
     * TODO
     *
     * @param string $fieldName TODO
     * @return string TODO
     */
    public function errorFor(string $fieldName): string
    {
        $error = '';

        foreach ($this->errors[$fieldName] ?? [] as $message) {
            $error .= '<div class="error">'.$message.'</div>';
        }

        return $error;
    }

    public function elementFor(string $fieldName): string
    {
        $element = '';

        $element .= $this->labelFor($fieldName);
        $element .= $this->inputFor($fieldName);
        $element .= $this->helpFor($fieldName);
        $element .= $this->errorFor($fieldName);

        return $element;
    }

    /**
     * error
     *
     * Creates a div with validation error message for an input field.
     *
     * @param array $messages The error messages to display.
     *
     * @return string A div with error message.
     */
    public function error(array $messages): string
    {
        $error = '';

        foreach ($messages as $message) {
            $error .= '<div class="error">'.$message.'</div>';
        }

        return $error;
    }

    /**
     * labelFor
     *
     * Creates a HTML label element for the given Entity field depending on
     * the Mapping for this field.
     *
     * @param string $fieldName The field of the Entity.
     *
     * @return string A HTML label element depending for the field.
     */
    public function labelFor(string $fieldName): string
    {
        $label = $this->EntityMapping->$fieldName['form']['label'] ?? $fieldName;

        return $this->label($label);
    }

    /**
     * helpFor
     *
     * TODO
     *
     * @param string $fieldName The field of the Entity.
     *
     * @return string TODO
     */
    public function helpFor(string $fieldName): string
    {
        $help = $this->EntityMapping->$fieldName['form']['help'] ?? '';

        return '<div class="help">'.$help.'</div>';
    }

    /**
	 * generate
	 *
	 * Generates a Form for all fields of the Entity, depending on
     * the Mapping of the Entity.
     *
     * @param array $formAttributes The attributes for the opening form tag.
     * @param bool $submitButton Indicates if a submit button should be generated automatically.
     *
     * @return string A HTML form for the Entity.
	 */
    public function generate(array $formAttributes = [], bool $submitButton = true): string
    {
        $formFields = $this->EntityMapping->getFormFields();

        $form = $this->open($formAttributes);
        foreach (array_keys($formFields) as $formField) {
            $form .= $this->elementFor($formField);
        }
        if ($submitButton) {
            $form .= $this->submit();
        }
        $form .= $this->close();

        return $form;
    }

    /**
	 * open
	 *
	 * Opens a form.
     *
     * @param array $attributes The attributes for the form tag.
     *
     * @return string An opening HTML form tag.
	 */
    public function open(array $attributes = []): string
    {
        $Template = new Template('form/open.php', ['attributes' => $attributes]);
        return $Template->render();
    }

    /**
	 * close
	 *
	 * Close a form.
     *
     * @return string A closing HTML form tag.
	 */
    public function close(): string
    {
        $Template = new Template('form/close.php');
        return $Template->render();
    }

    /**
	 * checkbox
	 *
	 * Creates a HTML input element of type checkbox.
     *
     * @param array $attributes The attributes for the input tag.
     *
     * @return string A HTML input element of type checkbox.
	 */
    public function checkbox(array $attributes = []): string
    {
        return $this->input('checkbox', $attributes);
    }

    /**
	 * color
	 *
	 * Creates a HTML input element of type color.
     *
     * @param array $attributes The attributes for the input tag.
     *
     * @return string A HTML input element of type color.
	 */
    public function color(array $attributes = []): string
    {
        return $this->input('color', $attributes);
    }

    /**
	 * date
	 *
	 * Creates a HTML input element of type date.
     *
     * @param array $attributes The attributes for the input tag.
     *
     * @return string A HTML input element of type date.
	 */
    public function date(array $attributes = []): string
    {
        return $this->input('date', $attributes);
    }

    /**
	 * datetime
	 *
	 * Creates a HTML input element of type datetime-local.
     *
     * @param array $attributes The attributes for the input tag.
     *
     * @return string A HTML input element of type datetime-local.
	 */
    public function datetime(array $attributes = []): string
    {
        return $this->input('datetime-local', $attributes);
    }

    /**
	 * email
	 *
	 * Creates a HTML input element of type email.
     *
     * @param array $attributes The attributes for the input tag.
     *
     * @return string A HTML input element of type email.
	 */
    public function email(array $attributes = []): string
    {
        return $this->input('email', $attributes);
    }

    /**
	 * file
	 *
	 * Creates a HTML input element of type file.
     *
     * @param array $attributes The attributes for the input tag.
     *
     * @return string A HTML input element of type file.
	 */
    public function file(array $attributes = []): string
    {
        return $this->input('file', $attributes);
    }

    /**
	 * hidden
	 *
	 * Creates a HTML input element of type hidden.
     *
     * @param array $attributes The attributes for the input tag.
     *
     * @return string A HTML input element of type hidden.
	 */
    public function hidden(array $attributes = []): string
    {
        return $this->input('hidden', $attributes);
    }

    /**
	 * image
	 *
	 * Creates a HTML input element of type image.
     *
     * @param array $attributes The attributes for the input tag.
     *
     * @return string A HTML input element of type image.
	 */
    public function image(array $attributes = []): string
    {
        return $this->input('image', $attributes);
    }

    /**
     * label
     *
     * Creates a HTML label element.
     *
     * @param string $text The text of the label element.
     * @param array $attributes The attributes for the label tag.
     *
     * @return string A HTML input element of type image.
     */
    public function label(string $text, array $attributes = []): string
    {
        $Template = new Template('form/type/label.php', ['text' => $text, 'attributes' => $attributes]);
        return $Template->render();
    }

    /**
	 * month
	 *
	 * Creates a HTML input element of type month.
     *
     * @param array $attributes The attributes for the input tag.
     *
     * @return string A HTML input element of type month.
	 */
    public function month(array $attributes = []): string
    {
        return $this->input('month', $attributes);
    }

    /**
	 * number
	 *
	 * Creates a HTML input element of type number.
     *
     * @param array $attributes The attributes for the input tag.
     *
     * @return string A HTML input element of type number.
	 */
    public function number(array $attributes = []): string
    {
        return $this->input('number', $attributes);
    }

    /**
	 * password
	 *
	 * Creates a HTML input element of type password.
     *
     * @param array $attributes The attributes for the input tag.
     *
     * @return string A HTML input element of type password.
	 */
    public function password(array $attributes = []): string
    {
        return $this->input('password', $attributes);
    }

    /**
	 * radio
	 *
	 * Creates a HTML input element of type radio.
     *
     * @param array $attributes The attributes for the input tag.
     *
     * @return string A HTML input element of type radio.
	 */
    public function radio(array $attributes = []): string
    {
        return $this->input('radio', $attributes);
    }

    /**
	 * range
	 *
	 * Creates a HTML input element of type range.
     *
     * @param array $attributes The attributes for the input tag.
     *
     * @return string A HTML input element of type range.
	 */
    public function range(array $attributes = []): string
    {
        return $this->input('range', $attributes);
    }

    /**
	 * reset
	 *
	 * Creates a HTML input element of type reset.
     *
     * @param array $attributes The attributes for the input tag.
     *
     * @return string A HTML input element of type reset.
	 */
    public function reset(array $attributes = []): string
    {
        return $this->input('reset', $attributes);
    }

    /**
	 * search
	 *
	 * Creates a HTML input element of type search.
     *
     * @param array $attributes The attributes for the input tag.
     *
     * @return string A HTML input element of type search.
	 */
    public function search(array $attributes = []): string
    {
        return $this->input('search', $attributes);
    }

    /**
	 * submit
	 *
	 * Creates a HTML input element of type submit.
     *
     * @param array $attributes The attributes for the input tag.
     *
     * @return string A HTML input element of type submit.
	 */
    public function submit(array $attributes = []): string
    {
        return $this->input('submit', $attributes);
    }

    /**
	 * tel
	 *
	 * Creates a HTML input element of type tel.
     *
     * @param array $attributes The attributes for the input tag.
     *
     * @return string A HTML input element of type tel.
	 */
    public function tel(array $attributes = []): string
    {
        return $this->input('tel', $attributes);
    }

    /**
	 * text
	 *
	 * Creates a HTML input element of type text.
     *
     * @param array $attributes The attributes for the input tag.
     *
     * @return string A HTML input element of type text.
	 */
    public function text(array $attributes = []): string
    {
        return $this->input('text', $attributes);
    }

    /**
	 * time
	 *
	 * Creates a HTML input element of type time.
     *
     * @param array $attributes The attributes for the input tag.
     *
     * @return string A HTML input element of type time.
	 */
    public function time(array $attributes = []): string
    {
        return $this->input('time', $attributes);
    }

    /**
	 * url
	 *
	 * Creates a HTML input element of type url.
     *
     * @param array $attributes The attributes for the input tag.
     *
     * @return string A HTML input element of type url.
	 */
    public function url(array $attributes = []): string
    {
        return $this->input('url', $attributes);
    }

    /**
	 * week
	 *
	 * Creates a HTML input element of type week.
     *
     * @param array $attributes The attributes for the input tag.
     *
     * @return string A HTML input element of type week.
	 */
    public function week(array $attributes = []): string
    {
        return $this->input('week', $attributes);
    }

    /**
     * input
     *
     * Creates a HTML input element.
     *
     * @param string $type The type for the input tag.
     * @param array $attributes The attributes for the input tag.
     *
     * @return string A HTML input element of given type.
     */
    public function input(string $type, array $attributes = []): string
    {
        $attributes['type'] = $type;

        $Template = new Template('form/type/input.php', ['attributes' => $attributes]);
        return $Template->render();
    }

    /**
	 * button
	 *
	 * Creates a HTML button element.
     *
     * @param array $attributes The attributes for the button tag.
     *
     * @return string A HTML element of type button.
	 */
    public function button(array $attributes = []): string
    {
        $value = $attributes['value'] ?? null;
        unset($attributes['value']); // To not render it as attribute

        $Template = new Template('form/type/button.php', ['value' => $value, 'attributes' => $attributes]);
        return $Template->render();
    }

    /**
	 * textarea
	 *
	 * Creates a HTML textarea element.
     *
     * @param array $attributes The attributes for the textarea tag.
     *
     * @return string A HTML element of type textarea.
	 */
    public function textarea(array $attributes = []): string
    {
        $value = $attributes['value'] ?? null;
        unset($attributes['value']); // To not render it as attribute

        $Template = new Template('form/type/textarea.php', ['value' => $value, 'attributes' => $attributes]);
        return $Template->render();
    }

    /**
	 * select
	 *
	 * Creates a HTML select element with the given options.
     *
     * @param array $options The options for the select list.
     * @param array $attributes The attributes for the select tag.
     *
     * @return string A HTML element of type select.
	 */
    public function select(array $options = [], array $attributes = []): string
    {
        $selectedValue = $attributes['value'] ?? null;
        unset($attributes['value']); // To not render it to the select tag

        $Template = new Template('form/type/select.php', ['options' => $options, 'attributes' => $attributes, 'selectedValue' => $selectedValue]);
        return $Template->render();
    }
}