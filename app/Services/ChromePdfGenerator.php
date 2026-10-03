<?php

namespace App\Services;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use RuntimeException;
use Symfony\Component\Process\Process;

class ChromePdfGenerator
{
    public function fromView(string $view, array $data, string $fileName): Response
    {
        $html = view($view, $data)->render();

        $workDir = storage_path('app/tmp-pdf/' . Str::uuid());
        File::ensureDirectoryExists($workDir . '/profile');

        $htmlPath = $workDir . DIRECTORY_SEPARATOR . 'katalog.html';
        $pdfPath  = $workDir . DIRECTORY_SEPARATOR . 'katalog.pdf';

        File::put($htmlPath, $html);

        $process = new Process([
            $this->chromeBinary(),
            '--headless',
            '--disable-gpu',
            '--no-sandbox',
            '--disable-extensions',
            '--disable-background-networking',
            '--no-first-run',
            '--no-default-browser-check',
            '--user-data-dir=' . $workDir . DIRECTORY_SEPARATOR . 'profile',
            '--no-pdf-header-footer',
            '--print-to-pdf=' . $pdfPath,
            'file:///' . str_replace('\\', '/', $htmlPath),
        ]);
        $process->setTimeout(90);

        try {
            $process->run();

            if (! File::exists($pdfPath) || File::size($pdfPath) === 0) {
                throw new RuntimeException(
                    'PDF gagal dibuat. Output Chrome: ' .
                    trim($process->getErrorOutput() . ' ' . $process->getOutput())
                );
            }

            $pdf = File::get($pdfPath);
        } finally {
            if ($process->isRunning()) {
                $process->stop(3);
            }
            try {
                File::deleteDirectory($workDir);
            } catch (\Throwable $e) {
                // folder temp akan dibersihkan di request berikutnya
            }
        }

        return response($pdf, 200, [
            'Content-Type'        => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
        ]);
    }

    private function chromeBinary(): string
    {
        return config('laravel-pdf.chrome.chrome_binary')
            ?: 'C:/Program Files/Google/Chrome/Application/chrome.exe';
    }
}
