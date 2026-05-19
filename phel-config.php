<?php
use Phel\Config\PhelConfig;

return (new PhelConfig())
    ->withSrcDirs(['src'])
    ->withTestDirs(['tests']);
