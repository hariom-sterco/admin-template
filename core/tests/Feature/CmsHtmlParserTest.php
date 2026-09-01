<?php

use App\Services\CmsHtmlParser;

it('parses html attributes into fields config, mapping config, and defaults', function () {
    $parser = new CmsHtmlParser();

    $html = <<<HTML
<div>
    <h1 data-text="title">My title</h1>
    <p data-textarea="description">This is a description.</p>
    <img data-image="hero_image" src="/images/hero.png" />
    <a data-link="cta_link" href="/signup">Sign Up</a>
    <section data-repeatable="features">
        <div>
            <h3 data-text="title">Feature A</h3>
            <p data-textarea="summary">Short summary</p>
        </div>
    </section>
</div>
HTML;

    $result = $parser->generate($html);

    expect($result)->toBeArray();
    expect($result['fields_config'])->toHaveCount(4);
    expect($result['mapping_config'])->toHaveCount(1);
    expect($result['defaults']['data'])->toMatchArray([
        'title' => 'My title',
        'description' => 'This is a description.',
        'hero_image' => '/images/hero.png',
        'cta_link' => [
            'text' => 'Sign Up',
            'url' => '/signup',
        ],
    ]);

    expect($result['fields_config'][0])->toMatchArray([
        'name' => 'title',
        'type' => 'text',
        'label' => 'Title',
    ]);
    expect($result['fields_config'][1])->toMatchArray([
        'name' => 'description',
        'type' => 'textarea',
        'label' => 'Description',
    ]);
    expect($result['fields_config'][2])->toMatchArray([
        'name' => 'hero_image',
        'type' => 'image',
        'label' => 'Hero Image',
    ]);
    expect($result['fields_config'][3])->toMatchArray([
        'name' => 'cta_link',
        'type' => 'link',
        'label' => 'Cta Link',
    ]);

    expect($result['mapping_config'][0]['group_name'])->toBe('features');
    expect($result['mapping_config'][0]['parent_group'])->toBeNull();
    expect($result['mapping_config'][0]['fields'][0])->toMatchArray([
        'name' => 'title',
        'type' => 'text',
        'label' => 'Title',
        'required' => false,
        'placeholder' => '',
        'default' => 'Feature A',
    ]);
    expect($result['mapping_config'][0]['fields'][1])->toMatchArray([
        'name' => 'summary',
        'type' => 'textarea',
        'label' => 'Summary',
        'required' => false,
        'placeholder' => '',
        'default' => 'Short summary',
    ]);

    expect($result['defaults']['mapping_items'])->toHaveKey('features');
    expect($result['defaults']['mapping_items']['features'][0])->toMatchArray([
        'title' => 'Feature A',
        'summary' => 'Short summary',
    ]);
});

it('supports repeatable fields from a top-level element and outputs item placeholders', function () {
    $parser = new CmsHtmlParser();

    $html = <<<HTML
<p data-repeatable="para" data-text="content">Lorem ipsum dolor sit amet.</p>
HTML;

    $result = $parser->generate($html);

    expect($result['mapping_config'][0]['group_name'])->toBe('para');
    expect($result['mapping_config'][0]['parent_group'])->toBeNull();
    expect($result['mapping_config'][0]['fields'][0])->toMatchArray([
        'name' => 'content',
        'type' => 'text',
        'label' => 'Content',
        'required' => false,
        'placeholder' => '',
        'default' => 'Lorem ipsum dolor sit amet.',
    ]);

    expect($result['template'])->toContain('{item.content}');
    expect($result['defaults']['mapping_items']['para'][0])->toMatchArray([
        'content' => 'Lorem ipsum dolor sit amet.',
    ]);
});
