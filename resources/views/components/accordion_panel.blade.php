<?php
    global $accordion_index;
    $accordion_index = ($accordion_index === null)? 0 : $accordion_index+1;
    $open = isset($open)? $open : false;
    /** @var array $checklist */
    /** @var array $field_attr */
?>

<div class="panel panel-default">
    <div class="panel-heading" role="tab" id="accordionHeading{{$accordion_index}}">
        <h4 class="panel-title">
            <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse{{$accordion_index}}"
               aria-expanded="false" aria-controls="collapse{{$accordion_index}}">
                {{$title}}
            </a>
        </h4>
    </div>
    <div id="collapse{{$accordion_index}}" class="panel-collapse collapse<?php if (!$open) {?> in<?php } ?>>"
         role="tabpanel" aria-labelledby="accordionHeading{{$accordion_index}}">
        <div class="panel-body container-fluid">
            @if (isset($checklist))
                <?php $buttons = (isset($checklist_buttons) && $checklist_buttons); ?>
                <div <?=$buttons? 'class="btn-group" data-toggle="buttons"' : 'class="checkbox"'?>>
                    <?php foreach($checklist[0] as $id => $value):
                        $check = in_array($id, $checklist[1]);?>
                        <label <?php if ($buttons) echo 'class="btn btn-default '.($check? 'active':'').'"' ?>>
                            <input type="checkbox" name="{{$name}}" value="{{$id}}" <?=$check? 'checked':''?>> {{$value}}
                        </label>
                    <?php endforeach ?>
                </div>
            @endif

            @if (isset($field))
                <?php
                    $attrs = [];
                    foreach($field_attr as $attr => $value) {
                        $attrs[] = "$attr='$value'";
                    }
                    $attrs = join(' ', $attrs);
                ?>
                <input {!! $attrs !!} value="{{$field}}" />
            @endif

            @if (isset($content))
                {!! $content !!}
            @endif
        </div>
    </div>
</div>