<?php

namespace App\Actions;

use App\Models\ShellScript;
use RuntimeException;

class ImportShellScripts
{
    /**
     * Upserts every .sh file in a directory as a shell script. The file name is the script name and the file content
     * is the code. Optional header lines in the file provide the rest: "# title: ...", "# description: ...",
     * "# title-en: ..." and "# description-en: ..." (the English texts), "# package: ..." (the package the script needs),
     * "# install: ..." (the command that installs it on Arch) and "# install-debian: ..." (the command that installs it
     * on Debian). A script that is already stored is updated instead of duplicated, so the import can be run again safely.
     *
     * @param  string  $directory  A directory containing .sh files.
     */
    public function handle(string $directory): void
    {
        if (! is_dir($directory)) {
            throw new RuntimeException("Shell scripts directory not found: {$directory}");
        }

        $files = glob(rtrim($directory, '/').'/*.sh') ?: [];
        sort($files);

        foreach ($files as $file) {
            $code = file_get_contents($file);

            ShellScript::query()->updateOrCreate(
                ['name' => basename($file)],
                [
                    'title' => $this->headerValue($code, 'title'),
                    'title_en' => $this->headerValue($code, 'title-en'),
                    'description' => $this->headerValue($code, 'description'),
                    'description_en' => $this->headerValue($code, 'description-en'),
                    'package' => $this->headerValue($code, 'package'),
                    'install_command' => $this->headerValue($code, 'install'),
                    'install_command_debian' => $this->headerValue($code, 'install-debian'),
                    'code' => $this->codeWithoutHeaders($code),
                ],
            );
        }
    }

    /**
     * Returns the script without its "# title:", "# description:", "# package:" and "# install:" lines, including the
     * English title and description lines, so only the
     * actual script is shown in the code block. The shebang line is kept, and leading blank lines left behind are removed.
     */
    private function codeWithoutHeaders(string $code): string
    {
        return ltrim(preg_replace('/^#\s*(?:title(?:-en)?|description(?:-en)?|package|install(?:-debian)?):.*\R?/mi', '', $code), "\r\n");
    }

    /**
     * Returns the value of the first "# <key>: ..." line, or null when the script has no such line.
     */
    private function headerValue(string $code, string $key): ?string
    {
        if (preg_match('/^#\s*'.preg_quote($key, '/').':\s*(.+)$/mi', $code, $matches) !== 1) {
            return null;
        }

        return trim($matches[1]);
    }
}
