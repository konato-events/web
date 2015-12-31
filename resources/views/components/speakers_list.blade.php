<?php
/** @var \App\Models\User[] $speakers */
/*
$details = <<<HTML
    <!--
        <span><?//=__('%d event on theme', '%d events on theme', $on_theme)?></span>
        <span><?//=__('%d event total', '%d events total', $total)?></span>
    -->
HTML;
*/
?>
@include('components.users_list', ['users' => $speakers, 'class' => 'speakers'])
