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
                function bootstrapField(el) {
                    var group = el.parent('.input-group');
                    return group.length? group : el;
                }
                $('#$id').validate({
                    errorPlacement: function(error, el) {
                        bootstrapField(el).after(error);
                    },
                    highlight: function(el, error, valid) {
                        bootstrapField($(el)).addClass(error).removeClass(valid)
                            .parent().addClass(error+'-block').removeClass(valid+'-block');
                    },
                    unhighlight: function(el, error, valid) {
                        bootstrapField($(el)).removeClass(error).addClass(valid)
                            .parent().removeClass(error+'-block').addClass(valid+'-block');
                    }
                });
            </script>
HTML;
    }

    public function labelInput($name, $label, $type = 'text', $value = null, array $options = []) {
        foreach (['label', 'input'] as $tag) {
            if (!isset($options[$tag])) {
                $options[$tag] = [];
            }
        }

        return $this->group(
            $this->label($name, $label, $options['label']),
            $this->input($type, $name, $value, $options['input']),
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

        if (!in_array($type, ['submit', 'reset', 'button'])) {
            $options['class'] = isset($options['class'])? $options['class'].' form-control' : 'form-control';
        }

        $html .= parent::input($type, $name, $value, $options);

        if (isset($options['postfix'])) {
            $group = true;
            $html .= "<div class='input-group-addon'>{$options['prefix']}</div>";
        }

        return $group? "<div class='input-group'>$html</div>" : $html;
    }

//TODO: these two methods could be sent into Laravalid\FormBuilder if we can find a way to put the required-field title into the config files

    public function label($name, $value = null, $options = []) {
        $this->labels[] = $name;

        $options = $this->html->attributes($options);
        $value   = e($this->formatLabel($name, $value));

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
