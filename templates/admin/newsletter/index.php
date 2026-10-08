<?php
/** @var array $settings @var array|null $open @var array|null $stats @var int|null $due @var int $recipients @var array $byLocale
 *  @var array $profile @var string $locale @var int $width @var string $previewUrl @var int|null $newPosts @var string $adminEmail */

use App\Core\View;
use App\Services\Newsletter\Interests;
use App\Services\Newsletter\NewsletterSettings as NS;

$localeSplit = implode(' · ', array_map(fn ($r) => strtoupper((string) $r['locale']) . ' ' . (int) $r['n'], $byLocale));
$needsApproval = $open !== null && $settings['mode'] === 'approval' && $open['approved_at'] === null;
?>
<?= View::render('admin/newsletter/tabs', ['current' => 'index']) ?>

<div class="nl-layout">
<div>
  <section class="panel">
    <div class="panel__head">
      <h2><?= e(t('admin.nl.next')) ?></h2>
      <?php if ($open): ?><span class="tag tag--<?= e($open['status']) ?>"><?= e(t('admin.nl.status.' . $open['status'])) ?></span>
      <?php elseif (!$settings['enabled']): ?><span class="tag tag--cancelled"><?= e(t('admin.nl.off')) ?></span><?php endif; ?>
    </div>

    <?php if ($open): ?>
    <p class="nl-when"><?= e(NS::local($open['scheduled_for'], 'd/m/Y g:i a')) ?> <small class="muted"><?= e(t('admin.nl.tz')) ?></small></p>
    <?php if ($needsApproval): ?><p class="tag tag--warn tag--plain"><?= e(t('admin.nl.needs_approval')) ?></p><?php endif; ?>
    <dl class="nl-facts">
      <dt><?= e(t('admin.nl.issue')) ?></dt><dd><code><?= e($open['issue_key']) ?></code></dd>
      <dt><?= e(t('admin.nl.recipients')) ?></dt><dd><?= e(t('admin.nl.recipients_n', ['n' => $open['status'] === 'sending' ? (int) $open['recipients'] : $recipients])) ?><?= $localeSplit !== '' && $open['status'] !== 'sending' ? ' (' . e($localeSplit) . ')' : '' ?></dd>
      <dt><?= e(t('admin.nl.new_posts')) ?></dt><dd><?= e(t('admin.nl.new_posts_n', ['n' => (int) $newPosts, 'date' => NS::local($open['since_at'], 'd/m/Y')])) ?></dd>
      <dt><?= e(t('admin.nl.intro')) ?></dt><dd><?= e(t('admin.nl.intro_source.' . $open['intro_source'])) ?></dd>
      <dt><?= e(t('admin.nl.preview_mail')) ?></dt><dd><?= $open['preview_sent_at'] ? e(NS::local($open['preview_sent_at'], 'd/m/Y g:i a')) : e(t('admin.nl.preview_pending')) ?></dd>
    </dl>

    <?php if ($open['status'] === 'sending' && $stats): ?>
    <p><?= e(t('admin.nl.progress', ['sent' => (int) $stats['sent'], 'total' => (int) $stats['total'], 'pending' => (int) $stats['pending'], 'failed' => (int) $stats['failed']])) ?></p>
    <form method="post" action="<?= e(route('admin.newsletter.action', ['id' => $open['id']])) ?>" data-confirm="<?= e(t('admin.nl.stop_confirm')) ?>" data-confirm-ok="<?= e(t('admin.nl.stop')) ?>">
      <?= csrf_field() ?><input type="hidden" name="do" value="stop">
      <button class="btn btn--danger btn--small" type="submit"><?= e(t('admin.nl.stop')) ?></button>
    </form>
    <?php else: ?>
    <div class="nl-row">
      <?php if ($needsApproval): ?>
      <form method="post" action="<?= e(route('admin.newsletter.action', ['id' => $open['id']])) ?>"><?= csrf_field() ?><input type="hidden" name="do" value="approve"><button class="btn btn--small" type="submit"><?= icon('check') ?><?= e(t('admin.nl.approve')) ?></button></form>
      <?php endif; ?>
      <form method="post" action="<?= e(route('admin.newsletter.send_now')) ?>" data-confirm="<?= e(t('admin.nl.send_now_confirm', ['n' => $recipients])) ?>" data-confirm-ok="<?= e(t('admin.nl.send_now')) ?>"><?= csrf_field() ?><button class="btn btn--small" type="submit"><?= icon('mail') ?><?= e(t('admin.nl.send_now')) ?></button></form>
      <form method="post" action="<?= e(route('admin.newsletter.action', ['id' => $open['id']])) ?>"><?= csrf_field() ?><input type="hidden" name="do" value="postpone"><input type="hidden" name="days" value="1"><button class="btn btn--ghost btn--small" type="submit"><?= e(t('admin.nl.postpone_day')) ?></button></form>
      <form method="post" action="<?= e(route('admin.newsletter.action', ['id' => $open['id']])) ?>"><?= csrf_field() ?><input type="hidden" name="do" value="postpone"><input type="hidden" name="days" value="7"><button class="btn btn--ghost btn--small" type="submit"><?= e(t('admin.nl.postpone_week')) ?></button></form>
      <form method="post" action="<?= e(route('admin.newsletter.action', ['id' => $open['id']])) ?>"><?= csrf_field() ?><input type="hidden" name="do" value="rebuild"><button class="btn btn--ghost btn--small" type="submit" title="<?= e(t('admin.nl.rebuild_help')) ?>"><?= e(t('admin.nl.rebuild')) ?></button></form>
      <form method="post" action="<?= e(route('admin.newsletter.action', ['id' => $open['id']])) ?>" data-confirm="<?= e(t('admin.nl.cancel_confirm')) ?>" data-confirm-ok="<?= e(t('admin.nl.cancel')) ?>"><?= csrf_field() ?><input type="hidden" name="do" value="cancel"><button class="btn btn--danger btn--small" type="submit"><?= e(t('admin.nl.cancel')) ?></button></form>
    </div>
    <form class="nl-row" method="post" action="<?= e(route('admin.newsletter.action', ['id' => $open['id']])) ?>" style="margin-top:10px">
      <?= csrf_field() ?><input type="hidden" name="do" value="reschedule">
      <label for="nl-when"><?= e(t('admin.nl.reschedule')) ?></label>
      <input class="field" id="nl-when" type="datetime-local" name="when" value="<?= e(NS::local($open['scheduled_for'], 'Y-m-d\TH:i')) ?>" required>
      <button class="btn btn--ghost btn--small" type="submit"><?= e(t('admin.save')) ?></button>
    </form>
    <?php endif; ?>

    <?php else: ?>
    <?php if ($settings['enabled']): ?>
    <p class="nl-when"><?= e(NS::local(gmdate('Y-m-d H:i:s', (int) $due), 'd/m/Y g:i a')) ?> <small class="muted"><?= e(t('admin.nl.tz')) ?></small></p>
    <p class="muted"><?= e(t('admin.nl.next_help', ['date' => NS::local(gmdate('Y-m-d H:i:s', (int) $due - NS::LEAD), 'd/m/Y g:i a')])) ?></p>
    <?php else: ?>
    <p class="muted"><?= e(t('admin.nl.off_help')) ?></p>
    <?php endif; ?>
    <p class="muted"><?= e(t('admin.nl.recipients_now', ['n' => $recipients])) ?><?= $localeSplit !== '' ? ' (' . e($localeSplit) . ')' : '' ?></p>
    <div class="nl-row">
      <form method="post" action="<?= e(route('admin.newsletter.prepare')) ?>"><?= csrf_field() ?><button class="btn btn--small" type="submit"><?= e(t('admin.nl.prepare')) ?></button></form>
      <form method="post" action="<?= e(route('admin.newsletter.send_now')) ?>" data-confirm="<?= e(t('admin.nl.send_now_confirm', ['n' => $recipients])) ?>" data-confirm-ok="<?= e(t('admin.nl.send_now')) ?>"><?= csrf_field() ?><button class="btn btn--ghost btn--small" type="submit"><?= icon('mail') ?><?= e(t('admin.nl.send_now')) ?></button></form>
    </div>
    <?php endif; ?>
  </section>

  <?php if ($open && $open['status'] === 'scheduled'): ?>
  <section class="panel">
    <h2><?= e(t('admin.nl.texts')) ?></h2>
    <form method="post" action="<?= e(route('admin.newsletter.action', ['id' => $open['id']])) ?>" class="admin-form form-grid">
      <?= csrf_field() ?><input type="hidden" name="do" value="save">
      <label class="wide"><?= e(t('admin.nl.subject')) ?>
        <input type="text" name="subject" maxlength="200" value="<?= e($open['subject']) ?>">
        <small class="muted"><?= e(t($open['subject_manual'] ? 'admin.nl.subject_manual' : 'admin.nl.subject_auto')) ?></small></label>
      <label class="wide"><?= e(t('admin.nl.intro_es')) ?><textarea name="intro_es" rows="4" maxlength="800"><?= e($open['intro_es']) ?></textarea></label>
      <label class="wide"><?= e(t('admin.nl.intro_en')) ?><textarea name="intro_en" rows="4" maxlength="800"><?= e($open['intro_en']) ?></textarea></label>
      <p class="wide"><button class="btn btn--small" type="submit"><?= e(t('admin.save')) ?></button></p>
    </form>
  </section>
  <?php endif; ?>

  <section class="panel">
    <h2><?= e(t('admin.nl.test')) ?></h2>
    <p class="muted"><?= e(t('admin.nl.test_help', ['email' => $adminEmail])) ?></p>
    <form method="post" action="<?= e(route('admin.newsletter.test')) ?>" class="nl-row">
      <?= csrf_field() ?>
      <div class="chip-pick" role="group" aria-label="<?= e(t('admin.nl.profile')) ?>">
        <?php foreach (Interests::ALL as $i): ?><label><input type="checkbox" name="interests[]" value="<?= e($i) ?>"<?= in_array($i, $profile, true) ? ' checked' : '' ?>><span><?= e(t("admin.subs.interest.$i")) ?></span></label><?php endforeach; ?>
      </div>
      <select class="field" name="locale" aria-label="<?= e(t('admin.f.locale')) ?>"><option value="es">ES</option><option value="en"<?= $locale === 'en' ? ' selected' : '' ?>>EN</option></select>
      <button class="btn btn--small" type="submit"><?= icon('mail') ?><?= e(t('admin.nl.test_send')) ?></button>
    </form>
  </section>
