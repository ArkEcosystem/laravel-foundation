<?php

declare(strict_types=1);

use Illuminate\Support\MessageBag;
use Illuminate\Support\ViewErrorBag;
use function Tests\createAttributes;

it('should render with an icon', function (): void {
    $this
        ->view('ark::inputs.input-with-prefix', createAttributes([
            'icon' => 'brands.outline.facebook',
            'slot' => '',
        ]))
        ->assertSeeHtml('type="text"')
        ->assertSeeHtml('name="username"')
        ->assertSeeHtml('wire:model="username"');
});

it('should render with the given name', function (): void {
    $this
        ->view('ark::inputs.input-with-prefix', createAttributes([
            'icon' => 'brands.outline.facebook',
            'slot' => '',
            'name' => 'username',
        ]))
        ->assertSeeHtml('type="text"')
        ->assertSeeHtml('name="username"')
        ->assertSeeHtml('wire:model="username"');
});

it('should render with the given label', function (): void {
    $this
        ->view('ark::inputs.input-with-prefix', createAttributes([
            'icon'  => 'brands.outline.facebook',
            'slot'  => '',
            'label' => 'Fancy Label',
        ]))
        ->assertSeeHtml('Fancy Label');
});

it('should render with the given type', function (): void {
    $this
        ->view('ark::inputs.input-with-prefix', createAttributes([
            'icon' => 'brands.outline.facebook',
            'slot' => '',
            'type' => 'number',
        ]))
        ->assertSeeHtml('type="number"');
});

it('should render with the given id', function (): void {
    $this
        ->view('ark::inputs.input-with-prefix', createAttributes([
            'icon' => 'brands.outline.facebook',
            'slot' => '',
            'id'   => 'uniqueid',
        ]))
        ->assertSeeHtml('id="uniqueid"');
});

it('should render with the given model', function (): void {
    $this
        ->view('ark::inputs.input-with-prefix', createAttributes([
            'icon'  => 'brands.outline.facebook',
            'slot'  => '',
            'model' => 'username_model',
        ]))
        ->assertSeeHtml('type="text"')
        ->assertSeeHtml('name="username"')
        ->assertSeeHtml('wire:model="username_model"');
});

it('should render with the given model, but deferred', function (): void {
    $this
        ->view('ark::inputs.input-with-prefix', createAttributes([
            'icon'     => 'brands.outline.facebook',
            'slot'     => '',
            'model'    => 'username_model',
            'deferred' => true,
        ]))
        ->assertSeeHtml('type="text"')
        ->assertSeeHtml('name="username"')
        ->assertSeeHtml('wire:model.defer="username_model"');
});

it('should render with the given placeholder', function (): void {
    $this
        ->view('ark::inputs.input-with-prefix', createAttributes([
            'icon'        => 'brands.outline.facebook',
            'slot'        => '',
            'placeholder' => 'placeholder',
        ]))
        ->assertSeeHtml('placeholder="placeholder"');
});

it('should render with the given value', function (): void {
    $this
        ->view('ark::inputs.input-with-prefix', createAttributes([
            'icon'  => 'brands.outline.facebook',
            'slot'  => '',
            'value' => 'value',
        ]))
        ->assertSeeHtml('value="value"');
});

it('should render with the given wire:keydown.enter', function (): void {
    $this
        ->view('ark::inputs.input-with-prefix', createAttributes([
            'icon'               => 'brands.outline.facebook',
            'slot'               => '',
            'wire:keydown.enter' => 'function',
        ]))
        ->assertSeeHtml('wire:keydown.enter="function"');
});

it('should render with the given maxlength', function (): void {
    $this
        ->view('ark::inputs.input-with-prefix', createAttributes([
            'icon'       => 'brands.outline.facebook',
            'slot'       => '',
            'maxlength'  => 1,
        ]))
        ->assertSeeHtml('maxlength="1"');
});

it('should render with the given autocomplete', function (): void {
    $this
        ->view('ark::inputs.input-with-prefix', createAttributes([
            'icon'         => 'brands.outline.facebook',
            'slot'         => '',
            'autocomplete' => 'autocomplete',
        ]))
        ->assertSeeHtml('autocomplete="autocomplete"');
});

