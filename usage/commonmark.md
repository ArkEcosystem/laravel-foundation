# Laravel CommonMark

> CommonMark for Laravel. Powered by league/commonmark.

## Installation

1. Publish all the assets / views with `php artisan vendor:publish --provider="ARKEcosystem\Foundation\Providers\CommonMarkServiceProvider" --tag=config`.

## Usage

This package provides parsing and rendering for CommonMark. All the specifications and examples can be seen at https://commonmark.org/. There are a few custom elements that can be used to embed third-party content.

### Embed SimpleCast

```markdown
![](simplecast:0275fefa-b0e5-4558-b876-09deb95386e6)
```

### Embed Twitter

```markdown
![](twitter:laravelnews/status/1315392740537044995)
```

### Embed YouTube

```markdown
![](youtube:Mb-oVVctwyc)
```
