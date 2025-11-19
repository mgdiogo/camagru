<?php

/*
 * Props:
 * - label (string|null)     : Input field label
 * - text (string|null)     : Input field placeholder text
 * - type (string)      : Input field type (e.g text, password)
 * - id (string|null)    	: Element id
 * - name (string|null)      : Element name
 * - errorId (string|null)   : Error element id
 * - classes (string)   : CSS classes
*/

$label = $props['label'] ?? '';
$text = $props['text'] ?? '';
$type = $props['type'] ?? 'text';
$id = $props['id'] ?? '';
$name = $props['name'] ?? '';
$errorId = $props['errorId'] ?? '';
$classes = $props['classes'] ?? '';
$input = $props['input'] ?? false

?>

<?php if ($input): ?>
	<div class="flex flex-col gap-2">
		<label class="font-medium font-[Montserrat] text-[#3E3E3E] text-sm"><?= htmlspecialchars(string: $label) ?></label>
		<input type="<?= htmlspecialchars($type) ?>" id="<?= htmlspecialchars($id) ?>" name="<?= htmlspecialchars($name) ?>" class="block flex font-normal font-[Montserrat] text-sm rounded-lg border border-[#A6A6A6] py-3.5 px-[1.125rem] gap-2.5 h-11 <?= htmlspecialchars($classes) ?>">
		<p class="text-[#AA1616] font-medium font-[Montserrat] text-sm hidden" id="<?= htmlspecialchars($errorId) ?>"></p>
	</div>
<?php else: ?>
	<div class="flex flex-col gap-2">
		<p class="font-medium font-[Montserrat] text-sm"><?= htmlspecialchars(string: $label) ?></p>
		<p class="font-bold font-[Montserrat] text-xl"><?= htmlspecialchars($text)?></p>
	</div>
<?php endif; ?>