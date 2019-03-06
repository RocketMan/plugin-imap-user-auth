<div class="panel">
    <h3>IMAP User Authentication</h3>

    <p class="form-help"><a href="https://github.com/RocketMan/plugin-imap-user-auth#configuration" target="_blank"><?= t('Help on IMAP User Authentication configuration') ?></a></p>

    <?= $this->form->label(t('Domain'), 'plugin_imap_user_auth_domain') ?>
    <?= $this->form->text('plugin_imap_user_auth_domain', $values) ?>

    <?= $this->form->label(t('IMAP Server'), 'plugin_imap_user_auth_mailbox') ?>
    <?= $this->form->text('plugin_imap_user_auth_mailbox', $values) ?>

    <div class="form-actions">
        <button class="btn btn-blue"><?= t('Save') ?></button>
    </div>
</div>