</div>

<section class="panel">
  <h2><?= e(t('admin.nl.preview')) ?></h2>
  <form class="nl-preview-bar" method="get" action="/admin/boletin/">
    <div class="chip-pick" role="group" aria-label="<?= e(t('admin.nl.profile')) ?>">
      <?php foreach (Interests::ALL as $i): ?><label><input type="checkbox" name="perfil[]" value="<?= e($i) ?>"<?= in_array($i, $profile, true) ? ' checked' : '' ?>><span><?= e(t("admin.subs.interest.$i")) ?></span></label><?php endforeach; ?>
    </div>
    <select class="field" name="idioma" aria-label="<?= e(t('admin.f.locale')) ?>"><option value="es">ES</option><option value="en"<?= $locale === 'en' ? ' selected' : '' ?>>EN</option></select>
    <select class="field" name="ancho" aria-label="<?= e(t('admin.nl.width')) ?>"><option value="640"><?= e(t('admin.nl.desktop')) ?></option><option value="390"<?= $width === 390 ? ' selected' : '' ?>><?= e(t('admin.nl.mobile')) ?></option></select>
    <button class="btn btn--small btn--ghost" type="submit"><?= e(t('admin.nl.update_preview')) ?></button>
  </form>
  <p class="muted"><?= e($profile === [] ? t('admin.nl.profile_all') : t('admin.nl.profile_some')) ?><?= $open === null ? ' ' . e(t('admin.nl.draft_note')) : '' ?></p>
  <div class="nl-frame<?= $width === 390 ? ' nl-frame--390' : '' ?>">
    <iframe src="<?= e($previewUrl) ?>" title="<?= e(t('admin.nl.preview')) ?>" loading="lazy"></iframe>
  </div>
</section>
</div>
