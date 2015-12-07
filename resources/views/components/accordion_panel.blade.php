<?php
global $accordion_index;
$accordion_index = ($accordion_index === null)? 0 : $accordion_index+1;
$open = $open ?? false;
/** @var array $checklist */
/** @var bool $open */
/** @var array $field_attr */
?>

<div class="panel panel-default">
    <div class="panel-heading" role="tab" id="accordionHeading{{$accordion_index}}">
        <h4 class="panel-title">
            <a href="#collapse{{$accordion_index}}"
               <?=$open? '' : 'class="collapsed"'?> data-toggle="collapse" data-parent="#accordion"
               aria-expanded="<?=$open? 'true' : 'false'?>" aria-controls="collapse{{$accordion_index}}">
                {{$title}}
            </a>
        </h4>
    </div>
    <div id="collapse{{$accordion_index}}" class="panel-collapse collapse <?=$open? 'in' : ''?>"
         role="tabpanel" aria-labelledby="accordionHeading{{$accordion_index}}">
        <div class="panel-body container-fluid">
            @if (isset($checklist))
                <? $buttons = (isset($checklist_buttons) && $checklist_buttons); ?>
                <div <?=$buttons? 'class="btn-group" data-toggle="buttons"' : 'class="checkbox"'?>>
                    <?php foreach($checklist[0] as $id => $value):
                        $check = in_array($id, $checklist[1]);?>
                        <label <?php if ($buttons) echo 'class="btn btn-default '.($check? 'active':'').'"' ?>>
                            <input type="checkbox" name="{{$name}}" value="{{$id}}" <?=$check? 'checked':''?>> {{$value}}
                        </label>
                    <? endforeach ?>
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
