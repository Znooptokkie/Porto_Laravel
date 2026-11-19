<?php

namespace App\Enums;

/**
 * The keywords a card of the Linux commands page can be filtered on. The value is stored with the command.
 */
enum LinuxCommandKeyword: string
{
    case Bash = 'bash';
    case Git = 'git';
    case Ssh = 'ssh';
    case Linux = 'linux';
    case Php = 'php';
    case Python = 'python';
    case JavaScript = 'javascript';
    case Laravel = 'laravel';
    case Npm = 'npm';
    case Django = 'django';
    case Docker = 'docker';
    case Sql = 'sql';
    case Networking = 'networking';
    case Nginx = 'nginx';

    /**
     * The text shown on the page.
     */
    public function label(): string
    {
        return match ($this) {
            self::Ssh => 'SSH',
            self::Php => 'PHP',
            self::Npm => 'NPM',
            self::Sql => 'SQL',
            default => $this->name,
        };
    }
}
