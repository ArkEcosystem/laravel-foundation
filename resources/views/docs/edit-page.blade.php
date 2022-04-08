<a
    href="{{ config('web.github_source') }}/tree/master/{{$document->type}}/{{$document->slug}}.md.blade.php"
    target="_blank"
    rel="noopener nofollow noreferrer"
    class="flex items-center pl-5 space-x-3 font-semibold link"
>
    @svg('pencil', 'h-4 w-4')
    <span>@lang('ui::actions.docs.edit_page')</span>
</a>
