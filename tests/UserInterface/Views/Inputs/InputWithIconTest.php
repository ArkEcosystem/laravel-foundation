<?php

declare(strict_types=1);

it('should render with the given name', function (): void {
    $this
        ->blade('<x-ark::inputs.input-with-icon name="username" />')
        ->assertSeeHtml('type="text"')
        ->assertSeeHtml('name="username"')
        ->assertSeeHtml('wire:model="username"');
});

it('should render with the given label', function (): void {
    $this
        ->blade('<x-ark::inputs.input-with-icon name="username" label="Fancy Label" />>')
        ->assertSee('Fancy Label');
});

it('should render with the given type', function (): void {
    $this
        ->blade('<x-ark::inputs.input-with-icon name="username" type="number" />')
        ->assertSeeHtml('type="number"');
});

it('should render with the given id', function (): void {
    $this
        ->blade('<x-ark::inputs.input-with-icon name="username" id="uniqueid" />')
        ->assertSeeHtml('id="uniqueid"');
});

it('should render with the given model', function (): void {
    $this
        ->blade('<x-ark::inputs.input-with-icon name="username" model="username_model" />')
        ->assertSeeHtml('type="text"')
        ->assertSeeHtml('name="username"')
        ->assertSeeHtml('wire:model="username_model"');
});

it('should render with the given placeholder', function (): void {
    $this
        ->blade('<x-ark::inputs.input-with-icon name="username" placeholder="placeholder" />')
        ->assertSeeHtml('placeholder="placeholder"');
});

it('should render with the given value', function (): void {
    $this
        ->blade('<x-ark::inputs.input-with-icon name="username" value="value" />')
        ->assertSeeHtml('value="value"');
});

it('should render with the given keydownEnter', function (): void {
    $this
        ->blade('<x-ark::inputs.input-with-icon name="username" keydownEnter="function" />')
        ->assertSeeHtml('wire:keydown.enter="function"');
});

it('should render with the given max', function (): void {
    $this
        ->blade('<x-ark::inputs.input-with-icon name="username" :max="1" />')
        ->assertSeeHtml('maxlength="1"');
});

it('should render with the given autocomplete', function (): void {
    $this
        ->blade('<x-ark::inputs.input-with-icon name="username" autocomplete="autocomplete" />')
        ->assertSeeHtml('autocomplete="autocomplete"');
});

it('should render as readonly', function (): void {
    $this
        ->blade('<x-ark::inputs.input-with-icon name="username" readonly />')
        ->assertSeeHtml('readonly');
});

it('should render without the label', function (): void {
    $this
        ->blade('<x-ark::inputs.input-with-icon name="username" :hide-label="true" />')
        ->assertDontSee('<label', escape: false);
});

it('should render with the given input mode', function (): void {
    $this
        ->blade('<x-ark::inputs.input-with-icon name="username" inputmode="inputmode" />')
        ->assertSeeHtml('inputmode="inputmode"');
});

it('should render with the given pattern', function (): void {
    $this
        ->blade('<x-ark::inputs.input-with-icon name="username" pattern="pattern" />')
        ->assertSeeHtml('pattern="pattern"');
});

it('should render with the given class', function (): void {
    $this
        ->blade('<x-ark::inputs.input-with-icon name="username" class="class" />')
        ->assertSeeHtml('<div class="class">');
});

it('should render with the given inputClass', function (): void {
    $this
        ->blade('<x-ark::inputs.input-with-icon name="username" inputClass="inputClass" />')
        ->assertSeeHtml('class="inputClass');
});

it('should render with the given containerClass', function (): void {
    $this
        ->blade('<x-ark::inputs.input-with-icon name="username" containerClass="containerClass" />')
        ->assertSeeHtml('containerClass"');
});

it('should render error styling for a label', function (): void {
    $this
        ->withViewErrors([
            'username' => ['required'],
        ])
        ->blade('<x-ark::inputs.input-with-icon name="username" />')
        ->assertSeeHtml('input-label--error');
});

it('should render error styling for an input', function (): void {
    $this
        ->withViewErrors([
            'username' => ['required'],
        ])
        ->blade('<x-ark::inputs.input-with-icon name="username" />')
        ->assertSeeHtml('input-text-with-icon--error');
});

it('should render an error message', function (): void {
    $this
        ->withViewErrors([
            'username' => ['This is required.'],
        ])
        ->blade('<x-ark::inputs.input-with-icon name="username" />')
        ->assertSeeHtml('<p class="input-help--error">This is required.</p>');
});

it('should render with the given slot', function (): void {
    $this
        ->blade('<x-ark::inputs.input-with-icon name="username">Hello World</x-ark::inputs.input-with-icon>')
        ->assertSeeHtml('Hello World');
});

it('should render with the given slotClass', function (): void {
    $this
        ->blade('<x-ark::inputs.input-with-icon name="username" slotClass="slotClass">Hello World</x-ark::inputs.input-with-icon>')
        ->assertSeeHtml('Hello World')
        ->assertSeeHtml('slotClass"');
});

it('should render a default slotClass', function (): void {
    $this
        ->blade('<x-ark::inputs.input-with-icon name="username">Hello World</x-ark::inputs.input-with-icon>')
        ->assertSeeHtml('Hello World')
        ->assertSeeHtml('h-full');
});

it('should render with the ID as label target', function (): void {
    $this
        ->blade('<x-ark::inputs.input-with-icon name="username" id="id" />')
        ->assertSeeHtml('for="id"');
});
