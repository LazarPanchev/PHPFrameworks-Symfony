<?php /** @var $model \App\Data\UserDTO */ ?>

<h1>Welcome <?= $model->getUsername(); ?></h1>
<hr/>
<h3><?=$model->getFirstName();?> <?=$model->getLastName();?></h3>