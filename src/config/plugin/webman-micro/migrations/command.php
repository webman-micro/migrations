<?php
/**
 * This file is part of workbunny.
 *
 * Redistributions of files must retain the above copyright notice.
 *
 * @author    chaz6chez<chaz6chez1993@outlook.com>
 * @copyright chaz6chez<chaz6chez1993@outlook.com>
 * @link      https://github.com/workbunny/webman-push-server
 * @license   https://github.com/workbunny/webman-push-server/blob/main/LICENSE
 */
declare(strict_types=1);

return [
    WebmanMicro\Migrations\Command\Breakpoint::class,
    WebmanMicro\Migrations\Command\Create::class,
    WebmanMicro\Migrations\Command\Migrate::class,
    WebmanMicro\Migrations\Command\Rollback::class,
    WebmanMicro\Migrations\Command\SeedCreate::class,
    WebmanMicro\Migrations\Command\SeedRun::class,
    WebmanMicro\Migrations\Command\Status::class,
    WebmanMicro\Migrations\Command\ListAliases::class,
    WebmanMicro\Migrations\Command\Test::class
];
