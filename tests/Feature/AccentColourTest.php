<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Process;
use Symfony\Component\Finder\SplFileInfo;

uses(RefreshDatabase::class);

it('defines the five accent presets with the green default first', function () {
    expect(collect(config('portfolio.accent_presets'))->pluck('hex')->all())
        ->toBe(['#2ECC71', '#9F2ECC', '#0009FF', '#CC2E2E', '#FFA200']);
});

it('renders no hardcoded green fill or stroke on the homepage', function () {
    $html = $this->get(route('home'))->assertOk()->getContent();

    expect(preg_match_all('/(fill|stroke|stop-color)="#2ecc71"/i', $html))->toBe(0)
        ->and(stripos($html, 'currentColor'))->toBeInt();
});

it('keeps icon assets free of hardcoded green except the preset swatch previews', function () {
    $svgFiles = collect([public_path('images/figma'), resource_path('svg')])
        ->flatMap(fn (string $directory) => File::allFiles($directory))
        ->filter(fn (SplFileInfo $file) => $file->getExtension() === 'svg')
        ->reject(fn (SplFileInfo $file) => str_starts_with($file->getFilename(), 'pop-swatch'));

    expect($svgFiles)->not->toBeEmpty()
        ->and($svgFiles->filter(fn (SplFileInfo $file) => stripos(File::get($file->getPathname()), '#2ecc71') !== false)->map->getFilename()->all())
        ->toBe([]);
});

it('renders monochrome png icons as accent masks on the homepage', function () {
    $this->get(route('home'))
        ->assertOk()
        ->assertSee('themed-image--mask', false);
});

it('renders the internship logos from isolated files and no longer from the logo sheet', function () {
    $html = $this->get(route('home'))->assertOk()->getContent();

    expect($html)->not->toContain('sourceImageCrop');

    foreach (config('portfolio.internship_logos') as $logo) {
        expect(file_exists(public_path($logo['light'])))->toBeTrue()
            ->and(file_exists(public_path($logo['dark'])))->toBeTrue();
    }
});

/**
 * Runs the real preferences contrast module in Node and returns the chosen inks with their backgrounds.
 *
 * @param  list<string>  $accents
 * @return array<string, array{ink: string, accent: string, softLight: array{ink: string, background: string}, softDark: array{ink: string, background: string}}>
 */
function accentInksFromModule(array $accents): array
{
    $moduleUrl = 'file://'.str_replace(' ', '%20', resource_path('js/accent-contrast.js'));
    $script = <<<'JS'
        const { pickInk, mixHex } = await import(process.argv[1]);
        const surfaces = { light: '#FFFFFF', dark: '#000B1D' };
        const result = {};
        for (const accent of process.argv.slice(2)) {
            const tint = (surface) => {
                const background = mixHex(accent, surface, 0.15);

                return { ink: pickInk(background), background };
            };
            result[accent] = {
                ink: pickInk(accent),
                accent,
                softLight: tint(surfaces.light),
                softDark: tint(surfaces.dark),
            };
        }
        process.stdout.write(JSON.stringify(result));
        JS;

    $process = Process::run(array_merge(
        ['node', '--input-type=module', '-e', $script, $moduleUrl],
        $accents,
    ));

    expect($process->successful())->toBeTrue($process->errorOutput());

    return json_decode($process->output(), true, 512, JSON_THROW_ON_ERROR);
}

/**
 * WCAG 2.x contrast ratio, implemented independently of the JavaScript module.
 */
function wcagContrastRatio(string $firstHex, string $secondHex): float
{
    $linear = function (int $channel): float {
        $value = $channel / 255;

        return $value <= 0.03928 ? $value / 12.92 : (($value + 0.055) / 1.055) ** 2.4;
    };

    $luminance = function (string $hex) use ($linear): float {
        [$red, $green, $blue] = array_map(fn (string $pair) => $linear(hexdec($pair)), str_split(ltrim($hex, '#'), 2));

        return 0.2126 * $red + 0.7152 * $green + 0.0722 * $blue;
    };

    [$lighter, $darker] = array_values(collect([$luminance($firstHex), $luminance($secondHex)])->sortDesc()->all());

    return ($lighter + 0.05) / ($darker + 0.05);
}

it('chooses a text ink that reaches WCAG AA on every preset and custom accent and its tints', function (string $accent) {
    $inks = accentInksFromModule([$accent]);
    $result = $inks[$accent];

    expect(wcagContrastRatio($result['ink'], $result['accent']))->toBeGreaterThanOrEqual(4.5)
        ->and(wcagContrastRatio($result['softLight']['ink'], $result['softLight']['background']))->toBeGreaterThanOrEqual(4.5)
        ->and(wcagContrastRatio($result['softDark']['ink'], $result['softDark']['background']))->toBeGreaterThanOrEqual(4.5);
})->with([
    'preset green' => ['#2ECC71'],
    'preset purple' => ['#9F2ECC'],
    'preset blue' => ['#0009FF'],
    'preset red' => ['#CC2E2E'],
    'preset orange' => ['#FFA200'],
    'custom light blue' => ['#00AAFF'],
    'custom yellow' => ['#FFEB3B'],
    'custom near black' => ['#101010'],
]);