it('should render as readonly', function (): void {
    $this
        ->view('ark::inputs.input-with-prefix', createAttributes([
            'icon'     => 'brands.outline.facebook',
            'slot'     => '',
            'readonly' => true,
        ]))
        ->assertSeeHtml('readonly');
});

it('should render without the label', function (): void {
    $this
        ->view('ark::inputs.input-with-prefix', createAttributes([
            'icon'      => 'brands.outline.facebook',
            'slot'      => '',
            'hideLabel' => true,
        ]))
        ->assertDontSee('<label', escape: false);
});

it('should render with the given input mode', function (): void {
    $this
        ->view('ark::inputs.input-with-prefix', createAttributes([
            'icon'      => 'brands.outline.facebook',
            'slot'      => '',
            'inputmode' => 'inputmode',
        ]))
        ->assertSeeHtml('inputmode="inputmode"');
});

it('should render with the given pattern', function (): void {
    $this
        ->view('ark::inputs.input-with-prefix', createAttributes([
            'icon'    => 'brands.outline.facebook',
            'slot'    => '',
            'pattern' => 'pattern',
        ]))
        ->assertSeeHtml('pattern="pattern"');
});

it('should render with the given class', function (): void {
    $this
        ->view('ark::inputs.input-with-prefix', createAttributes([
            'icon'  => 'brands.outline.facebook',
            'slot'  => '',
            'class' => 'test-input-class',
        ]))
        ->assertSeeHtml('class="test-input-class"');
});

it('should render with the given inputClass', function (): void {
    $this
        ->view('ark::inputs.input-with-prefix', createAttributes([
            'icon'       => 'brands.outline.facebook',
            'slot'       => '',
            'inputClass' => 'inputClass',
        ]))
        ->assertSeeHtml('class="inputClass');
});

it('should render with the given containerClass', function (): void {
    $this
        ->view('ark::inputs.input-with-prefix', createAttributes([
            'icon'           => 'brands.outline.facebook',
            'slot'           => '',
            'containerClass' => 'containerClass',
        ]))
        ->assertSeeHtml('containerClass"');
});

it('should render error styling for a label', function (): void {
    $errors = new ViewErrorBag();
    $errors->put('default', new MessageBag(['username' => ['required']]));

    $this
        ->view('ark::inputs.input-with-prefix', createAttributes([
            'icon'       => 'brands.outline.facebook',
            'slot'       => '',
            'errors'     => $errors,
            'inputClass' => 'inputClass',
        ]))
        ->assertSeeHtml('input-label--error');
});

it('should render error styling for an input', function (): void {
    $errors = new ViewErrorBag();
    $errors->put('default', new MessageBag(['username' => ['required']]));

    $this
        ->view('ark::inputs.input-with-prefix', createAttributes([
            'icon'       => 'brands.outline.facebook',
            'slot'       => '',
            'errors'     => $errors,
            'inputClass' => 'inputClass',
        ]))
        ->assertSeeHtml('input-text--error');
});

it('should render an error message', function (): void {
    $errors = new ViewErrorBag();
    $errors->put('default', new MessageBag(['username' => ['This is required.']]));

    $this
        ->view('ark::inputs.input-with-prefix', createAttributes([
            'icon'       => 'brands.outline.facebook',
            'slot'       => '',
            'errors'     => $errors,
            'inputClass' => 'inputClass',
        ]))
        ->assertSeeHtml('data-tippy-content="This is required."');
});

it('should render with the ID as label target', function (): void {
    $this
        ->view('ark::inputs.input-with-prefix', createAttributes([
            'icon' => 'brands.outline.facebook',
            'slot' => '',
            'id'   => 'id',
        ]))
        ->assertSeeHtml('for="id"');
});

it('should render the slot content', function (): void {
    $this
        ->view('ark::inputs.input-with-prefix', createAttributes([
            'icon'       => 'brands.outline.facebook',
            'slot'       => '<p>testy</p>',
        ]))
        ->assertSeeHtml('<p>testy</p>');
});
