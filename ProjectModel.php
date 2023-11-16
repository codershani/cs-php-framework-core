<?php

namespace app\core;
use app\core\db\DbModel;

abstract class ProjectModel extends DbModel
{
    abstract public function getDisplayVideos(): array;

    // abstract public function editVideo($id = []);

    // abstract public function deleteVideo();


}