<?php

declare(strict_types=1);

namespace Tests;

use App\Console\Kernel;
use App\Core\App;
use App\Core\DB;
use App\Core\Request;
use PHPUnit\Framework\TestCase;

final class ScheduledPostsTest extends TestCase
{
    private string $slug;

    protected function setUp(): void
    {
        try {
            DB::value('SELECT COUNT(*) FROM posts');
        } catch (\Throwable) {
            $this->markTestSkipped('Base de datos no disponible');
        }
        $this->slug = 'programado-' . bin2hex(random_bytes(3));
    }

    protected function tearDown(): void
    {
        if (isset($this->slug)) {
            DB::run('DELETE FROM posts WHERE slug = :s', ['s' => $this->slug]);
        }
    }

    private function insert(string $publishedAt): void
    {
        DB::insert('posts', [
            'type' => 'post', 'locale' => 'es', 'translation_group' => 'test-' . $this->slug, 'slug' => $this->slug,
            'title' => 'Entrada programada', 'excerpt' => 'x', 'content_html' => '<p>Contenido de prueba.</p>', 'content_text' => 'Contenido de prueba.',
            'status' => 'scheduled', 'published_at' => $publishedAt,
        ]);
    }

    public function testScheduledPostIsHiddenUntilItsTime(): void
    {
        $this->insert(gmdate('Y-m-d H:i:s', time() + 3600));
        $this->assertSame(404, App::handle(Request::create('GET', "/{$this->slug}/"))->status);

        ob_start();
        (new Kernel())->run(['posts:publish-due']);
        ob_end_clean();
        $this->assertSame('scheduled', DB::value('SELECT status FROM posts WHERE slug = :s', ['s' => $this->slug]));
    }

    public function testDuePostIsPublishedByTheCommand(): void
    {
        $this->insert(gmdate('Y-m-d H:i:s', time() - 60));
        $this->assertSame(404, App::handle(Request::create('GET', "/{$this->slug}/"))->status);

        ob_start();
        (new Kernel())->run(['posts:publish-due']);
        ob_end_clean();
        $this->assertSame('published', DB::value('SELECT status FROM posts WHERE slug = :s', ['s' => $this->slug]));
        $this->assertSame(200, App::handle(Request::create('GET', "/{$this->slug}/"))->status);
    }
}
