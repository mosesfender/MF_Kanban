<?php
/*
 * Copyright (c) Sergey Siunov. 2024
 * @email sergey@siunov.ru
 * @link https://siunov.ru
 */

use yii\web\User;
use yii\web\View;

/**
 * @var View $this
 * @var User $user
 */

$user = \yii::$app->getUser();

prer($user,1);