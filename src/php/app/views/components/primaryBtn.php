<?php

/*
 * Props:
 * - text (string)       : Text to show
 * - icon (string|null)  : Optional icon path
 * - id (string|null)    : Element id
 * - classes (string)    : CSS classes
 * - type (string)       : 'button' or 'submit'
 * - disabled (bool)     : Disabled (for buttons)
 * - form (string|null)  : Form id (for submit buttons)
 * - href (string|null)  : If set, renders <a> instead of <button>
*/

$text = $props['text'] ?? 'Button';
$icon = $props['icon'] ?? '';
$id = $props['id'] ?? '';
$classes = $props['classes'] ?? '';
$type = $props['type'] ?? 'button';
$disabled = $props['disabled'] ?? false;
$form = $props['form'] ?? '';
$href = $props['href'] ?? '';

$disabledAttr = $disabled ? 'disabled' : '';
$formAttr = $form ? 'form="'.$form.'"' : '';
?>
<?php if ($href): ?>
    <a href="<?= htmlspecialchars($href) ?>" id="<?= htmlspecialchars($id) ?>" class="flex flex-row justify-center items-center h-8 md:py-2 md:px-2.5 rounded-md bg-black hover:bg-[#444444] text-white font-medium font-[Montserrat] text-sm gap-2.5 <?= htmlspecialchars($classes) ?>">
        <?php if ($icon): ?>
            <img class="w-4 h-4" src="<?= htmlspecialchars($icon) ?>">
        <?php endif; ?>
		<span class="hidden md:inline"><?= htmlspecialchars($text) ?></span>
    </a>
<?php else: ?>
    <button 
        type="<?= htmlspecialchars($type) ?>" 
        id="<?= htmlspecialchars($id) ?>" 
        <?= $disabledAttr ?> <?= $formAttr ?> 
        class="flex flex-row justify-center items-center h-8 md:py-2 md:px-2.5 rounded-md bg-black hover:bg-[#444444] text-white font-medium font-[Montserrat] text-sm gap-2.5 <?= htmlspecialchars($classes) ?>"
    >
        <?php if ($icon): ?>
            <img class="w-4 h-4" src="<?= htmlspecialchars($icon) ?>">
        <?php endif; ?>
        <?= htmlspecialchars($text) ?>
    </button>
<?php endif; ?>
