<?php
namespace Resources;

use LaravelArdent\Laravalid\FormBuilder;

class BootstrapFormBuilder extends FormBuilder {

    /** @var \LaravelArdent\Ardent\Ardent */
    protected $model;

    /** @var string */
    protected $id;

    /** @var integer */
    protected static $counter = 0;

    public function group(...$parts) {
        return '<div class="form-group">'.join("\n", $parts).'</div>';
    }

    public function open(array $options = [], $rules = null) {
        if (isset($options['id'])) {
            $this->id = $options['id'];
            ++static::$counter;
        } else {
            $this->id = $options['id'] = 'form_'.(static::$counter++);
        }
        return parent::open($options, $rules);
    }

    public static function validationScript(string $id) {
        return <<<HTML
            <script type="text/javascript" src="/laravalid/jquery.validate.laravalid.js"></script>
            <script type="text/javascript">
                //slides errors up and then, removes the element
                $.validator.prototype.hideThese = function(errors) {
                    this.addWrapper(errors).slideUp('fast', function() { this.remove(); });
                    errors.not(this.containers).text('');
                };

                function bootstrapField(el) {
                    var group = el.parent('.input-group');
                    return group.length? group : el;
                }

                /** @see http://jqueryvalidation.org/validate/ */
                $('#$id').validate({
                    wrapper: 'p',

                    errorPlacement: function(error, el) {
                        error.hide(); //hides the error, so we can append it and then slideDown

                        var input = bootstrapField(el);
                        switch (input.attr('type')) {
                            case 'checkbox':
                                input.next('label').after(error);
                            break;

                            case 'radio': //untested!
                                input.parent().append(error);
                            break;

                            default:
                                input.after(error);
                        }
                        error.slideDown();
                    },

                    highlight: function(el, error, valid) {
                        bootstrapField($(el)).addClass(error).removeClass(valid)
                            .parent().addClass(error+'-block').removeClass(valid+'-block');
                    },
                    unhighlight: function(el, error, valid) {
                        bootstrapField($(el))
                            .removeClass(error).addClass(valid)
                            .parent().removeClass(error+'-block').addClass(valid+'-block');
                    }
                });
            </script>
HTML;
    }

    protected function normalizeInputOptions(array &$options) {
        foreach (['label', 'input'] as $tag) {
            if (!isset($options[$tag])) {
                $options[$tag] = [];
            }
        }
    }

    public function labelInput($name, $label, $type = 'text', $value = null, array $options = []) {
        if ($type == 'checkbox') {
            return $this->labelCheckbox($name, $label, $value, $options);
        }

        $this->normalizeInputOptions($options);

        return $this->group(
            $this->label($name, $label, $options['label']),
            ($type == 'textarea'?
                $this->textarea($name, $value, $options['input']) :
                $this->input($type, $name, $value, $options['input'])
            ),
            (isset($options['help'])? "<p class='help-block'>{$options['help']}</p>" : '')
        );
    }

    public function labelCheckbox($name, $label, $value = null, array $options = []) {
        $this->normalizeInputOptions($options);

        return $this->group(
            $this->hidden($name, 0),
            $this->checkbox($name, 1, $value, $options['input']),
            $this->label($name, $label, $options['label']),
            isset($options['help'])? "<p class='help-block'>{$options['help']}</p>" : ''
        );
    }

    public function labelSelect($name, $label, array $list = [], $selected = null, array $options = []) {
        $this->normalizeInputOptions($options);

        return $this->group(
            $this->label($name, $label, $options['label']),
            $this->select($name, $list, $selected, $options['input']),
            isset($options['help'])? "<p class='help-block'>{$options['help']}</p>" : ''
        );
    }

    public function input($type, $name, $value = null, $options = []) {
        $group = false;
        $html  = '';

        if (isset($options['prefix'])) {
            $group = true;
            $html .= "<div class='input-group-addon'>{$options['prefix']}</div>";
        }

        if (!in_array($type, ['submit', 'reset', 'button', 'checkbox', 'radio', 'file'])) {
            $options['class'] = isset($options['class'])? $options['class'].' form-control' : 'form-control';
        }

        $html .= parent::input($type, $name, $value, $options);

        if (isset($options['postfix'])) {
            $group = true;
            $html .= "<div class='input-group-addon'>{$options['prefix']}</div>";
        }

        return $group? "<div class='input-group'>$html</div>" : $html;
    }

    public function select($name, $list = [], $selected = null, $options = []) {
        $options['class'] = isset($options['class'])? $options['class'].' form-control' : 'form-control';
        return parent::select($name, $list, $selected, $options);
    }

    public function textarea($name, $value = null, $options = []) {
        $options['class'] = isset($options['class'])? $options['class'].' form-control' : 'form-control';
        return parent::textarea($name, $value, $options);
    }

//TODO: these two methods could be sent into Laravalid\FormBuilder if we can find a way to put the required-field title into the config files

    public function label($name, $value = null, $options = []) {
        $this->labels[] = $name;

        $options = $this->html->attributes($options);
        $value   = $this->formatLabel($name, $value);

        if ($this->isRequired($name)) {
            $value .= '<sup title="'._('Required field').'">*</sup>';
        }

        return "<label for=\"$name\" $options>$value</label>";
    }

    protected function isRequired($name) {
        if (!$this->model) {
            return null;
        }

        if ($rule = $this->converter()->getValidationRule($name)) {
            return in_array('required', $rule);
        } else {
            return false;
        }
    }
}
