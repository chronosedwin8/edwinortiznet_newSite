<?php

declare(strict_types=1);

namespace Tests;

use App\Services\Kits\KitIaDocentes;
use App\Services\Kits\ZipWriter;
use PHPUnit\Framework\TestCase;

/**
 * Contenido del Kit de IA para docentes (database/kits/ia-docentes): estructura válida para `kit:build`.
 */
final class KitIaDocentesTest extends TestCase
{
    public function testCommonChaptersAreComplete(): void
    {
        $common = KitIaDocentes::common();
        foreach (['como_usar_html', 'anatomia_html', 'plantilla_maestra', 'verificacion', 'privacidad_html', 'politica_aula_html', 'herramientas_html', 'dua_html', 'dua_prompts', 'glosario'] as $key) {
            $this->assertNotEmpty($common[$key] ?? null, "Falta «{$key}» en _comun.php");
        }
        foreach (KitIaDocentes::duaPrompts($common) as $p) {
            $this->assertNotSame('', $p['titulo']);
            $this->assertStringContainsString('[', $p['prompt']);
        }
    }

    public function testEverySubjectFilePresentIsValid(): void
    {
        $common = KitIaDocentes::common();
        $found = 0;
        foreach (KitIaDocentes::SUBJECTS as $key) {
            $kit = KitIaDocentes::load($key);
            if ($kit === null) {
                continue;
            }
            $found++;
            $this->assertSame($key, $kit['key']);
            $this->assertSame([], KitIaDocentes::validate($kit), "Contenido inválido en $key.php");
            $this->assertGreaterThanOrEqual(24, count($kit['recetas']), "$key: se esperan al menos 24 recetas");
            foreach ($kit['rubricas'] as $rubrica) {
                foreach ($rubrica['criterios'] as $c) {
                    $this->assertSame(['Superior', 'Alto', 'Básico', 'Bajo'], array_keys($c['niveles']), "$key: niveles de «{$rubrica['titulo']}»");
                }
            }
            $txt = KitIaDocentes::promptsTxt($kit, $common);
            $this->assertStringStartsWith("\xEF\xBB\xBF", $txt);
            $this->assertTrue(mb_check_encoding($txt, 'UTF-8'));
            foreach ($kit['recetas'] as $r) {
                $this->assertStringContainsString($r['id'] . ' · ', $txt);
            }
        }
        $this->assertGreaterThan(0, $found, 'No hay ninguna materia en database/kits/ia-docentes');
    }

    public function testZipWriterProducesAReadableArchive(): void
    {
        $bytes = (new ZipWriter())->add('Guía - Matemáticas.txt', str_repeat('prompt ', 200))->add('LEEME.txt', 'hola')->bytes(1760000000);
        $this->assertStringStartsWith("PK\x03\x04", $bytes);
        // Fin del directorio central: 2 entradas.
        $eocd = substr($bytes, -22);
        $this->assertSame(0x06054b50, unpack('V', substr($eocd, 0, 4))[1]);
        $this->assertSame(2, unpack('v', substr($eocd, 10, 2))[1]);
        // La primera entrada se descomprime al contenido original.
        $h = unpack('Vsig/vver/vflag/vmethod/vtime/vdate/Vcrc/Vcsize/Vsize/vnlen/velen', substr($bytes, 0, 30));
        $this->assertSame(0x0800, $h['flag'] & 0x0800);
        $name = substr($bytes, 30, $h['nlen']);
        $this->assertSame('Guía - Matemáticas.txt', $name);
        $data = substr($bytes, 30 + $h['nlen'] + $h['elen'], $h['csize']);
        $plain = $h['method'] === 8 ? gzinflate($data) : $data;
        $this->assertSame(str_repeat('prompt ', 200), $plain);
        $this->assertSame(crc32($plain), $h['crc']);
    }
}
